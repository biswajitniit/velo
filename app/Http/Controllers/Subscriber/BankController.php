<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Get the authenticated user or first user in dev fallback.
     */
    private function getUser()
    {
        return Auth::user() ?? User::first();
    }

    /**
     * Display a listing of bank accounts.
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $banks = Bank::where('user_id', $userId)
            ->orderByDesc('is_primary')
            ->orderByDesc('id')
            ->get();

        // Compute KPIs
        $kpiTotal = $banks->count();
        $kpiActive = $banks->where('status', true)->count();
        $kpiPrimary = $banks->firstWhere('is_primary', true);
        $kpiCurrencies = $banks->pluck('currency')->unique()->count();

        // JavaScript data array for reactive interactions
        $jsBanks = $banks->map(function ($b) {
            return [
                'id' => $b->id,
                'bankName' => $b->bank_name,
                'accountName' => $b->account_name,
                'accountNumber' => $b->account_number,
                'maskedNumber' => $b->masked_account_number,
                'routingNumber' => $b->routing_number ?: '',
                'swiftCode' => $b->swift_code ?: '',
                'iban' => $b->iban ?: '',
                'branchName' => $b->branch_name ?: '',
                'accountType' => $b->account_type ?: 'checking',
                'currency' => $b->currency ?: 'USD',
                'isPrimary' => (bool) $b->is_primary,
                'status' => (bool) $b->status,
                'notes' => $b->notes ?: '',
                'createdAt' => $b->created_at ? $b->created_at->format('M d, Y') : '',
            ];
        })->values()->all();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'banks' => $jsBanks,
                'kpis' => [
                    'total' => $kpiTotal,
                    'active' => $kpiActive,
                    'primary' => $kpiPrimary ? $kpiPrimary->bank_name : 'None',
                    'currencies' => $kpiCurrencies,
                ],
            ]);
        }

        return view('subscriber.banks', compact(
            'banks',
            'jsBanks',
            'kpiTotal',
            'kpiActive',
            'kpiPrimary',
            'kpiCurrencies'
        ));
    }

    /**
     * Store a newly created bank account.
     */
    public function store(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:100',
            'routing_number' => 'nullable|string|max:100',
            'swift_code' => 'nullable|string|max:100',
            'iban' => 'nullable|string|max:100',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'required|in:checking,savings',
            'currency' => 'required|string|max:10',
            'is_primary' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $isPrimary = $request->boolean('is_primary');
        $status = $request->has('status') ? $request->boolean('status') : true;

        // If user has no existing banks, make this the primary
        $existingCount = Bank::where('user_id', $userId)->count();
        if ($existingCount === 0) {
            $isPrimary = true;
        }

        if ($isPrimary) {
            Bank::where('user_id', $userId)->update(['is_primary' => false]);
        }

        $bank = Bank::create([
            'user_id' => $userId,
            'bank_name' => $validated['bank_name'],
            'account_name' => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'routing_number' => $validated['routing_number'] ?? null,
            'swift_code' => $validated['swift_code'] ?? null,
            'iban' => $validated['iban'] ?? null,
            'branch_name' => $validated['branch_name'] ?? null,
            'account_type' => $validated['account_type'],
            'currency' => strtoupper($validated['currency'] ?? 'USD'),
            'is_primary' => $isPrimary,
            'status' => $status,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bank account added successfully.',
                'bank' => $bank,
            ]);
        }

        return redirect()->route('subscriber.banks')->with('success', 'Bank account added successfully.');
    }

    /**
     * Update the specified bank account.
     */
    public function update(Request $request, Bank $bank)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($bank->user_id !== $userId) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }
            abort(403);
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:100',
            'routing_number' => 'nullable|string|max:100',
            'swift_code' => 'nullable|string|max:100',
            'iban' => 'nullable|string|max:100',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'required|in:checking,savings',
            'currency' => 'required|string|max:10',
            'is_primary' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $isPrimary = $request->boolean('is_primary');
        $status = $request->has('status') ? $request->boolean('status') : $bank->status;

        if ($isPrimary) {
            Bank::where('user_id', $userId)->where('id', '!=', $bank->id)->update(['is_primary' => false]);
        }

        $bank->update([
            'bank_name' => $validated['bank_name'],
            'account_name' => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'routing_number' => $validated['routing_number'] ?? null,
            'swift_code' => $validated['swift_code'] ?? null,
            'iban' => $validated['iban'] ?? null,
            'branch_name' => $validated['branch_name'] ?? null,
            'account_type' => $validated['account_type'],
            'currency' => strtoupper($validated['currency'] ?? 'USD'),
            'is_primary' => $isPrimary,
            'status' => $status,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bank account updated successfully.',
                'bank' => $bank,
            ]);
        }

        return redirect()->route('subscriber.banks')->with('success', 'Bank account updated successfully.');
    }

    /**
     * Remove the specified bank account.
     */
    public function destroy(Request $request, Bank $bank)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($bank->user_id !== $userId) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
            }
            abort(403);
        }

        $wasPrimary = $bank->is_primary;
        $bank->delete();

        // If deleted bank was primary, make another active bank primary
        if ($wasPrimary) {
            $nextBank = Bank::where('user_id', $userId)->where('status', true)->first();
            if ($nextBank) {
                $nextBank->update(['is_primary' => true]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bank account deleted successfully.',
            ]);
        }

        return redirect()->route('subscriber.banks')->with('success', 'Bank account deleted successfully.');
    }

    /**
     * Set a bank account as primary.
     */
    public function setPrimary(Request $request, Bank $bank)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($bank->user_id !== $userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        Bank::where('user_id', $userId)->update(['is_primary' => false]);
        $bank->update([
            'is_primary' => true,
            'status' => true, // Primary account should automatically be active
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "'{$bank->bank_name}' set as primary bank account.",
            ]);
        }

        return redirect()->route('subscriber.banks')->with('success', "'{$bank->bank_name}' set as primary bank account.");
    }

    /**
     * Toggle active/inactive status of a bank account.
     */
    public function toggleStatus(Request $request, Bank $bank)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($bank->user_id !== $userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        if ($bank->is_primary && $bank->status) {
            return response()->json([
                'success' => false,
                'message' => 'Primary bank account cannot be deactivated. Please set another primary bank first.',
            ], 422);
        }

        $newStatus = !$bank->status;
        $bank->update(['status' => $newStatus]);

        $statusText = $newStatus ? 'activated' : 'deactivated';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "'{$bank->bank_name}' account {$statusText}.",
                'status' => $newStatus,
            ]);
        }

        return redirect()->route('subscriber.banks')->with('success', "'{$bank->bank_name}' account {$statusText}.");
    }

    /**
     * Bulk action on bank accounts.
     */
    public function bulkAction(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'action' => 'required|in:activate,deactivate,delete',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');

        $query = Bank::where('user_id', $userId)->whereIn('id', $ids);

        if ($action === 'activate') {
            $query->update(['status' => true]);
            $msg = count($ids) . ' bank accounts activated.';
        } elseif ($action === 'deactivate') {
            // Do not deactivate primary bank
            $query->where('is_primary', false)->update(['status' => false]);
            $msg = 'Selected non-primary bank accounts deactivated.';
        } elseif ($action === 'delete') {
            $query->delete();
            $msg = count($ids) . ' bank accounts deleted.';
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
        ]);
    }
}
