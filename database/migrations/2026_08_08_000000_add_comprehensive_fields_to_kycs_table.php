<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            // Section 1 - Business Information additions
            if (!Schema::hasColumn('kycs', 'trading_name')) {
                $table->string('trading_name')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('kycs', 'vat_registration_number')) {
                $table->string('vat_registration_number')->nullable()->after('company_registration_number');
            }
            if (!Schema::hasColumn('kycs', 'date_business_established')) {
                $table->date('date_business_established')->nullable()->after('vat_registration_number');
            }
            if (!Schema::hasColumn('kycs', 'nature_of_business')) {
                $table->string('nature_of_business')->nullable()->after('date_business_established');
            }
            if (!Schema::hasColumn('kycs', 'business_website')) {
                $table->string('business_website')->nullable()->after('nature_of_business');
            }

            // Section 2 - Registered Business Address additions
            if (!Schema::hasColumn('kycs', 'address_line_1')) {
                $table->string('address_line_1')->nullable()->after('trade_address');
            }
            if (!Schema::hasColumn('kycs', 'address_line_2')) {
                $table->string('address_line_2')->nullable()->after('address_line_1');
            }
            if (!Schema::hasColumn('kycs', 'city')) {
                $table->string('city')->nullable()->after('address_line_2');
            }
            if (!Schema::hasColumn('kycs', 'postcode')) {
                $table->string('postcode')->nullable()->after('city');
            }
            if (!Schema::hasColumn('kycs', 'country')) {
                $table->string('country')->nullable()->after('postcode');
            }

            // Section 3 - Primary Contact Details additions
            if (!Schema::hasColumn('kycs', 'primary_contact_name')) {
                $table->string('primary_contact_name')->nullable()->after('billing_contact');
            }
            if (!Schema::hasColumn('kycs', 'primary_contact_position')) {
                $table->string('primary_contact_position')->nullable()->after('primary_contact_name');
            }
            if (!Schema::hasColumn('kycs', 'primary_contact_email')) {
                $table->string('primary_contact_email')->nullable()->after('primary_contact_position');
            }
            if (!Schema::hasColumn('kycs', 'primary_contact_phone')) {
                $table->string('primary_contact_phone')->nullable()->after('primary_contact_email');
            }
            if (!Schema::hasColumn('kycs', 'preferred_contact_method')) {
                $table->string('preferred_contact_method')->default('email')->after('primary_contact_phone');
            }

            // Section 4 - Business Ownership / Responsible Person additions
            if (!Schema::hasColumn('kycs', 'owner_full_name')) {
                $table->string('owner_full_name')->nullable()->after('preferred_contact_method');
            }
            if (!Schema::hasColumn('kycs', 'owner_position')) {
                $table->string('owner_position')->nullable()->after('owner_full_name');
            }
            if (!Schema::hasColumn('kycs', 'owner_nationality')) {
                $table->string('owner_nationality')->nullable()->after('owner_position');
            }
            if (!Schema::hasColumn('kycs', 'owner_dob')) {
                $table->date('owner_dob')->nullable()->after('owner_nationality');
            }
            if (!Schema::hasColumn('kycs', 'owner_residential_address')) {
                $table->text('owner_residential_address')->nullable()->after('owner_dob');
            }

            // Section 5 - Business Verification Documents (Upload File Paths)
            if (!Schema::hasColumn('kycs', 'certificate_of_incorporation')) {
                $table->string('certificate_of_incorporation')->nullable()->after('owner_residential_address');
            }
            if (!Schema::hasColumn('kycs', 'proof_of_business_address')) {
                $table->string('proof_of_business_address')->nullable()->after('certificate_of_incorporation');
            }
            if (!Schema::hasColumn('kycs', 'vat_registration_certificate')) {
                $table->string('vat_registration_certificate')->nullable()->after('proof_of_business_address');
            }
            if (!Schema::hasColumn('kycs', 'business_bank_statement')) {
                $table->string('business_bank_statement')->nullable()->after('vat_registration_certificate');
            }
            if (!Schema::hasColumn('kycs', 'government_id')) {
                $table->string('government_id')->nullable()->after('business_bank_statement');
            }
            if (!Schema::hasColumn('kycs', 'proof_of_residential_address')) {
                $table->string('proof_of_residential_address')->nullable()->after('government_id');
            }
            if (!Schema::hasColumn('kycs', 'partnership_agreement')) {
                $table->string('partnership_agreement')->nullable()->after('proof_of_residential_address');
            }
            if (!Schema::hasColumn('kycs', 'sole_trader_evidence')) {
                $table->string('sole_trader_evidence')->nullable()->after('partnership_agreement');
            }
            if (!Schema::hasColumn('kycs', 'other_documents')) {
                $table->json('other_documents')->nullable()->after('sole_trader_evidence');
            }

            // Section 6 - Business Purchasing Information additions
            if (!Schema::hasColumn('kycs', 'primary_products_of_interest')) {
                $table->text('primary_products_of_interest')->nullable()->after('other_documents');
            }
            if (!Schema::hasColumn('kycs', 'expected_order_frequency')) {
                $table->string('expected_order_frequency')->nullable()->after('estimated_monthly_order_volume');
            }
            if (!Schema::hasColumn('kycs', 'purpose_of_purchase')) {
                $table->string('purpose_of_purchase')->nullable()->after('expected_order_frequency');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->dropColumn([
                'trading_name',
                'vat_registration_number',
                'date_business_established',
                'nature_of_business',
                'business_website',
                'address_line_1',
                'address_line_2',
                'city',
                'postcode',
                'country',
                'primary_contact_name',
                'primary_contact_position',
                'primary_contact_email',
                'primary_contact_phone',
                'preferred_contact_method',
                'owner_full_name',
                'owner_position',
                'owner_nationality',
                'owner_dob',
                'owner_residential_address',
                'certificate_of_incorporation',
                'proof_of_business_address',
                'vat_registration_certificate',
                'business_bank_statement',
                'government_id',
                'proof_of_residential_address',
                'partnership_agreement',
                'sole_trader_evidence',
                'other_documents',
                'primary_products_of_interest',
                'expected_order_frequency',
                'purpose_of_purchase',
            ]);
        });
    }
};
