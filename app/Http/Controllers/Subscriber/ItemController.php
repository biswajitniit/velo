<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private function getUser()
    {
        return Auth::user() ?? User::first();
    }

    public function index(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $items = Item::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $kpiTotal = $items->count();
        $kpiProducts = $items->where('type', 'product')->count();
        $kpiServices = $items->where('type', 'service')->count();
        $kpiActive = $items->where('active', true)->count();

        $jsItems = $items->map(function ($it) {
            return [
                'id' => $it->id,
                'num' => $it->num,
                'shortDesc' => $it->short_desc,
                'fullDesc' => $it->full_desc ?: '',
                'uom' => $it->uom ?: 'Each',
                'type' => $it->type ?: 'product',
                'price' => (float) $it->price,
                'currency' => $it->currency ?: 'USD',
                'active' => (bool) $it->active,
                'taxFlag' => $it->tax_flag ?: 'taxable',
                'taxSource' => $it->tax_source ?: '',
                'taxRate' => (float) $it->tax_rate,
                'taxName' => $it->tax_name ?: '',
                'taxCode' => $it->tax_code ?: '',
                'ptc' => $it->ptc ?: '',
                'taxCategory' => $it->tax_category ?: '',
                'stripeTaxCode' => $it->stripe_tax_code ?: '',
                'taxBehavior' => $it->tax_behavior ?: 'exclusive',
                'extTaxCode' => $it->ext_tax_code ?: '',
                'statusEffectiveDate' => $it->status_effective_date ? $it->status_effective_date->format('Y-m-d') : '',
                'lastUpdatedDate' => $it->last_updated_date ? $it->last_updated_date->format('Y-m-d') : ($it->updated_at ? $it->updated_at->format('Y-m-d') : ''),
                'lastUpdatedBy' => $it->last_updated_by ?: ($user->name ?? 'Admin'),
            ];
        })->values()->all();

        $lastItem = Item::where('user_id', $userId)->orderBy('id', 'desc')->first();
        $nextId = $lastItem ? ($lastItem->id + 1) : 1;
        $nextItemNum = 'ITEM-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('subscriber.items', [
            'items' => $items,
            'jsItems' => $jsItems,
            'kpiTotal' => $kpiTotal,
            'kpiProducts' => $kpiProducts,
            'kpiServices' => $kpiServices,
            'kpiActive' => $kpiActive,
            'nextItemNum' => $nextItemNum,
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $validated = $request->validate([
            'num' => 'required|string|max:50',
            'shortDesc' => 'nullable|string|max:255',
            'short_desc' => 'nullable|string|max:255',
            'fullDesc' => 'nullable|string',
            'full_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'uom' => 'nullable|string|max:50',
            'type' => 'nullable|string|in:product,service',
            'currency' => 'nullable|string|max:10',
            'active' => 'nullable',
            'taxFlag' => 'nullable|string|in:taxable,exempt',
            'tax_flag' => 'nullable|string|in:taxable,exempt',
            'taxSource' => 'nullable|string|max:50',
            'tax_source' => 'nullable|string|max:50',
            'taxRate' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'taxName' => 'nullable|string|max:100',
            'tax_name' => 'nullable|string|max:100',
            'taxCode' => 'nullable|string|max:100',
            'tax_code' => 'nullable|string|max:100',
            'ptc' => 'nullable|string|max:100',
            'taxCategory' => 'nullable|string|max:100',
            'tax_category' => 'nullable|string|max:100',
            'stripeTaxCode' => 'nullable|string|max:100',
            'stripe_tax_code' => 'nullable|string|max:100',
            'taxBehavior' => 'nullable|string|max:20',
            'tax_behavior' => 'nullable|string|max:20',
            'extTaxCode' => 'nullable|string|max:100',
            'ext_tax_code' => 'nullable|string|max:100',
        ]);

        $shortDesc = $validated['shortDesc'] ?? ($validated['short_desc'] ?? 'Item');
        $fullDesc = $validated['fullDesc'] ?? ($validated['full_desc'] ?? null);
        $taxFlag = $validated['taxFlag'] ?? ($validated['tax_flag'] ?? 'taxable');
        $taxSource = $taxFlag === 'taxable' ? ($validated['taxSource'] ?? ($validated['tax_source'] ?? 'manual')) : '';
        $taxRate = $taxFlag === 'taxable' ? (float) ($validated['taxRate'] ?? ($validated['tax_rate'] ?? 0)) : 0;
        $active = isset($validated['active']) ? filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN) : true;

        $item = Item::create([
            'user_id' => $userId,
            'num' => $validated['num'],
            'short_desc' => $shortDesc,
            'full_desc' => $fullDesc,
            'price' => (float) $validated['price'],
            'uom' => $validated['uom'] ?? 'Each',
            'type' => $validated['type'] ?? 'product',
            'currency' => $validated['currency'] ?? 'USD',
            'active' => $active,
            'tax_flag' => $taxFlag,
            'tax_source' => $taxSource,
            'tax_rate' => $taxRate,
            'tax_name' => $validated['taxName'] ?? ($validated['tax_name'] ?? null),
            'tax_code' => $validated['taxCode'] ?? ($validated['tax_code'] ?? null),
            'ptc' => $validated['ptc'] ?? null,
            'tax_category' => $validated['taxCategory'] ?? ($validated['tax_category'] ?? null),
            'stripe_tax_code' => $validated['stripeTaxCode'] ?? ($validated['stripe_tax_code'] ?? null),
            'tax_behavior' => $validated['taxBehavior'] ?? ($validated['tax_behavior'] ?? 'exclusive'),
            'ext_tax_code' => $validated['extTaxCode'] ?? ($validated['ext_tax_code'] ?? null),
            'status_effective_date' => Carbon::now()->toDateString(),
            'last_updated_date' => Carbon::now()->toDateString(),
            'last_updated_by' => $user->name ?? 'Admin',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Item '{$item->short_desc}' created successfully!",
                'item' => [
                    'id' => $item->id,
                    'num' => $item->num,
                    'shortDesc' => $item->short_desc,
                    'fullDesc' => $item->full_desc ?: '',
                    'uom' => $item->uom,
                    'type' => $item->type,
                    'price' => (float) $item->price,
                    'currency' => $item->currency,
                    'active' => (bool) $item->active,
                    'taxFlag' => $item->tax_flag,
                    'taxSource' => $item->tax_source ?: '',
                    'taxRate' => (float) $item->tax_rate,
                    'taxName' => $item->tax_name ?: '',
                    'taxCode' => $item->tax_code ?: '',
                    'ptc' => $item->ptc ?: '',
                    'taxCategory' => $item->tax_category ?: '',
                    'stripeTaxCode' => $item->stripe_tax_code ?: '',
                    'taxBehavior' => $item->tax_behavior ?: 'exclusive',
                    'extTaxCode' => $item->ext_tax_code ?: '',
                    'statusEffectiveDate' => $item->status_effective_date ? $item->status_effective_date->format('Y-m-d') : '',
                    'lastUpdatedDate' => $item->last_updated_date ? $item->last_updated_date->format('Y-m-d') : '',
                    'lastUpdatedBy' => $item->last_updated_by,
                ],
            ]);
        }

        return redirect()->route('subscriber.items')->with('success', "Item '{$item->short_desc}' created successfully.");
    }

    public function update(Request $request, Item $item)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($item->user_id !== $userId) {
            abort(403);
        }

        $validated = $request->validate([
            'num' => 'required|string|max:50',
            'shortDesc' => 'nullable|string|max:255',
            'short_desc' => 'nullable|string|max:255',
            'fullDesc' => 'nullable|string',
            'full_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'uom' => 'nullable|string|max:50',
            'type' => 'nullable|string|in:product,service',
            'currency' => 'nullable|string|max:10',
            'active' => 'nullable',
            'taxFlag' => 'nullable|string|in:taxable,exempt',
            'tax_flag' => 'nullable|string|in:taxable,exempt',
            'taxSource' => 'nullable|string|max:50',
            'tax_source' => 'nullable|string|max:50',
            'taxRate' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'taxName' => 'nullable|string|max:100',
            'tax_name' => 'nullable|string|max:100',
            'taxCode' => 'nullable|string|max:100',
            'tax_code' => 'nullable|string|max:100',
            'ptc' => 'nullable|string|max:100',
            'taxCategory' => 'nullable|string|max:100',
            'tax_category' => 'nullable|string|max:100',
            'stripeTaxCode' => 'nullable|string|max:100',
            'stripe_tax_code' => 'nullable|string|max:100',
            'taxBehavior' => 'nullable|string|max:20',
            'tax_behavior' => 'nullable|string|max:20',
            'extTaxCode' => 'nullable|string|max:100',
            'ext_tax_code' => 'nullable|string|max:100',
        ]);

        $shortDesc = $validated['shortDesc'] ?? ($validated['short_desc'] ?? $item->short_desc);
        $fullDesc = $validated['fullDesc'] ?? ($validated['full_desc'] ?? $item->full_desc);
        $taxFlag = $validated['taxFlag'] ?? ($validated['tax_flag'] ?? $item->tax_flag);
        $taxSource = $taxFlag === 'taxable' ? ($validated['taxSource'] ?? ($validated['tax_source'] ?? $item->tax_source)) : '';
        $taxRate = $taxFlag === 'taxable' ? (float) ($validated['taxRate'] ?? ($validated['tax_rate'] ?? $item->tax_rate)) : 0;
        $active = isset($validated['active']) ? filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN) : $item->active;

        $statusChanged = ($item->active != $active);

        $item->update([
            'num' => $validated['num'],
            'short_desc' => $shortDesc,
            'full_desc' => $fullDesc,
            'price' => (float) $validated['price'],
            'uom' => $validated['uom'] ?? $item->uom,
            'type' => $validated['type'] ?? $item->type,
            'currency' => $validated['currency'] ?? $item->currency,
            'active' => $active,
            'tax_flag' => $taxFlag,
            'tax_source' => $taxSource,
            'tax_rate' => $taxRate,
            'tax_name' => $validated['taxName'] ?? ($validated['tax_name'] ?? $item->tax_name),
            'tax_code' => $validated['taxCode'] ?? ($validated['tax_code'] ?? $item->tax_code),
            'ptc' => $validated['ptc'] ?? $item->ptc,
            'tax_category' => $validated['taxCategory'] ?? ($validated['tax_category'] ?? $item->tax_category),
            'stripe_tax_code' => $validated['stripeTaxCode'] ?? ($validated['stripe_tax_code'] ?? $item->stripe_tax_code),
            'tax_behavior' => $validated['taxBehavior'] ?? ($validated['tax_behavior'] ?? $item->tax_behavior),
            'ext_tax_code' => $validated['extTaxCode'] ?? ($validated['ext_tax_code'] ?? $item->ext_tax_code),
            'status_effective_date' => $statusChanged ? Carbon::now()->toDateString() : $item->status_effective_date,
            'last_updated_date' => Carbon::now()->toDateString(),
            'last_updated_by' => $user->name ?? 'Admin',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Item '{$item->short_desc}' updated successfully!",
                'item' => [
                    'id' => $item->id,
                    'num' => $item->num,
                    'shortDesc' => $item->short_desc,
                    'fullDesc' => $item->full_desc ?: '',
                    'uom' => $item->uom,
                    'type' => $item->type,
                    'price' => (float) $item->price,
                    'currency' => $item->currency,
                    'active' => (bool) $item->active,
                    'taxFlag' => $item->tax_flag,
                    'taxSource' => $item->tax_source ?: '',
                    'taxRate' => (float) $item->tax_rate,
                    'taxName' => $item->tax_name ?: '',
                    'taxCode' => $item->tax_code ?: '',
                    'ptc' => $item->ptc ?: '',
                    'taxCategory' => $item->tax_category ?: '',
                    'stripeTaxCode' => $item->stripe_tax_code ?: '',
                    'taxBehavior' => $item->tax_behavior ?: 'exclusive',
                    'extTaxCode' => $item->ext_tax_code ?: '',
                    'statusEffectiveDate' => $item->status_effective_date ? $item->status_effective_date->format('Y-m-d') : '',
                    'lastUpdatedDate' => $item->last_updated_date ? $item->last_updated_date->format('Y-m-d') : '',
                    'lastUpdatedBy' => $item->last_updated_by,
                ],
            ]);
        }

        return redirect()->route('subscriber.items')->with('success', "Item '{$item->short_desc}' updated.");
    }

    public function toggleStatus(Request $request, Item $item)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if ($item->user_id !== $userId) {
            abort(403);
        }

        $active = $request->has('active') ? filter_var($request->input('active'), FILTER_VALIDATE_BOOLEAN) : !$item->active;
        $item->update([
            'active' => $active,
            'status_effective_date' => Carbon::now()->toDateString(),
            'last_updated_date' => Carbon::now()->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'active' => $item->active,
            'message' => $item->active ? "Item '{$item->short_desc}' is now Active." : "Item '{$item->short_desc}' is now Inactive.",
        ]);
    }

    public function destroy(Item $item)
    {
        $shortDesc = $item->short_desc;
        $item->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Item '{$shortDesc}' deleted successfully.",
            ]);
        }

        return redirect()->route('subscriber.items')->with('success', "Item '{$shortDesc}' deleted.");
    }

    public function bulkAction(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $action = $request->input('action');
        $itemIds = $request->input('items', []);

        if (empty($itemIds)) {
            return response()->json(['success' => false, 'message' => 'No items selected.'], 422);
        }

        $query = Item::where('user_id', $userId)->whereIn('id', $itemIds);

        if ($action === 'delete') {
            $count = $query->count();
            $query->delete();
            return response()->json([
                'success' => true,
                'message' => "{$count} item(s) deleted successfully.",
            ]);
        }

        if ($action === 'activate') {
            $query->update(['active' => true, 'last_updated_date' => Carbon::now()->toDateString()]);
            return response()->json([
                'success' => true,
                'message' => count($itemIds) . ' item(s) set to Active.',
            ]);
        }

        if ($action === 'deactivate') {
            $query->update(['active' => false, 'last_updated_date' => Carbon::now()->toDateString()]);
            return response()->json([
                'success' => true,
                'message' => count($itemIds) . ' item(s) set to Inactive.',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Action completed.']);
    }
}
