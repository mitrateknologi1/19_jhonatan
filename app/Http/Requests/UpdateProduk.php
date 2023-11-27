<?php

namespace App\Http\Requests;

use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProduk extends CreateProduk
{
    public function fulfill(): void
    {
        $this->route('produk')->update([
            'nama' => $this->validated(['nama'])
        ]);
    }
}
