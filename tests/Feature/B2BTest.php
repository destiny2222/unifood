<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kyc;
use App\Models\Product;
use App\Models\Category;
use App\Models\ShippingRate;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class B2BTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test B2B registration and success with a new email.
     */
    public function test_new_b2b_user_registration()
    {
        $response = $this->postJson('/api/v1/b2b/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'token', 'data']);

        $user = User::where('email', 'john@example.com')->first();

        // Submit KYC details separately
        $kycResponse = $this->actingAs($user, 'sanctum')->postJson('/api/v1/kyc', [
            'company_name' => 'Acme Corp',
            'company_registration_number' => 'VAT-12345-67',
            'business_type' => 'restaurant',
            'trade_address' => '123 Business Rd',
            'billing_contact' => 'John Doe',
            'estimated_monthly_order_volume' => '£5,000',
        ]);

        $kycResponse->assertStatus(201)
                    ->assertJsonStructure(['message', 'data']);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'is_business_owner' => true,
            'current_view' => 'business',
        ]);

        $this->assertDatabaseHas('kycs', [
            'company_name' => 'Acme Corp',
            'status' => 'pending',
        ]);
    }

    /**
     * Test comprehensive multi-section KYC submission with document uploads.
     */
    public function test_comprehensive_multisection_kyc_submission_with_document_uploads()
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $user = User::factory()->create([
            'email' => 'stronger_kyc@example.com',
        ]);

        $cert = \Illuminate\Http\UploadedFile::fake()->create('incorporation.pdf', 200, 'application/pdf');
        $bankStatement = \Illuminate\Http\UploadedFile::fake()->create('bank_statement.pdf', 300, 'application/pdf');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/kyc', [
            'registered_business_name' => 'Mightyolu Wholesale Supplies Ltd',
            'trading_name' => 'Mightyolu Trading',
            'business_type' => 'limited_company',
            'company_registration_number' => 'REG-998877',
            'vat_registration_number' => 'GB123456789',
            'date_business_established' => '2020-01-15',
            'nature_of_business' => 'Food Retail & Distribution',
            'business_website' => 'https://mightyolu.com',

            'address_line_1' => '100 Trade House',
            'address_line_2' => 'Docklands Business Park',
            'city' => 'London',
            'postcode' => 'E14 9QJ',
            'country' => 'United Kingdom',

            'primary_contact_name' => 'Sarah Connor',
            'primary_contact_position' => 'Procurement Manager',
            'primary_contact_email' => 'sarah@mightyolu.com',
            'primary_contact_phone' => '+447700900123',
            'preferred_contact_method' => 'telephone',

            'owner_full_name' => 'Alexander Mighty',
            'owner_position' => 'CEO',
            'owner_nationality' => 'British',
            'owner_dob' => '1985-06-12',
            'owner_residential_address' => '12 Park Lane, London, W1K 1AA',

            'certificate_of_incorporation' => $cert,
            'business_bank_statement' => $bankStatement,

            'primary_products_of_interest' => 'Rice, Palm Oil, Spices',
            'estimated_monthly_purchase_value' => 'Over £10,000',
            'expected_order_frequency' => 'weekly',
            'purpose_of_purchase' => 'restaurant_catering',
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.company_name', 'Mightyolu Wholesale Supplies Ltd')
                 ->assertJsonPath('data.trading_name', 'Mightyolu Trading')
                 ->assertJsonPath('data.vat_registration_number', 'GB123456789')
                 ->assertJsonPath('data.expected_order_frequency', 'weekly');

        $this->assertDatabaseHas('kycs', [
            'user_id' => $user->id,
            'company_name' => 'Mightyolu Wholesale Supplies Ltd',
            'trading_name' => 'Mightyolu Trading',
            'owner_full_name' => 'Alexander Mighty',
            'estimated_monthly_order_volume' => 'Over £10,000',
            'expected_order_frequency' => 'weekly',
            'status' => 'pending',
        ]);
    }

    /**
     * Test B2B registration custom format validation.
     */
    public function test_b2b_registration_format_validation()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/kyc', [
            'company_name' => 'Acme Corp',
            'company_registration_number' => 'V', // too short, regex fails
            'business_type' => 'restaurant',
            'trade_address' => '123 Business Rd',
            'billing_contact' => 'John Doe',
            'estimated_monthly_order_volume' => '£5,000',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['company_registration_number']);
    }

    /**
     * Test existing B2C user logs in and applies for B2B.
     */
    public function test_existing_b2c_user_logs_in_and_submits_kyc()
    {
        $user = User::factory()->create([
            'email' => 'b2c@example.com',
            'password' => Hash::make('personal-password'),
        ]);

        $loginResponse = $this->postJson('/api/v1/b2b/login', [
            'email' => 'b2c@example.com',
            'password' => 'personal-password',
        ]);

        $loginResponse->assertStatus(200);

        $kycResponse = $this->actingAs($user, 'sanctum')->postJson('/api/v1/kyc', [
            'company_name' => 'B2C Corp',
            'company_registration_number' => 'B2C-12345',
            'business_type' => 'retailer',
            'trade_address' => '456 Retail St',
            'billing_contact' => 'B2C Contact',
            'estimated_monthly_order_volume' => '£10,000',
        ]);

        $kycResponse->assertStatus(201);
        $user->refresh();

        $this->assertNotNull($user->kyc);
        $this->assertTrue((bool)$user->is_business_owner);
        $this->assertEquals('business', $user->current_view);
        $this->assertEquals('pending', $user->kyc->status);
    }

    /**
     * Test B2B login API.
     */
    public function test_b2b_login()
    {
        $user = User::factory()->create([
            'email' => 'b2b@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/b2b/login', [
            'email' => 'b2b@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'data']);
    }

    /**
     * Test profile view switcher.
     */
    public function test_b2b_view_switcher()
    {
        $user = User::factory()->create([
            'email' => 'b2b@example.com',
            'current_view' => 'personal',
        ]);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Switchee Corp',
            'company_registration_number' => 'VAT-123',
            'business_type' => 'retailer',
            'trade_address' => '123 Rd',
            'billing_contact' => 'Switchee',
            'estimated_monthly_order_volume' => '£1,000',
            'status' => 'pending',
        ]);
        $user->update(['kyc_id' => $kyc->id]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/switch-view');
        $response->assertStatus(200)
                 ->assertJson(['current_view' => 'business']);

        $user->refresh();
        $this->assertEquals('business', $user->current_view);

        $response2 = $this->actingAs($user, 'sanctum')->postJson('/api/v1/switch-view');
        $response2->assertStatus(200)
                  ->assertJson(['current_view' => 'personal']);
    }

    /**
     * Test product scope filters products correctly for B2B vs B2C.
     */
    public function test_product_scope_filtering()
    {
        $category = Category::create(['title' => 'Produce', 'slug' => 'produce']);

        $retailProduct = Product::create([
            'title' => 'Standard Apple',
            'slug' => 'standard-apple',
            'price' => 1.50,
            'is_b2b' => false,
            'category_id' => $category->id,
            'description' => 'A sweet apple',
        ]);

        $wholesaleProduct = Product::create([
            'title' => 'Wholesale Apple Box',
            'slug' => 'wholesale-apple-box',
            'price' => 50.00,
            'is_b2b' => true,
            'category_id' => $category->id,
            'description' => 'A crate of fresh apples',
        ]);

        // 1. Unauthenticated/B2C User should only see retail products
        $this->assertCount(1, Product::forUser()->get());
        $this->assertEquals('Standard Apple', Product::forUser()->first()->title);

        // 2. Authenticated Approved B2B User in business view should only see B2B products
        $user = User::factory()->create(['current_view' => 'business']);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Acme Apple',
            'company_registration_number' => 'APPLE-1',
            'business_type' => 'reseller',
            'trade_address' => 'Apple Orchard',
            'billing_contact' => 'Apple Guy',
            'estimated_monthly_order_volume' => '100',
            'status' => 'approved',
        ]);
        $user->update(['kyc_id' => $kyc->id]);

        $this->actingAs($user, 'web');
        $this->assertCount(1, Product::forUser()->get());
        $this->assertEquals('Wholesale Apple Box', Product::forUser()->first()->title);
    }

    /**
     * Test B2B checkout restrictions (blocked when pending/rejected, allowed when approved).
     */
    public function test_checkout_blocks_unapproved_b2b()
    {
        $user = User::factory()->create(['current_view' => 'business']);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Acme Pending',
            'company_registration_number' => 'PENDING-1',
            'business_type' => 'reseller',
            'trade_address' => 'Pending Rd',
            'billing_contact' => 'Pending Guy',
            'estimated_monthly_order_volume' => '100',
            'status' => 'pending',
        ]);
        $user->update(['kyc_id' => $kyc->id]);

        $this->actingAs($user, 'web');

        // Verify checkout returns 403 or redirects back with error
        $response = $this->get('/dashboard/checkout');
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Your trade account is pending approval or has not been approved. Checkout is currently disabled.');
    }

    /**
     * Test adding authorized buyers under approved trade account.
     */
    public function test_add_authorized_buyers()
    {
        $user = User::factory()->create([
            'current_view' => 'business',
            'is_business_owner' => true,
        ]);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Main Business',
            'company_registration_number' => 'REG-1',
            'business_type' => 'retailer',
            'trade_address' => 'Business St',
            'billing_contact' => 'Owner',
            'estimated_monthly_order_volume' => '100',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/authorized-buyers', [
            'name' => 'Authorized Buyer',
            'email' => 'buyer@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test B2B cart listing, adding, updating, and deleting.
     */
    public function test_b2b_cart_operations()
    {
        $user = User::factory()->create(['current_view' => 'business']);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Trade Corp',
            'company_registration_number' => 'TRADE-123',
            'business_type' => 'retailer',
            'trade_address' => 'Business St',
            'billing_contact' => 'John',
            'estimated_monthly_order_volume' => '100',
            'status' => 'approved',
        ]);

        $category = Category::create(['title' => 'Produce', 'slug' => 'produce']);
        $product = Product::create([
            'title' => 'Wholesale Apple Box',
            'slug' => 'wholesale-apple-box',
            'price' => 50.00,
            'is_b2b' => true,
            'minimum_order_quantity' => 5,
            'category_id' => $category->id,
            'description' => 'Crate of apples',
        ]);

        $this->actingAs($user, 'sanctum');

        // 1. Add to B2B cart below MOQ should fail
        $addResponseFail = $this->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $addResponseFail->assertStatus(400)
                        ->assertJsonPath('error', 'Minimum order quantity is 5.');

        // 2. Add to B2B cart at or above MOQ should succeed
        $addResponse = $this->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
        $addResponse->assertStatus(201);

        $this->assertDatabaseHas('b2_b_carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        // 3. List B2B cart
        $listResponse = $this->getJson('/api/v1/cart');
        $listResponse->assertStatus(200)
                     ->assertJsonCount(1, 'items')
                     ->assertJsonPath('total_price', 250);

        $cartItemId = $listResponse->json('items.0.id');

        // 4. Update quantity below MOQ should fail
        $updateResponseFail = $this->putJson("/api/v1/cart/{$cartItemId}", [
            'quantity' => 3,
        ]);
        $updateResponseFail->assertStatus(400);

        // 5. Update quantity at or above MOQ should succeed
        $updateResponse = $this->putJson("/api/v1/cart/{$cartItemId}", [
            'quantity' => 8,
        ]);
        $updateResponse->assertStatus(200);

        $this->assertDatabaseHas('b2_b_carts', [
            'id' => $cartItemId,
            'quantity' => 8,
        ]);

        // 6. Remove item
        $deleteResponse = $this->deleteJson("/api/v1/cart/{$cartItemId}");
        $deleteResponse->assertStatus(200);

        $this->assertDatabaseMissing('b2_b_carts', [
            'id' => $cartItemId,
        ]);
    }

    /**
     * Test B2B checkout details retrieval and order processing.
     */
    public function test_b2b_checkout_flow()
    {
        $user = User::factory()->create(['current_view' => 'business']);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Trade Corp',
            'company_registration_number' => 'TRADE-123',
            'business_type' => 'retailer',
            'trade_address' => 'Business St',
            'billing_contact' => 'John',
            'estimated_monthly_order_volume' => '100',
            'status' => 'approved',
        ]);

        $category = Category::create(['title' => 'Produce', 'slug' => 'produce']);
        $product = Product::create([
            'title' => 'Wholesale Apple Box',
            'slug' => 'wholesale-apple-box',
            'price' => 50.00,
            'is_b2b' => true,
            'category_id' => $category->id,
            'description' => 'Crate of apples',
        ]);

        $shippingRate = ShippingRate::create([
            'delivery_type' => 'next_day',
            'price' => 5.00,
            'min_weight' => 0.0,
            'max_weight' => 100.0,
        ]);

        $this->actingAs($user, 'sanctum');

        // Add item to B2B cart
        \App\Models\B2BCart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 50.00,
        ]);

        // 1. Get Checkout details
        $detailsResponse = $this->getJson('/api/v1/checkout');
        $detailsResponse->assertStatus(200)
                        ->assertJsonPath('subtotal', 100)
                        ->assertJsonPath('total_price', 95);

        // 2. Submit B2B Checkout
        $checkoutResponse = $this->postJson('/api/v1/checkout', [
            'payment_method' => 'card',
            'ship-address' => 'default',
            'city' => 'London',
            'state' => 'Greater London',
            'country' => 'United Kingdom',
            'postal_code' => 'SW1A 1AA',
            'shipping_rate_id' => $shippingRate->id,
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        $checkoutResponse->assertStatus(201)
                         ->assertJsonStructure(['order', 'checkout_url']);

        $this->assertDatabaseHas('purchase_order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 50.00,
        ]);

        // Cart should be cleared after order creation
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test me endpoint and switch-context endpoint.
     */
    public function test_user_me_and_switch_context()
    {
        $user = User::factory()->create(['current_view' => 'personal']);
        $kyc = Kyc::create([
            'user_id' => $user->id,
            'company_name' => 'Trade Corp',
            'company_registration_number' => 'TRADE-123',
            'business_type' => 'retailer',
            'trade_address' => 'Business St',
            'billing_contact' => 'John',
            'estimated_monthly_order_volume' => '100',
            'status' => 'pending',
        ]);
        $user->update(['kyc_id' => $kyc->id]);

        $this->actingAs($user, 'sanctum');

        // 1. Get user profile
        $response = $this->getJson('/api/v1/user/me');
        $response->assertStatus(200)
                 ->assertJsonPath('b2b_status', 'pending')
                 ->assertJsonPath('current_view', 'personal');

        // 2. Switch context
        $switchResponse = $this->postJson('/api/v1/account/switch-context');
        $switchResponse->assertStatus(200)
                       ->assertJsonPath('current_view', 'business');

        $user->refresh();
        $this->assertEquals('business', $user->current_view);
    }
}
