<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $customers = Customer::where('user_id', $user->id)->get()->keyBy('name');

        $quotesData = [
            [
                'quote_number' => '0018',
                'client_name' => 'Nexus Design Co.',
                'project_id' => 'PROJ-044',
                'po_number' => 'PO-3401',
                'issued' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(28)->format('Y-m-d'),
                'amount' => 9400.00,
                'status' => 'sent',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Comprehensive Design System & UI Kit', 'reference' => 'DS-01', 'quantity' => 1, 'unit_price' => 6000.00],
                    ['description' => 'Component Documentation & Tokens', 'reference' => 'DS-02', 'quantity' => 1, 'unit_price' => 3400.00],
                ],
            ],
            [
                'quote_number' => '0017',
                'client_name' => 'Horizon Labs',
                'project_id' => 'PROJ-043',
                'po_number' => 'PO-3390',
                'issued' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(26)->format('Y-m-d'),
                'amount' => 12500.00,
                'status' => 'accepted',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Cloud Infrastructure Migration Strategy', 'reference' => 'CLD-01', 'quantity' => 1, 'unit_price' => 8500.00],
                    ['description' => 'Disaster Recovery Setup & Configuration', 'reference' => 'CLD-02', 'quantity' => 1, 'unit_price' => 4000.00],
                ],
            ],
            [
                'quote_number' => '0016',
                'client_name' => 'Bloom & Co.',
                'project_id' => 'PROJ-041',
                'po_number' => 'PO-3375',
                'issued' => Carbon::now()->subDays(6)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(24)->format('Y-m-d'),
                'amount' => 6200.00,
                'status' => 'sent',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'E-Commerce Storefront Redesign', 'reference' => 'ECOMM-01', 'quantity' => 1, 'unit_price' => 4200.00],
                    ['description' => 'Payment Gateway Integration & QA', 'reference' => 'ECOMM-02', 'quantity' => 1, 'unit_price' => 2000.00],
                ],
            ],
            [
                'quote_number' => '0015',
                'client_name' => 'Stellar Media',
                'project_id' => 'PROJ-039',
                'po_number' => 'PO-3350',
                'issued' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'amount' => 18400.00,
                'status' => 'accepted',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Video Streaming Backend Architecture', 'reference' => 'MED-01', 'quantity' => 1, 'unit_price' => 12000.00],
                    ['description' => 'CDN Optimization & Live Transcoding', 'reference' => 'MED-02', 'quantity' => 1, 'unit_price' => 6400.00],
                ],
            ],
            [
                'quote_number' => '0014',
                'client_name' => 'Priya Sharma',
                'project_id' => 'PROJ-037',
                'po_number' => 'PO-3320',
                'issued' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'amount' => 3800.00,
                'status' => 'draft',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Portfolio Site Design & Custom Interactions', 'reference' => 'WEB-01', 'quantity' => 1, 'unit_price' => 2800.00],
                    ['description' => 'CMS Setup & Hosting Deployment', 'reference' => 'WEB-02', 'quantity' => 1, 'unit_price' => 1000.00],
                ],
            ],
            [
                'quote_number' => '0013',
                'client_name' => 'GreenTech Pvt.',
                'project_id' => 'PROJ-035',
                'po_number' => 'PO-3305',
                'issued' => Carbon::now()->subDays(22)->format('Y-m-d'),
                'expiry' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'amount' => 7900.00,
                'status' => 'sent',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'IoT Sensor Dashboard Frontend', 'reference' => 'IOT-01', 'quantity' => 1, 'unit_price' => 5500.00],
                    ['description' => 'Real-time Telemetry WebSockets Hookup', 'reference' => 'IOT-02', 'quantity' => 1, 'unit_price' => 2400.00],
                ],
            ],
            [
                'quote_number' => '0012',
                'client_name' => 'Arjun Mehta',
                'project_id' => 'PROJ-032',
                'po_number' => 'PO-3280',
                'issued' => Carbon::now()->subDays(35)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'amount' => 4500.00,
                'status' => 'expired',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Mobile App Prototyping & Flow Wireframes', 'reference' => 'MOB-01', 'quantity' => 1, 'unit_price' => 3000.00],
                    ['description' => 'Interactive Figma Click-through Model', 'reference' => 'MOB-02', 'quantity' => 1, 'unit_price' => 1500.00],
                ],
            ],
            [
                'quote_number' => '0011',
                'client_name' => 'Rohan Pillai',
                'project_id' => 'PROJ-030',
                'po_number' => 'PO-3260',
                'issued' => Carbon::now()->subDays(40)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'amount' => 5200.00,
                'status' => 'rejected',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Brand Strategy & Market Positioning', 'reference' => 'STG-01', 'quantity' => 1, 'unit_price' => 5200.00],
                ],
            ],
            [
                'quote_number' => '0010',
                'client_name' => 'Acme Corp',
                'project_id' => 'PROJ-028',
                'po_number' => 'PO-3240',
                'issued' => Carbon::now()->subDays(45)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'amount' => 15800.00,
                'status' => 'accepted',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Enterprise ERP Integration Service', 'reference' => 'ERP-01', 'quantity' => 1, 'unit_price' => 11000.00],
                    ['description' => 'Custom API Connectors & Sync Engine', 'reference' => 'ERP-02', 'quantity' => 1, 'unit_price' => 4800.00],
                ],
            ],
            [
                'quote_number' => '0009',
                'client_name' => 'Bright Ideas Ltd',
                'project_id' => 'PROJ-026',
                'po_number' => 'PO-3220',
                'issued' => Carbon::now()->subDays(50)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'amount' => 8900.00,
                'status' => 'accepted',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Digital Marketing Funnel & Landing Pages', 'reference' => 'MKT-01', 'quantity' => 1, 'unit_price' => 6000.00],
                    ['description' => 'A/B Testing Framework & Tracking Setup', 'reference' => 'MKT-02', 'quantity' => 1, 'unit_price' => 2900.00],
                ],
            ],
            [
                'quote_number' => '0008',
                'client_name' => 'Nova Systems',
                'project_id' => 'PROJ-024',
                'po_number' => 'PO-3200',
                'issued' => Carbon::now()->subDays(60)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'amount' => 11200.00,
                'status' => 'expired',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Microservices Containerization & K8s', 'reference' => 'DEV-01', 'quantity' => 1, 'unit_price' => 8000.00],
                    ['description' => 'CI/CD Pipeline Automation', 'reference' => 'DEV-02', 'quantity' => 1, 'unit_price' => 3200.00],
                ],
            ],
            [
                'quote_number' => '0007',
                'client_name' => 'Horizon Media',
                'project_id' => 'PROJ-022',
                'po_number' => 'PO-3180',
                'issued' => Carbon::now()->subDays(70)->format('Y-m-d'),
                'expiry' => Carbon::now()->subDays(40)->format('Y-m-d'),
                'amount' => 4900.00,
                'status' => 'draft',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Interactive Web Animation & 3D Assets', 'reference' => '3D-01', 'quantity' => 1, 'unit_price' => 4900.00],
                ],
            ],
        ];

        foreach ($quotesData as $qData) {
            $customer = $customers->get($qData['client_name']);
            
            $subtotal = 0;
            foreach ($qData['items'] as $it) {
                $subtotal += ($it['quantity'] * $it['unit_price']);
            }

            $quote = Quote::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quote_number' => $qData['quote_number'],
                ],
                [
                    'customer_id' => $customer?->id,
                    'client_name' => $qData['client_name'],
                    'client_email' => $customer?->email ?? strtolower(str_replace(' ', '', $qData['client_name'])) . '@example.com',
                    'contact_name' => $customer?->contact_name ?? $qData['client_name'],
                    'billing_address' => $customer?->billing_address ?? '123 Business Way, Suite 100',
                    'prefix' => 'QUO-',
                    'issue_date' => $qData['issued'],
                    'expiry_date' => $qData['expiry'],
                    'status' => $qData['status'],
                    'currency' => $qData['currency'] ?? 'USD',
                    'po_number' => $qData['po_number'] ?? null,
                    'project_id' => $qData['project_id'] ?? null,
                    'notes' => 'Thank you for considering our proposal. This quote is valid for 30 days.',
                    'terms' => '50% upfront payment upon acceptance. Final delivery within estimated timeline.',
                    'subtotal' => $subtotal,
                    'tax_rate' => 0,
                    'tax_amount' => 0,
                    'discount_rate' => 0,
                    'discount_amount' => 0,
                    'shipping_amount' => 0,
                    'handling_amount' => 0,
                    'total_amount' => $subtotal,
                ]
            );

            // Clean line items and recreate
            $quote->items()->delete();
            foreach ($qData['items'] as $idx => $it) {
                QuoteItem::create([
                    'quote_id' => $quote->id,
                    'description' => $it['description'],
                    'reference' => $it['reference'] ?? '',
                    'quantity' => $it['quantity'],
                    'unit_price' => $it['unit_price'],
                    'amount' => $it['quantity'] * $it['unit_price'],
                    'order' => $idx,
                ]);
            }
        }
    }
}
