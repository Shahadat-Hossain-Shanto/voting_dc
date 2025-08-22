<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Tax;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function getData()
    {
        $companyId = Auth::user()->company_id;

        if ($companyId == 0) {
            $companies = Company::all();
            $companies = $companies->toArray();
        } else {
            $company = Company::where('id', $companyId)->first();
            $companies = $company ? [$company->toArray()] : [];
        }

        return response()->json(['data' => $companies]);
    }


    public function index()
    {
        // $company =Company::all();

        // $subscriptions = Subscription::all();
        // $basic_infos = BasicInfo::all();

        return view('company.index');
    }
    public function profile()
    {
        $companyId = Auth::user()->company_id;
        $company =Company::where('id', $companyId)->first();

        $subscriptions = Subscription::all();
        // $basic_infos = BasicInfo::all();

        return view('company.profile' , compact('company', 'subscriptions'));
    }

    public function create()
    {
        $taxes = Tax::all();
        return view('company.create', compact('taxes'));
    }

    public function store(Request $request)
    {
        Log::info('Store Request', ['request' => $request->all()]);
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'owner_name' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|unique:companies,email',
            'country' => 'nullable|string|max:50',
            'trade_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'address' => 'nullable|string',
            'purchased_subscriptions' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'vat' => 'required|numeric',
            'tax' => 'required|numeric',
            'duty' => 'required|numeric',
            'terms_and_conditions' => 'nullable|string',
        ]);

        // Calculate VAT and total amounts
        $totalWithoutVTD = $request->unit_price * $request->purchased_subscriptions;
        $vat = $totalWithoutVTD * $request->vat/100;
        $tax = $totalWithoutVTD * $request->tax/100;
        $duty = $totalWithoutVTD * $request->duty/100;
        $totalWithVTD = $totalWithoutVTD + $vat + $tax + $duty;

        $invoice= $this->generateUniqueInvoice();

        // Handle image upload
        $tradeLicensePath = null;
        if ($request->hasFile('trade_license')) {
            $tradeLicensePath = $request->file('trade_license')->store('trade_licenses', 'public');
        }

        // Create a new retail record
        $company = Company::create([
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'trade_license' => $tradeLicensePath,
            'address' => $request->address,
            'country' => $request->country,
            'purchased_subscriptions' => $request->purchased_subscriptions,
            'unit_price' => $request->unit_price,
            'vat' => $request->vat,
            'tax' => $request->tax,
            'duty' => $request->duty,
            'currency' => $request->currency,
            'balance' => $request->purchased_subscriptions,
            'password' => $request->password,
            'terms_and_conditions' => $request->terms_and_conditions,
        ]);
        $customerId = $this->generateUniqueCustomerId();
        Customer::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'country' => $request->country,
            'company_id' => $company->id,
            'customer_id' => $customerId,
        ]);

        Subscription::create([
            'company_id' => $company->id,
            'company_name' => $company->name,
            'purchased_subscription' => $request->purchased_subscriptions,
            'unit_price' => $request->unit_price,
            'vat' => $vat,
            'tax' => $tax,
            'duty' => $duty,
            'total_without_vtd' => $totalWithoutVTD,
            'total_with_vtd' => $totalWithVTD,
            'invoice_number' => $invoice,
            'approve_status' => 1,
            'payment_status' => 0,
        ]);
        $user=  User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'company_id' => $company->id,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole(9);

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }
    private function generateUniqueCustomerId()
    {
        do {
            $id = random_int(100000, 999999);
        } while (Customer::where('customer_id', $id)->exists());

        return $id;
    }

    private function generateUniqueInvoice()
    {
        do {
            $id = random_int(100000, 999999);
        } while (Subscription::where('invoice_number', $id)->exists());

        return $id;
    }


    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $taxes = Tax::all();
        return view('company.edit', compact('company' , 'taxes'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:50',
            'owner_name' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|unique:companies,email,' . $id,
            'country' => 'nullable|string|max:50',
            'trade_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'address' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:20',
            'password' => 'string|min:6',
            'vat' => 'required|numeric',
            'tax' => 'required|numeric',
            'duty' => 'required|numeric',
            'terms_and_conditions' => 'nullable|string',
        ]);

        // Handle picture update
        $imageName = $company->trade_license;

            if ($request->hasFile('trade_license')) {

                if ($company->trade_license && Storage::exists('public/' . $company->trade_license)) {
                    Storage::delete('public/' . $company->trade_license);
                }

                $image = $request->file('trade_license');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('public/trade_licenses', $imageName);
                $imageName = str_replace('public/', '', $imagePath);
            }
        $company->update([
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'trade_license' => $imageName,
            'address' => $request->address,
            'unit_price' => $request->unit_price,
            'password' => $request->password,
            'country' => $request->country,
            'vat' => $request->vat,
            'tax' => $request->tax,
            'duty' => $request->duty,
            'currency' => $request->currency,
            'terms_and_conditions' => $request->terms_and_conditions,
        ]);
        $user= User::where('company_id', $id)->first();
        if ($user) {
            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        $subscription = Subscription::where('company_id', $id)->first();
        if ($subscription) {
            $subscription->update([
                'company_name' => $request->name,
            ]);
        }
        // Update the customer information
        $customer = Customer::where('company_id', $id)->first();
        if ($customer) {
            $customer->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'country' => $request->country,
            ]);
        }
        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }

    public function show($id)
    {

        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect()->route('company.index')->with('error', 'Company not found.');
        }
        if (!empty($company->trade_license) && Storage::disk('public')->exists($company->trade_license)) {
            Storage::disk('public')->delete($company->trade_license);
        }

        $sub = Subscription::where('company_id', $id);

        if ($sub->exists()) {
            $sub->delete();
        }
        $customer = Customer::where('company_id', $id);
        if ($customer->exists()) {
            $customer->delete();
        }
        $user = User::where('company_id', $id);
        if ($user->exists()) {
            $user->delete();
        }
        $company->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Retail deleted successfully.'], 200);
        }
        return redirect()->back()->with('success', 'Retail deleted successfully.');
    }

    // API

    // public function lock_device(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'imei' => 'required|digits:15',
    //     ], [
    //         'imei.required' => 'The imei field is required.',
    //         'imei.digits' => 'The imei number must be exactly 15 digits.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'Unsuccessful',
    //             'statusCode' => 422,
    //             'message' => 'Validation errors',
    //             'role' => null,
    //             'data' => $validator->errors(),
    //         ], 422);
    //     }

    //     $validated = $validator->validated();

    //     $retail = BasicInfo::where('imei_1', $validated['imei'])->orWhere('imei_2', $validated['imei'])->first();

    //     if (!$retail) {
    //         return response()->json([
    //             'status' => 'Unsuccessful',
    //             'statusCode' => 404,
    //             'message' => 'IMEI not found',
    //             'role' => null,
    //             'data' => $confirmationResponse['data'] ?? null,
    //         ], 404);
    //     }

    //     $confirmationResponse = $this->sendConfirmationRequest($validated['imei']);

    //     if (!isset($confirmationResponse['statusCode'])) {
    //         return response()->json([
    //             'status' => 'Error Occured',
    //             'statusCode' => 500,
    //             'message' => 'Invalid response from confirmation service',
    //             'role' => null,
    //             'data' => $confirmationResponse['data'] ?? null,
    //         ], 500);
    //     }

    //     if ($confirmationResponse['statusCode'] !== 200) {
    //         return response()->json([
    //             'status' => $confirmationResponse['status'],
    //             'statusCode' => $confirmationResponse['statusCode'],
    //             'message' => $confirmationResponse['message'],
    //             'role' => $confirmationResponse['role'],
    //             'data' => $confirmationResponse['data'],
    //         ], $confirmationResponse['statusCode']);
    //     }

    //     $retail->device_lock = 1;
    //     $retail->password = $confirmationResponse['data'];
    //     $retail->lock_status = 'Locked by Retailer';
    //     $retail->save();

    //     // Fetch retailer information
    //     $retailer = Retail::find($retail->retail_id);

    //     if ($retailer) {
    //         // Save activity log
    //         $activityLog = new ActivityLog();
    //         $activityLog->user_name = $retailer->name;
    //         $activityLog->user_id = $retailer->id;
    //         $activityLog->activity = "Locked by Retailer";
    //         $activityLog->imei_1 = $retail->imei_1;
    //         $activityLog->imei_2 = $retail->imei_2;
    //         $activityLog->save();
    //     }

    //     return response()->json([
    //         'status' => $confirmationResponse['status'],
    //         'statusCode' => $confirmationResponse['statusCode'],
    //         'message' => $confirmationResponse['message'],
    //         'role' => $confirmationResponse['role'],
    //         'data' => $confirmationResponse['data'],
    //     ], $confirmationResponse['statusCode']);
    // }

    // private function sendConfirmationRequest($imei)
    // {
    //     try {

    //         $url = 'https://mdm.mobi-manager.com:8443/mobimanager-mobipay/api/lock-device-by-retail/' . $imei;
    //         $response = Http::timeout(60)->retry(3, 1000)->withOptions(['verify' => false])->get($url);
    //         // return [
    //         //     'status' => 'Successful',
    //         //     'statusCode' => 200,
    //         //     'message' => 'Device Locked Successfully',
    //         //     'role' => null,
    //         //     'data' => 123,
    //         // ];

    //         Log::info('External Service Response', ['response' => $response->json()]);

    //         return $response->json();
    //     } catch (\Exception $e) {
    //         Log::error('External Service Error', ['error' => $e->getMessage()]);

    //         return [
    //             'status' => 'Error Occured',
    //             'statusCode' => 500,
    //             'message' => 'Failed to contact confirmation service',
    //             'role' => null,
    //             'data' => null,
    //         ];
    //     }
    // }


}
