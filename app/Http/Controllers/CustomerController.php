<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomer;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomer $request)
    {
        $request->fulfill();

        return redirect()->route('customer.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil ditambah'
                ]
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        $customer = $request->route('customer');
        return view('customer.update', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomer $request)
    {
        $request->fulfill();

        return redirect()->route('customer.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil diubah'
                ]
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $customer = $request->route('customer');
        $customer->delete();

        return redirect()->route('customer.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil dihapus'
                ]
            ]
        );
    }
}
