<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProduk;
use App\Http\Requests\UpdateProduk;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('produk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProduk $request)
    {
        $request->fulfill();

        return redirect()->route('produk.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil ditambahkan'
                ]
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        $produk = $request->route('produk');
        return view('produk.update', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduk $request)
    {
        $request->fulfill();

        return redirect()->route('produk.index')->with(
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
        $produk = $request->route('produk');
        $produk->delete();

        return redirect()->route('produk.index')->with(
            [
                'flash-messages' => [
                    'error' => false,
                    'message' => 'Data berhasil dihapus'
                ]
            ]
        );
    }
}
