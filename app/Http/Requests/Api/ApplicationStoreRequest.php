<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string'],
        ];
    }
}
