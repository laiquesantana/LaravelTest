<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ref' => ['required'],
            'quantity' => ['required'],
            'category' => ['required'],
            'quantity' => ['required'],
            'price_ht' => ['required'],
            'image' => ['required'],
            'price_ttc' => ['required'],
            'active' => ['required'],
            'resume' => ['required'],
            'description' => ['required'],
        ];
    }
}
