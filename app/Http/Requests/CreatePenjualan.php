<?php

namespace App\Http\Requests;

use App\Models\Penjualan;
use Illuminate\Foundation\Http\FormRequest;

class CreatePenjualan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'customer_id' => 'required|numeric|min:1',
            'produk_id' => 'required|numeric|min:1',
            'qty' => 'required|numeric|min:1',
            'harga_unit' => 'required|numeric|min:1',
        ];
    }

    public function fulfill(): void
    {
        $input = $this->validated();

        Penjualan::create([
            ...$input,
            'harga_total' => (int) $input['qty'] * (int) $input['harga_unit']
        ]);
    }
}
