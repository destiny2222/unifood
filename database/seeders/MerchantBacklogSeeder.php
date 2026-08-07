<?php

namespace Database\Seeders;

use App\Models\Kyc;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchantBacklogSeeder extends Seeder
{
    public function run()
    {
        $companies = [
            [
                'name' => 'John Okoro',
                'email' => 'john.okoro@africangrocers.co.uk',
                'company' => 'African Grocers Ltd',
                'reg_no' => 'UK-REG-849201',
                'business_type' => 'retailer',
                'trade_address' => '142 High Street, London, UK',
                'volume' => '£10,000 - £25,000',
                'status' => 'approved',
                'tier' => 'Gold',
                'notes' => 'Verified VAT and trade registry. Excellent ordering history.',
            ],
            [
                'name' => 'Fatima Bello',
                'email' => 'fatima@savannahspices.com',
                'company' => 'Savannah Spices & Foods',
                'reg_no' => 'UK-REG-194028',
                'business_type' => 'caterer',
                'trade_address' => '88 Commercial Road, Birmingham, UK',
                'volume' => '£5,000 - £10,000',
                'status' => 'approved',
                'tier' => 'Silver',
                'notes' => 'Approved for wholesale tier 2 discounts.',
            ],
            [
                'name' => 'David Kwesi',
                'email' => 'david@accrakitchen.co.uk',
                'company' => 'Accra Kitchen Restaurant',
                'reg_no' => 'UK-REG-903182',
                'business_type' => 'restaurant',
                'trade_address' => '23 Station Parade, Manchester, UK',
                'volume' => '£2,500 - £5,000',
                'status' => 'pending',
                'tier' => 'Bronze',
                'notes' => 'KYC submitted. Pending proof of business address verification.',
            ],
            [
                'name' => 'Grace Mensah',
                'email' => 'grace@goldcoastcatering.com',
                'company' => 'Gold Coast Event Catering',
                'reg_no' => 'UK-REG-472019',
                'business_type' => 'caterer',
                'trade_address' => '54 Victoria Street, Leeds, UK',
                'volume' => '£10,000+',
                'status' => 'pending',
                'tier' => 'Gold',
                'notes' => 'Awaiting tax identification certificate upload.',
            ],
            [
                'name' => 'Emmanuel Nwachukwu',
                'email' => 'emmanuel@nwachukwumart.com',
                'company' => 'Nwachukwu Tropical Mart',
                'reg_no' => 'UK-REG-630281',
                'business_type' => 'reseller',
                'trade_address' => '71 Market Place, Glasgow, UK',
                'volume' => '£1,000 - £2,500',
                'status' => 'info_requested',
                'tier' => null,
                'notes' => 'Requested updated utility bill for trade address.',
            ],
            [
                'name' => 'Amina Hassan',
                'email' => 'hassan@saharafresh.com',
                'company' => 'Sahara Fresh Express',
                'reg_no' => 'UK-REG-382910',
                'business_type' => 'retailer',
                'trade_address' => '12 Broad Street, Liverpool, UK',
                'volume' => '£5,000 - £10,000',
                'status' => 'approved',
                'tier' => 'Silver',
                'notes' => 'Approved trade account.',
            ],
        ];

        foreach ($companies as $index => $data) {
            $createdAt = \Carbon\Carbon::create(2026, 7, rand(1, 28), rand(8, 17), rand(0, 59));
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'is_business_owner' => 1,
                    'current_view' => 'business',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );

            Kyc::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['company'],
                    'company_registration_number' => $data['reg_no'],
                    'business_type' => $data['business_type'],
                    'trade_address' => $data['trade_address'],
                    'billing_contact' => $data['email'],
                    'estimated_monthly_order_volume' => $data['volume'],
                    'status' => $data['status'],
                    'pricing_tier' => $data['tier'] ?? 'Standard',
                    'status_notes' => $data['notes'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );
        }
    }
}
