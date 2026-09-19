<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
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

        $invoicesData = [
            [
                'inv' => '0024',
                'client_name' => 'Nexus Design Co.',
                'project' => 'Brand Identity Refresh',
                'po' => 'PO-3310',
                'quote' => 'QT-0024',
                'issued' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'amount' => 8500.00,
                'status' => 'sent',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Brand Strategy & Identity Guidelines', 'reference' => 'SRV-01', 'quantity' => 1, 'unit_price' => 5000.00],
                    ['description' => 'Collateral Design & Typography System', 'reference' => 'SRV-02', 'quantity' => 1, 'unit_price' => 3500.00],
                ],
            ],
            [
                'inv' => '0023',
                'client_name' => 'Horizon Labs',
                'project' => 'SaaS Platform Audit',
                'po' => 'PO-2891',
                'quote' => 'QT-0023',
                'issued' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'amount' => 14200.00,
                'status' => 'overdue',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Complete Architecture & Security Review', 'reference' => 'AUD-01', 'quantity' => 1, 'unit_price' => 9200.00],
                    ['description' => 'Performance Optimization Recommendations', 'reference' => 'AUD-02', 'quantity' => 1, 'unit_price' => 5000.00],
                ],
            ],
            [
                'inv' => '0022',
                'client_name' => 'Bloom & Co.',
                'project' => 'April Retainer',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'amount' => 3200.00,
                'status' => 'paid',
                'type' => 'REC',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Monthly Design & Maintenance Retainer', 'reference' => 'RET-APR', 'quantity' => 1, 'unit_price' => 3200.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-90214', 'source' => 'Stripe / Credit Card', 'amount' => 3200.00],
                ],
            ],
            [
                'inv' => '0021',
                'client_name' => 'Priya Sharma',
                'project' => 'UX Research Sprint',
                'po' => 'PO-4012',
                'quote' => 'QT-0021',
                'issued' => Carbon::now()->subDays(8)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(22)->format('Y-m-d'),
                'amount' => 2100.00,
                'status' => 'sent',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'User Interviews & Persona Analysis', 'reference' => 'UX-01', 'quantity' => 14, 'unit_price' => 150.00],
                ],
            ],
            [
                'inv' => '0020',
                'client_name' => 'Stellar Media',
                'project' => 'Social Campaign Q2',
                'po' => 'PO-3890',
                'quote' => 'QT-0020',
                'issued' => Carbon::now()->subDays(35)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'amount' => 5400.00,
                'status' => 'overdue',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Campaign Concept & Storyboard Production', 'reference' => 'MED-01', 'quantity' => 1, 'unit_price' => 3000.00],
                    ['description' => 'Social Ad Asset Variations (6 Sets)', 'reference' => 'MED-02', 'quantity' => 6, 'unit_price' => 400.00],
                ],
            ],
            [
                'inv' => '0019',
                'client_name' => 'GreenTech Pvt.',
                'project' => 'Green Dashboard MVP',
                'po' => 'PO-2770',
                'quote' => 'QT-0019',
                'issued' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'amount' => 11800.00,
                'status' => 'sent',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Frontend UI Architecture & Chart Components', 'reference' => 'DEV-01', 'quantity' => 1, 'unit_price' => 7800.00],
                    ['description' => 'Real-time Telemetry API Integration', 'reference' => 'DEV-02', 'quantity' => 1, 'unit_price' => 4000.00],
                ],
            ],
            [
                'inv' => '0018',
                'client_name' => 'Nexus Design Co.',
                'project' => 'Motion Design Kit',
                'po' => 'PO-3308',
                'quote' => 'QT-0018',
                'issued' => Carbon::now()->subDays(40)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'amount' => 4300.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Lottie Animations for Web & Mobile', 'reference' => 'MOT-01', 'quantity' => 1, 'unit_price' => 4300.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-88201', 'source' => 'Bank Transfer', 'amount' => 4300.00],
                ],
            ],
            [
                'inv' => '0017',
                'client_name' => 'Arjun Mehta',
                'project' => 'Logo Consultation',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(45)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'amount' => 900.00,
                'status' => 'overdue',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => '1-on-1 Brand Concept Advisory', 'reference' => 'CON-01', 'quantity' => 3, 'unit_price' => 300.00],
                ],
            ],
            [
                'inv' => '0016',
                'client_name' => 'Rohan Pillai',
                'project' => 'Website Redesign',
                'po' => 'PO-3110',
                'quote' => 'QT-0016',
                'issued' => Carbon::now()->subDays(50)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'amount' => 7600.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Complete E-Commerce Web Design & Implementation', 'reference' => 'WEB-01', 'quantity' => 1, 'unit_price' => 7600.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-77309', 'source' => 'Wire Transfer', 'amount' => 7600.00],
                ],
            ],
            [
                'inv' => '0015',
                'client_name' => 'Horizon Labs',
                'project' => 'Quarterly Review Deck',
                'po' => 'PO-2750',
                'quote' => 'QT-0015',
                'issued' => Carbon::now()->subDays(60)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'amount' => 3900.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Investor Presentation & Keynote Design', 'reference' => 'DCK-01', 'quantity' => 1, 'unit_price' => 3900.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-66412', 'source' => 'ACH Transfer', 'amount' => 3900.00],
                ],
            ],
            [
                'inv' => '0014',
                'client_name' => 'Bloom & Co.',
                'project' => 'March Retainer',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(55)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(40)->format('Y-m-d'),
                'amount' => 3200.00,
                'status' => 'paid',
                'type' => 'REC',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Monthly Design & Maintenance Retainer', 'reference' => 'RET-MAR', 'quantity' => 1, 'unit_price' => 3200.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-55120', 'source' => 'Stripe', 'amount' => 3200.00],
                ],
            ],
            [
                'inv' => '0013',
                'client_name' => 'Stellar Media',
                'project' => 'Brand Video Script',
                'po' => 'PO-3800',
                'quote' => 'QT-0013',
                'issued' => Carbon::now()->subDays(65)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(35)->format('Y-m-d'),
                'amount' => 2600.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Scriptwriting & Narrative Direction', 'reference' => 'SCR-01', 'quantity' => 1, 'unit_price' => 2600.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-44981', 'source' => 'Direct Deposit', 'amount' => 2600.00],
                ],
            ],
            [
                'inv' => '0012',
                'client_name' => 'GreenTech Pvt.',
                'project' => 'Energy Audit App',
                'po' => 'PO-2760',
                'quote' => 'QT-0012',
                'issued' => Carbon::now()->subDays(70)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(40)->format('Y-m-d'),
                'amount' => 4700.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Mobile App UI Design & Prototyping', 'reference' => 'MOB-01', 'quantity' => 1, 'unit_price' => 4700.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-33812', 'source' => 'Bank Transfer', 'amount' => 4700.00],
                ],
            ],
            [
                'inv' => '0011',
                'client_name' => 'Priya Sharma',
                'project' => 'Design System Advisory',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(75)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(45)->format('Y-m-d'),
                'amount' => 1500.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Design Token Architecture Review', 'reference' => 'ADV-01', 'quantity' => 10, 'unit_price' => 150.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-22910', 'source' => 'PayPal', 'amount' => 1500.00],
                ],
            ],
            [
                'inv' => '0010',
                'client_name' => 'Nexus Design Co.',
                'project' => 'Annual Brand Assets',
                'po' => 'PO-3300',
                'quote' => 'QT-0010',
                'issued' => Carbon::now()->subDays(80)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(50)->format('Y-m-d'),
                'amount' => 6200.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Full Vector Asset Library & Iconography', 'reference' => 'AST-01', 'quantity' => 1, 'unit_price' => 6200.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-11822', 'source' => 'Wire Transfer', 'amount' => 6200.00],
                ],
            ],
            [
                'inv' => '0009',
                'client_name' => 'Arjun Mehta',
                'project' => 'Landing Page Copy',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(85)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(60)->format('Y-m-d'),
                'amount' => 1200.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'High-Conversion Landing Page Copywriting', 'reference' => 'CPY-01', 'quantity' => 1, 'unit_price' => 1200.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-00918', 'source' => 'Direct Transfer', 'amount' => 1200.00],
                ],
            ],
            [
                'inv' => '0008',
                'client_name' => 'Rohan Pillai',
                'project' => 'E-commerce Theme',
                'po' => 'PO-3100',
                'quote' => 'QT-0008',
                'issued' => Carbon::now()->subDays(90)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(60)->format('Y-m-d'),
                'amount' => 3100.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Custom Shopify Theme Customization', 'reference' => 'SHO-01', 'quantity' => 1, 'unit_price' => 3100.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-99812', 'source' => 'Stripe', 'amount' => 3100.00],
                ],
            ],
            [
                'inv' => '0007',
                'client_name' => 'Horizon Labs',
                'project' => 'Product Discovery',
                'po' => 'PO-2700',
                'quote' => 'QT-0007',
                'issued' => Carbon::now()->subDays(95)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(65)->format('Y-m-d'),
                'amount' => 8000.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Sprint 1 Product Discovery Workshop', 'reference' => 'DSC-01', 'quantity' => 1, 'unit_price' => 8000.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-88711', 'source' => 'ACH Transfer', 'amount' => 8000.00],
                ],
            ],
            [
                'inv' => '0006',
                'client_name' => 'Bloom & Co.',
                'project' => 'February Retainer',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->subDays(100)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(70)->format('Y-m-d'),
                'amount' => 3200.00,
                'status' => 'paid',
                'type' => 'REC',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Monthly Design & Maintenance Retainer', 'reference' => 'RET-FEB', 'quantity' => 1, 'unit_price' => 3200.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-77610', 'source' => 'Stripe', 'amount' => 3200.00],
                ],
            ],
            [
                'inv' => '0005',
                'client_name' => 'Stellar Media',
                'project' => 'Influencer Campaign Deck',
                'po' => 'PO-3750',
                'quote' => 'QT-0005',
                'issued' => Carbon::now()->subDays(105)->format('Y-m-d'),
                'due' => Carbon::now()->subDays(75)->format('Y-m-d'),
                'amount' => 1900.00,
                'status' => 'paid',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Deck Template & Media Kit Design', 'reference' => 'INF-01', 'quantity' => 1, 'unit_price' => 1900.00],
                ],
                'payments' => [
                    ['status' => 'paid', 'reference' => 'TXN-66509', 'source' => 'Direct Deposit', 'amount' => 1900.00],
                ],
            ],
            [
                'inv' => '0004',
                'client_name' => 'Acme Corp',
                'project' => 'Enterprise System Integration',
                'po' => 'PO-2024-088',
                'quote' => 'QT-0014',
                'issued' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(27)->format('Y-m-d'),
                'amount' => 4850.00,
                'status' => 'sent',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Custom API Gateway Module', 'reference' => 'INT-01', 'quantity' => 1, 'unit_price' => 4850.00],
                ],
            ],
            [
                'inv' => '0003',
                'client_name' => 'Bright Ideas Ltd',
                'project' => 'Brand Strategy Consulting',
                'po' => 'PO-2024-091',
                'quote' => 'QT-0015',
                'issued' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(28)->format('Y-m-d'),
                'amount' => 1200.00,
                'status' => 'draft',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Brand Positioning Analysis', 'reference' => 'STRAT-01', 'quantity' => 1, 'unit_price' => 1200.00],
                ],
            ],
            [
                'inv' => '0002',
                'client_name' => 'Nova Systems',
                'project' => 'Security Audit & Compliance',
                'po' => 'PO-2024-095',
                'quote' => 'QT-0016',
                'issued' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'due' => Carbon::now()->addDays(29)->format('Y-m-d'),
                'amount' => 3720.00,
                'status' => 'sent',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'SOC 2 Pre-Audit Readiness Review', 'reference' => 'SEC-01', 'quantity' => 1, 'unit_price' => 3720.00],
                ],
            ],
            [
                'inv' => '0001',
                'client_name' => 'Horizon Media',
                'project' => 'Quarterly Retainer Q1',
                'po' => '',
                'quote' => '',
                'issued' => Carbon::now()->format('Y-m-d'),
                'due' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'amount' => 620.00,
                'status' => 'draft',
                'type' => 'REG',
                'currency' => 'USD',
                'items' => [
                    ['description' => 'Digital Asset Maintenance', 'reference' => 'MNT-01', 'quantity' => 1, 'unit_price' => 620.00],
                ],
            ],
        ];

        foreach ($invoicesData as $inv) {
            $customer = $customers->get($inv['client_name']);
            $paidAmt = $inv['status'] === 'paid' ? $inv['amount'] : 0.00;

            $invoice = Invoice::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'invoice_number' => $inv['inv'],
                ],
                [
                    'customer_id' => $customer?->id,
                    'client_name' => $inv['client_name'],
                    'client_email' => $customer?->email ?? ($inv['client_name'] . '@example.com'),
                    'contact_name' => $customer?->contact_name,
                    'billing_address' => $customer?->billing_address,
                    'prefix' => 'INV-',
                    'type' => $inv['type'] ?? 'REG',
                    'currency' => $inv['currency'] ?? 'USD',
                    'issue_date' => $inv['issued'],
                    'due_date' => $inv['due'],
                    'status' => $inv['status'],
                    'po_number' => $inv['po'],
                    'project_id' => $inv['project'],
                    'quote_id' => $inv['quote'] ?? null,
                    'notes' => 'Thank you for your business!',
                    'terms' => 'Payment due within 30 days. Late payments subject to 1.5% monthly interest.',
                    'subtotal' => $inv['amount'],
                    'tax_rate' => 0.00,
                    'tax_amount' => 0.00,
                    'shipping_amount' => 0.00,
                    'handling_amount' => 0.00,
                    'discount_rate' => 0.00,
                    'discount_amount' => 0.00,
                    'total_amount' => $inv['amount'],
                    'paid_amount' => $paidAmt,
                ]
            );

            // Create line items
            $invoice->items()->delete();
            if (!empty($inv['items'])) {
                foreach ($inv['items'] as $index => $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => $item['description'],
                        'reference' => $item['reference'] ?? null,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'amount' => $item['quantity'] * $item['unit_price'],
                        'order' => $index,
                    ]);
                }
            }

            // Create payments if paid
            $invoice->payments()->delete();
            if (!empty($inv['payments'])) {
                foreach ($inv['payments'] as $p) {
                    InvoicePayment::create([
                        'invoice_id' => $invoice->id,
                        'status' => $p['status'] ?? 'paid',
                        'reference' => $p['reference'] ?? 'TXN-' . rand(10000, 99999),
                        'payment_date' => $inv['due'],
                        'applied_date' => $inv['due'],
                        'source' => $p['source'] ?? 'Credit Card',
                        'amount' => $p['amount'] ?? $inv['amount'],
                    ]);
                }
            }
        }
    }
}
