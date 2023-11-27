<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePenjualan;
use App\Http\Requests\ImportPenjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualan;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $allCustomer = Customer::all();
        $allProduk = Produk::all();
        return view('penjualan.create', compact('allCustomer', 'allProduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePenjualan $request)
    {
        $request->fulfill();

        return redirect()->route('penjualan.index')->with(
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
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $penjualan = $request->route('penjualan');
        $allCustomer = Customer::all();
        $allProduk = Produk::all();

        return view('penjualan.update', compact('penjualan', 'allCustomer', 'allProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenjualan $request)
    {
        $request->fulfill();

        return redirect()->route('penjualan.index')->with(
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
        $penjualan =  $request->route('penjualan');
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil dihapus'
                ]
            ]
        );
    }

    public function import(ImportPenjualan $request): RedirectResponse
    {
        $request->fulfill();
        return redirect()->route('penjualan.index');
    }
}
