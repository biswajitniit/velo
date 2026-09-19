<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if (Bank::where('user_id', $user->id)->count() === 0) {
                Bank::create([
                    'user_id' => $user->id,
                    'bank_name' => 'JPMorgan Chase',
                    'account_name' => $user->name . ' Business LLC',
                    'account_number' => '482910394857',
                    'routing_number' => '021000021',
                    'swift_code' => 'CHASUS33',
                    'branch_name' => 'Manhattan Corporate Center',
                    'account_type' => 'checking',
                    'currency' => 'USD',
                    'is_primary' => true,
                    'status' => true,
                    'notes' => 'Primary settlement account for client invoice wire transfers.',
                ]);

                Bank::create([
                    'user_id' => $user->id,
                    'bank_name' => 'Silicon Valley Bank',
                    'account_name' => $user->name . ' Treasury',
                    'account_number' => '991204857213',
                    'routing_number' => '121140399',
                    'swift_code' => 'SVBKUS6S',
                    'branch_name' => 'Santa Clara HQ',
                    'account_type' => 'savings',
                    'currency' => 'USD',
                    'is_primary' => false,
                    'status' => true,
                    'notes' => 'Reserve treasury and operating account.',
                ]);
            }
        }
    }
}
