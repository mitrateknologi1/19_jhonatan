<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenjualan extends CreatePenjualan
{
    public function fulfill(): void
    {
        $input = $this->validated();

        $this->route('penjualan')->update([
            ...$input,
            'harga_total' => (int) $input['qty'] * (int) $input['harga_unit']
        ]);
    }
}
