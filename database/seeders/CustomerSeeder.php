<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
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

        $customers = [
            [
                'client_id' => 'CLT-001',
                'name' => 'Nexus Design Co.',
                'email' => 'billing@nexusdesign.com',
                'contact_name' => 'Alex Morgan',
                'billing_address' => '742 Evergreen Terrace, Suite 100, Springfield, OR 97477',
                'initials' => 'ND',
                'color' => 'linear-gradient(135deg,#00b899,#009e82)',
                'tags' => ['Retainer', 'Agency'],
            ],
            [
                'client_id' => 'CLT-002',
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'contact_name' => 'Priya Sharma',
                'billing_address' => '45 Marine Drive, Mumbai, MH 400020',
                'initials' => 'PS',
                'color' => 'linear-gradient(135deg,#3b82f6,#2563eb)',
                'tags' => ['Freelance'],
            ],
            [
                'client_id' => 'CLT-003',
                'name' => 'Horizon Labs',
                'email' => 'accounts@horizonlabs.io',
                'contact_name' => 'David Vance',
                'billing_address' => '100 Innovation Way, Austin, TX 78701',
                'initials' => 'HL',
                'color' => 'linear-gradient(135deg,#f5a623,#e8991a)',
                'tags' => ['Enterprise', 'SaaS'],
            ],
            [
                'client_id' => 'CLT-004',
                'name' => 'Bloom & Co.',
                'email' => 'finance@bloomco.com',
                'contact_name' => 'Emma Watson',
                'billing_address' => '22 Flower Street, Seattle, WA 98101',
                'initials' => 'BC',
                'color' => 'linear-gradient(135deg,#8b5cf6,#7c3aed)',
                'tags' => ['Recurring'],
            ],
            [
                'client_id' => 'CLT-005',
                'name' => 'Arjun Mehta',
                'email' => 'arjun@mehta.in',
                'contact_name' => 'Arjun Mehta',
                'billing_address' => '18 Richmond Road, Bangalore, KA 560025',
                'initials' => 'AM',
                'color' => 'linear-gradient(135deg,#f05454,#dc2626)',
                'tags' => ['One-time'],
            ],
            [
                'client_id' => 'CLT-006',
                'name' => 'Stellar Media',
                'email' => 'pay@stellarmedia.com',
                'contact_name' => 'Jessica Alba',
                'billing_address' => '500 Madison Ave, 12th Floor, New York, NY 10022',
                'initials' => 'SM',
                'color' => 'linear-gradient(135deg,#ec4899,#db2777)',
                'tags' => ['Agency', 'Retainer'],
            ],
            [
                'client_id' => 'CLT-007',
                'name' => 'GreenTech Pvt.',
                'email' => 'billing@greentech.in',
                'contact_name' => 'Vikram Seth',
                'billing_address' => '88 Tech Park, Cyber City, Gurgaon, HR 122002',
                'initials' => 'GT',
                'color' => 'linear-gradient(135deg,#14b8a6,#0d9488)',
                'tags' => ['Enterprise'],
            ],
            [
                'client_id' => 'CLT-008',
                'name' => 'Rohan Pillai',
                'email' => 'rohan@pillai.me',
                'contact_name' => 'Rohan Pillai',
                'billing_address' => '12 Palm Grove, Kochi, KL 682001',
                'initials' => 'RP',
                'color' => 'linear-gradient(135deg,#f97316,#ea580c)',
                'tags' => ['Freelance'],
            ],
            [
                'client_id' => 'C-001',
                'name' => 'Acme Corp',
                'email' => 'billing@acme.com',
                'contact_name' => 'John Doe',
                'billing_address' => '123 Acme Blvd, Denver, CO 80202',
                'initials' => 'AC',
                'color' => 'linear-gradient(135deg,#00b899,#009e82)',
                'tags' => ['Corporate'],
            ],
            [
                'client_id' => 'C-002',
                'name' => 'Bright Ideas Ltd',
                'email' => 'finance@brightideas.co',
                'contact_name' => 'Sara Connor',
                'billing_address' => '456 Innovation Park, London, UK EC1A 1BB',
                'initials' => 'BI',
                'color' => 'linear-gradient(135deg,#f5a623,#e8991a)',
                'tags' => ['Consulting'],
            ],
            [
                'client_id' => 'C-003',
                'name' => 'Nova Systems',
                'email' => 'accounts@novasys.io',
                'contact_name' => 'Michael Chang',
                'billing_address' => '789 Silicon Ave, San Jose, CA 95113',
                'initials' => 'NS',
                'color' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
                'tags' => ['Tech'],
            ],
            [
                'client_id' => 'C-004',
                'name' => 'Horizon Media',
                'email' => 'pay@horizonmedia.com',
                'contact_name' => 'Chloe Bennett',
                'billing_address' => '321 Sunset Blvd, Los Angeles, CA 90028',
                'initials' => 'HM',
                'color' => 'linear-gradient(135deg,#f05454,#dc2626)',
                'tags' => ['Media'],
            ],
        ];

        foreach ($customers as $data) {
            Customer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $data['name'],
                ],
                array_merge($data, ['user_id' => $user->id])
            );
        }
    }
}
