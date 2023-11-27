<?php

namespace App\Http\Requests;

use App\Imports\PenjualanImport;
use Illuminate\Foundation\Http\FormRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportPenjualan extends FormRequest
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
            'file' => ['required', 'file', 'mimes:xlsx,xls']
        ];
    }

    public function fulfill(): void
    {
        $path = $this->file('file')->store('imports');
        Excel::import(new PenjualanImport, $path);
    }
}
