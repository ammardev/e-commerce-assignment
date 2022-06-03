<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'is_vat_included' => 'nullable|boolean',
            'vat_percentage' => 'nullable|numeric|min:0',
            'shipping_fixed_cost' => 'nullable|numeric|min:0',
        ];
    }
}
