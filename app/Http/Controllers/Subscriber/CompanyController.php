<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Show company profile setup form.
     */
    public function create()
    {
        $company = auth()->user()->company;
        return view('subscriber.company.create', compact('company'));
    }

    /**
     * Store / update company profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'display_company_name' => ['nullable', 'boolean'],

            'industry' => ['nullable', 'string', 'max:255'],

            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state_province' => ['nullable', 'string', 'max:255'],
            'zip_postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],

            'country_code' => ['nullable', 'string', 'max:10'],
            'mobile_number' => ['required', 'string', 'max:30'],

            'sms_notifications' => ['nullable', 'boolean'],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:2048',
            ],
        ]);

        $user = auth()->user();

        // Checkbox values
        $validated['display_company_name'] =
            $request->boolean('display_company_name');

        $validated['sms_notifications'] =
            $request->boolean('sms_notifications');

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('logo')) {

            // Delete old logo
            if ($user->company?->logo) {
                Storage::disk('public')->delete($user->company->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('companies/logos', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create / Update Company
        |--------------------------------------------------------------------------
        */
        Company::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            $validated
        );

        return redirect()
            ->route('subscriber.dashboard')
            ->with('success', 'Company profile saved successfully.');
    }
}
