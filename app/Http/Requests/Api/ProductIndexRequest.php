<?php

namespace App\Http\Requests\Api;

use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category' => ['nullable', 'integer', 'exists:product_categories,id'],
            'status' => ['nullable', 'string', Rule::enum(ProductStatusEnum::class)],
            'priceFrom' => ['nullable', 'numeric', 'min:0'],
            'priceTo' => ['nullable', 'numeric', 'min:0', 'gte:priceFrom'],
        ];
    }
}
