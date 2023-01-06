<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $brands = Brand::select('id')->get();
        $brands_ids = $brands->pluck('id');
        return [
            'title' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'integer', 'digits:8', 'unique:products'],
            'details' => ['string', 'max:7650'],
            'price' => ['required', 'numeric'],
            'brand_id' => [Rule::in($brands_ids)]
        ];
    }
}
