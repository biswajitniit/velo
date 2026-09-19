<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'subscriber@velo.test',
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);

        $items = [
            [
                'num' => 'SVC-001',
                'short_desc' => 'Web Design & Development',
                'full_desc' => 'Custom responsive web design, front-end and back-end development with CMS integration.',
                'uom' => 'Project',
                'type' => 'service',
                'price' => 3500.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 8.25,
                'tax_name' => 'State Sales Tax',
                'tax_code' => 'SVC-WEB-01',
                'ptc' => 'SC0101',
                'tax_category' => 'services',
                'stripe_tax_code' => 'txcd_10000000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-01-15',
                'last_updated_date' => '2025-01-10',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'SVC-002',
                'short_desc' => 'SEO Optimization Package',
                'full_desc' => 'Full technical audit, keyword strategy, on-page optimization, and monthly ranking reports.',
                'uom' => 'Month',
                'type' => 'service',
                'price' => 850.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 8.25,
                'tax_name' => 'State Sales Tax',
                'tax_code' => 'SVC-SEO-02',
                'ptc' => 'SC0200',
                'tax_category' => 'marketing',
                'stripe_tax_code' => 'txcd_10000000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-02-01',
                'last_updated_date' => '2025-02-01',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'PROD-001',
                'short_desc' => 'Pro Subscription License',
                'full_desc' => 'Annual SaaS platform access for up to 10 team seats with advanced reporting and API access.',
                'uom' => 'License',
                'type' => 'product',
                'price' => 1200.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 6.50,
                'tax_name' => 'Digital Goods Tax',
                'tax_code' => 'PRD-LIC-01',
                'ptc' => 'SW0100',
                'tax_category' => 'software',
                'stripe_tax_code' => 'txcd_10202000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-01-01',
                'last_updated_date' => '2025-01-01',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'SVC-003',
                'short_desc' => 'Brand Identity & Guidelines',
                'full_desc' => 'Logo system, typography hierarchy, color palette, and comprehensive 40-page brand guide.',
                'uom' => 'Project',
                'type' => 'service',
                'price' => 2200.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'exempt',
                'tax_source' => '',
                'tax_rate' => 0.00,
                'tax_name' => '',
                'tax_code' => '',
                'ptc' => '',
                'tax_category' => '',
                'stripe_tax_code' => '',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-03-10',
                'last_updated_date' => '2024-11-20',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'SVC-004',
                'short_desc' => 'Technical Consulting & Support',
                'full_desc' => 'Senior architect consulting, code reviews, and DevOps guidance billed per hour.',
                'uom' => 'Hour',
                'type' => 'service',
                'price' => 175.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 8.25,
                'tax_name' => 'Service Tax',
                'tax_code' => 'SVC-CNS-04',
                'ptc' => 'SC0101',
                'tax_category' => 'consulting',
                'stripe_tax_code' => 'txcd_10000000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-01-15',
                'last_updated_date' => '2025-01-15',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'PROD-002',
                'short_desc' => 'Enterprise Hardware Hub',
                'full_desc' => 'Edge IoT connectivity hub device with power over Ethernet and redundant 5G failover.',
                'uom' => 'Unit',
                'type' => 'product',
                'price' => 549.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 8.875,
                'tax_name' => 'Standard Sales Tax',
                'tax_code' => 'PRD-HDW-02',
                'ptc' => 'HW0100',
                'tax_category' => 'hardware',
                'stripe_tax_code' => 'txcd_30010002',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-06-01',
                'last_updated_date' => '2025-02-14',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'SVC-005',
                'short_desc' => 'Cloud Migration Sprint',
                'full_desc' => 'Lift-and-shift architecture migration to AWS/GCP with zero-downtime cutover.',
                'uom' => 'Project',
                'type' => 'service',
                'price' => 6200.00,
                'currency' => 'USD',
                'active' => false,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 8.25,
                'tax_name' => 'Service Tax',
                'tax_code' => 'SVC-CLD-05',
                'ptc' => 'SC0101',
                'tax_category' => 'consulting',
                'stripe_tax_code' => 'txcd_10000000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-04-01',
                'last_updated_date' => '2024-12-01',
                'last_updated_by' => 'Sarah Johnson'
            ],
            [
                'num' => 'PROD-003',
                'short_desc' => 'UI Kit & Icon Bundle',
                'full_desc' => 'Complete Figma vector design system including 1,200+ customizable icons and 80+ web components.',
                'uom' => 'License',
                'type' => 'product',
                'price' => 99.00,
                'currency' => 'USD',
                'active' => true,
                'tax_flag' => 'taxable',
                'tax_source' => 'manual',
                'tax_rate' => 6.50,
                'tax_name' => 'Digital Goods Tax',
                'tax_code' => 'PRD-DIG-03',
                'ptc' => 'SW0100',
                'tax_category' => 'digital_goods',
                'stripe_tax_code' => 'txcd_10202000',
                'tax_behavior' => 'exclusive',
                'ext_tax_code' => '',
                'status_effective_date' => '2024-05-15',
                'last_updated_date' => '2025-01-20',
                'last_updated_by' => 'Sarah Johnson'
            ],
        ];

        foreach ($items as $itData) {
            Item::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'num' => $itData['num'],
                ],
                array_merge($itData, ['user_id' => $user->id])
            );
        }
    }
}
