<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomer extends CreateCustomer
{
    public function fulfill(): void
    {
        $this->route('customer')->update($this->validated());
    }
}
