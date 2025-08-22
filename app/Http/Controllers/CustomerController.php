<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CustomerController extends Controller
{


    public function index(Request $request)
    {
        $customer= Customer::with('company')->get();
        return response ()->json ( [
            'status'   => 200,
            'data' => $customer,
        ] );

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:customers,email',
            'address' => 'nullable',
            'country' => 'required',
            'company_id' => 'required',
        ]);

        $validated['customer_id'] = $this->generateCustomerId();
        Customer::create($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Customer created successfully'
        ]);
    }

    private function generateCustomerId()
    {
        do {
            $id = random_int(100000, 999999);
        } while (Customer::where('customer_id', $id)->exists());

        return $id;
    }
    public function show()
    {
        $companies = Company::all();
        return view('customer.index',compact('companies'));

    }


    public function edit( $id)
    {
        $customer= Customer::find($id);
        return response ()->json ( [
            'status'   => 200,
            'data' => $customer,
        ] );

    }

    public function update(Request $request,$id)
    {
        log::info($request);
        $customer= Customer::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'sometimes|required|email|unique:customers,email,' .$id,
            'address' => 'nullable',
            'country' => 'required',
            'company_id' => 'required',
            // 'customer_id' => 'required',
        ]);

        $customer->update($validated);
        session()->flash('success', 'Customer updated successfully');


        return response ()->json ( [
            'status'   => 200,
            'message' => "Customer updated successfully",
        ] );
    }

    public function destroy($id)
{
    $customer = Customer::findOrFail($id);
    $customer->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Customer deleted successfully',
    ]);
}
}
