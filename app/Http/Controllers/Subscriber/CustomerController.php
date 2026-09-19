<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display User / Customer Management view.
     */
    public function index(Request $request)
    {
        $user = Auth::user() ?? User::first();
        $userId = $user->id ?? 1;

        $planLimits = ['internal' => 5, 'client' => 20];

        // Retrieve existing customer / user records for this subscriber
        $records = Customer::where('user_id', $userId)->orderBy('id', 'asc')->get();

        // Seed demo data matching design if none exist
        if ($records->isEmpty()) {
            $this->seedInitialUsers($userId, $user);
            $records = Customer::where('user_id', $userId)->orderBy('id', 'asc')->get();
        }

        // Map into format expected by the frontend table and scripts
        $jsUsers = $records->map(function ($c) {
            $firstName = $c->first_name ?: (explode(' ', trim($c->name))[0] ?? 'User');
            $lastName = $c->last_name ?: (explode(' ', trim($c->name))[1] ?? '');

            return [
                'id' => $c->id,
                'userId' => $c->user_code ?: str_pad((string) $c->id, 10, '0', STR_PAD_LEFT),
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $c->email ?? '',
                'type' => $c->type ?: 'client',
                'role' => $c->role ?: ($c->type === 'internal' ? 'Staff' : 'Client'),
                'status' => $c->status ?: 'active',
                'isSubscriber' => (bool) $c->is_subscriber,
                'lastActive' => $c->last_active ?: '—',
                'twoFA' => (bool) $c->two_fa,
                'avatar' => $c->initials,
                'avClass' => $c->av_class ?: 'av-teal',
                'clientId' => $c->client_id,
                'clientName' => $c->contact_name ?: $c->name,
            ];
        });

        // Compute Client Registry for lookup dropdown
        $clientRegistry = $records->filter(fn($c) => !empty($c->client_id))->map(function ($c) {
            return [
                'id' => $c->client_id,
                'name' => $c->name,
            ];
        })->unique('id')->values();

        if ($clientRegistry->isEmpty()) {
            $clientRegistry = collect([
                ['id' => 'CLT-0004', 'name' => 'Acme Corp'],
                ['id' => 'CLT-0009', 'name' => 'Wavefront LLC'],
                ['id' => 'CLT-0012', 'name' => 'Nexus Media'],
                ['id' => 'CLT-0027', 'name' => 'Orinoco Labs'],
                ['id' => 'CLT-0031', 'name' => 'Stellar Brands'],
            ]);
        }

        // Compute next auto user ID
        $maxNum = $records->map(function ($c) {
            return (int) preg_replace('/\D/', '', $c->user_code ?? '0');
        })->max();
        $nextNum = max($maxNum ? $maxNum + 1 : 1, $records->count() + 1);
        $nextUserId = str_pad((string) $nextNum, 10, '0', STR_PAD_LEFT);

        return view('subscriber.customers', [
            'user' => $user,
            'planLimits' => $planLimits,
            'jsUsers' => $jsUsers,
            'clientRegistry' => $clientRegistry,
            'nextUserId' => $nextUserId,
        ]);
    }

    /**
     * Store a newly created user/customer.
     */
    public function store(Request $request)
    {
        $user = Auth::user() ?? User::first();
        $userId = $user->id ?? 1;

        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'type' => 'required|string|in:internal,client',
            'role' => 'nullable|string|max:50',
            'userId' => 'nullable|string|max:20',
            'clientId' => 'nullable|string|max:50',
            'clientName' => 'nullable|string|max:150',
            'twoFA' => 'nullable|boolean',
            'sendInvite' => 'nullable|boolean',
        ]);

        $firstName = trim($validated['firstName']);
        $lastName = trim($validated['lastName']);
        $fullName = "{$firstName} {$lastName}";
        $type = $validated['type'];

        // Auto-generate User ID if not provided
        $userCode = $validated['userId'] ?? null;
        if (!$userCode) {
            $count = Customer::where('user_id', $userId)->count() + 1;
            $userCode = str_pad((string) $count, 10, '0', STR_PAD_LEFT);
        }

        // Avatar class color rotation
        $avatarColors = ['av-teal', 'av-amber', 'av-purple', 'av-blue', 'av-rose', 'av-green', 'av-slate'];
        $avClass = $avatarColors[crc32($fullName) % count($avatarColors)];
        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

        $customer = Customer::create([
            'user_id' => $userId,
            'user_code' => $userCode,
            'client_id' => $validated['clientId'] ?? null,
            'name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'contact_name' => $validated['clientName'] ?? $fullName,
            'type' => $type,
            'role' => $validated['role'] ?? ($type === 'internal' ? 'Staff' : 'Client'),
            'status' => !empty($validated['sendInvite']) ? 'pending' : 'new',
            'last_active' => !empty($validated['sendInvite']) ? 'Invite sent just now' : '—',
            'two_fa' => !empty($validated['twoFA']),
            'initials' => $initials,
            'av_class' => $avClass,
        ]);

        $responseData = [
            'id' => $customer->id,
            'userId' => $customer->user_code,
            'firstName' => $customer->first_name,
            'lastName' => $customer->last_name,
            'email' => $customer->email,
            'type' => $customer->type,
            'role' => $customer->role,
            'status' => $customer->status,
            'isSubscriber' => false,
            'lastActive' => $customer->last_active,
            'twoFA' => $customer->two_fa,
            'avatar' => $customer->initials,
            'avClass' => $customer->av_class,
            'clientId' => $customer->client_id,
            'clientName' => $customer->contact_name,
        ];

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $responseData,
        ]);
    }

    /**
     * Update the specified user/customer.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'type' => 'required|string|in:internal,client',
            'role' => 'nullable|string|max:50',
            'clientId' => 'nullable|string|max:50',
            'clientName' => 'nullable|string|max:150',
            'twoFA' => 'nullable|boolean',
        ]);

        $firstName = trim($validated['firstName']);
        $lastName = trim($validated['lastName']);
        $fullName = "{$firstName} {$lastName}";

        $customer->update([
            'name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'type' => $validated['type'],
            'role' => $validated['role'] ?? $customer->role,
            'client_id' => $validated['clientId'] ?? $customer->client_id,
            'contact_name' => $validated['clientName'] ?? $customer->contact_name,
            'two_fa' => !empty($validated['twoFA']),
            'initials' => strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)),
        ]);

        $responseData = [
            'id' => $customer->id,
            'userId' => $customer->user_code ?: str_pad((string) $customer->id, 10, '0', STR_PAD_LEFT),
            'firstName' => $customer->first_name,
            'lastName' => $customer->last_name,
            'email' => $customer->email,
            'type' => $customer->type,
            'role' => $customer->role,
            'status' => $customer->status,
            'isSubscriber' => (bool) $customer->is_subscriber,
            'lastActive' => $customer->last_active ?: '—',
            'twoFA' => (bool) $customer->two_fa,
            'avatar' => $customer->initials,
            'avClass' => $customer->av_class ?: 'av-teal',
            'clientId' => $customer->client_id,
            'clientName' => $customer->contact_name,
        ];

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $responseData,
        ]);
    }

    /**
     * Update user status (activate, suspend, invite).
     */
    public function updateStatus(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'action' => 'required|string|in:activate,suspend,invite,resend_invite,reset_password',
        ]);

        switch ($validated['action']) {
            case 'activate':
                $customer->status = 'active';
                $customer->last_active = 'Just now';
                break;
            case 'suspend':
                $customer->status = 'inactive';
                break;
            case 'invite':
            case 'resend_invite':
                $customer->status = 'pending';
                $customer->last_active = 'Invite sent just now';
                break;
            case 'reset_password':
                // simulated password reset
                break;
        }

        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $customer->status,
            'lastActive' => $customer->last_active,
        ]);
    }

    /**
     * Remove the specified customer/user.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    /**
     * Bulk import users.
     */
    public function import(Request $request)
    {
        $user = Auth::user() ?? User::first();
        $userId = $user->id ?? 1;

        $rows = $request->input('rows', []);
        $imported = [];
        $avatarColors = ['av-teal', 'av-amber', 'av-purple', 'av-blue', 'av-rose', 'av-green', 'av-slate'];

        foreach ($rows as $i => $row) {
            $firstName = trim($row['firstName'] ?? '');
            $lastName = trim($row['lastName'] ?? '');
            $email = trim($row['email'] ?? '');
            if (!$firstName || !$email) continue;

            $fullName = "{$firstName} {$lastName}";
            $type = in_array(strtolower($row['type'] ?? ''), ['internal', 'client']) ? strtolower($row['type']) : 'client';
            $userCode = $row['userId'] ?? str_pad((string) (Customer::where('user_id', $userId)->count() + 1), 10, '0', STR_PAD_LEFT);
            $avClass = $avatarColors[$i % count($avatarColors)];
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName ?: $firstName, 0, 1));

            $c = Customer::create([
                'user_id' => $userId,
                'user_code' => $userCode,
                'client_id' => $row['clientId'] ?? null,
                'name' => $fullName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'contact_name' => $row['clientName'] ?? $fullName,
                'type' => $type,
                'role' => $row['role'] ?? ($type === 'internal' ? 'Staff' : 'Client'),
                'status' => 'new',
                'last_active' => '—',
                'two_fa' => false,
                'initials' => $initials,
                'av_class' => $avClass,
            ]);

            $imported[] = [
                'id' => $c->id,
                'userId' => $c->user_code,
                'firstName' => $c->first_name,
                'lastName' => $c->last_name,
                'email' => $c->email,
                'type' => $c->type,
                'role' => $c->role,
                'status' => $c->status,
                'isSubscriber' => false,
                'lastActive' => $c->last_active,
                'twoFA' => $c->two_fa,
                'avatar' => $c->initials,
                'avClass' => $c->av_class,
                'clientId' => $c->client_id,
                'clientName' => $c->contact_name,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => count($imported) . ' users imported successfully',
            'imported' => $imported,
        ]);
    }

    /**
     * Seed initial users matching the design file.
     */
    protected function seedInitialUsers($userId, $authUser)
    {
        $initials = 'AJ';
        $ownerFirst = 'Adriana';
        $ownerLast = 'Johnson';
        $ownerEmail = 'adriana@acme.co';

        if ($authUser) {
            $parts = explode(' ', trim($authUser->name ?? 'Adriana Johnson'));
            $ownerFirst = $parts[0] ?? 'Adriana';
            $ownerLast = $parts[1] ?? 'Johnson';
            $ownerEmail = $authUser->email ?? 'adriana@acme.co';
            $initials = strtoupper(substr($ownerFirst, 0, 1) . substr($ownerLast, 0, 1));
        }

        $demoUsers = [
            [
                'user_code' => '0000000001',
                'name' => "{$ownerFirst} {$ownerLast}",
                'first_name' => $ownerFirst,
                'last_name' => $ownerLast,
                'email' => $ownerEmail,
                'type' => 'internal',
                'role' => 'Admin',
                'status' => 'subscriber',
                'is_subscriber' => true,
                'last_active' => 'Just now',
                'two_fa' => true,
                'initials' => $initials,
                'av_class' => 'av-teal',
            ],
            [
                'user_code' => '0000000002',
                'name' => 'Marcus Reid',
                'first_name' => 'Marcus',
                'last_name' => 'Reid',
                'email' => 'marcus@acme.co',
                'type' => 'internal',
                'role' => 'Manager',
                'status' => 'active',
                'is_subscriber' => false,
                'last_active' => '2h ago',
                'two_fa' => true,
                'initials' => 'MR',
                'av_class' => 'av-purple',
            ],
            [
                'user_code' => '0000000003',
                'name' => 'Priya Nair',
                'first_name' => 'Priya',
                'last_name' => 'Nair',
                'email' => 'priya@acme.co',
                'type' => 'internal',
                'role' => 'Staff',
                'status' => 'pending',
                'is_subscriber' => false,
                'last_active' => 'Invite sent May 5',
                'two_fa' => false,
                'initials' => 'PN',
                'av_class' => 'av-blue',
            ],
            [
                'user_code' => '0000000004',
                'name' => 'Tom Wallace',
                'first_name' => 'Tom',
                'last_name' => 'Wallace',
                'email' => 'tom@acme.co',
                'type' => 'internal',
                'role' => 'Viewer',
                'status' => 'new',
                'is_subscriber' => false,
                'last_active' => '—',
                'two_fa' => false,
                'initials' => 'TW',
                'av_class' => 'av-slate',
            ],
            [
                'user_code' => '0000000005',
                'name' => 'Nexus Media',
                'first_name' => 'Elena',
                'last_name' => 'Vasquez',
                'email' => 'elena@nexusmedia.com',
                'type' => 'client',
                'role' => 'Client',
                'status' => 'active',
                'is_subscriber' => false,
                'last_active' => '3h ago',
                'two_fa' => false,
                'initials' => 'EV',
                'av_class' => 'av-amber',
                'client_id' => 'CLT-0012',
                'contact_name' => 'Nexus Media',
            ],
            [
                'user_code' => '0000000006',
                'name' => 'Orinoco Labs',
                'first_name' => 'James',
                'last_name' => 'Park',
                'email' => 'jpark@orinoco.io',
                'type' => 'client',
                'role' => 'Client',
                'status' => 'pending',
                'is_subscriber' => false,
                'last_active' => 'Invite sent May 6',
                'two_fa' => false,
                'initials' => 'JP',
                'av_class' => 'av-rose',
                'client_id' => 'CLT-0027',
                'contact_name' => 'Orinoco Labs',
            ],
            [
                'user_code' => '0000000007',
                'name' => 'Stellar Brands',
                'first_name' => 'Fiona',
                'last_name' => 'Mwangi',
                'email' => 'fiona@stellar.co',
                'type' => 'client',
                'role' => 'Client',
                'status' => 'active',
                'is_subscriber' => false,
                'last_active' => '1 day ago',
                'two_fa' => false,
                'initials' => 'FM',
                'av_class' => 'av-green',
                'client_id' => 'CLT-0031',
                'contact_name' => 'Stellar Brands',
            ],
            [
                'user_code' => '0000000008',
                'name' => 'Wavefront LLC',
                'first_name' => 'Raj',
                'last_name' => 'Patel',
                'email' => 'raj@wavefront.io',
                'type' => 'client',
                'role' => 'Client',
                'status' => 'inactive',
                'is_subscriber' => false,
                'last_active' => '—',
                'two_fa' => false,
                'initials' => 'RP',
                'av_class' => 'av-slate',
                'client_id' => 'CLT-0009',
                'contact_name' => 'Wavefront LLC',
            ],
            [
                'user_code' => '0000000009',
                'name' => 'Acme Corp',
                'first_name' => 'Chen',
                'last_name' => 'Li',
                'email' => 'chen@acmecorp.com',
                'type' => 'client',
                'role' => 'Client',
                'status' => 'new',
                'is_subscriber' => false,
                'last_active' => '—',
                'two_fa' => false,
                'initials' => 'CL',
                'av_class' => 'av-purple',
                'client_id' => 'CLT-0004',
                'contact_name' => 'Acme Corp',
            ],
        ];

        foreach ($demoUsers as $d) {
            $d['user_id'] = $userId;
            Customer::create($d);
        }
    }
}
