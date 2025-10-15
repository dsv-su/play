<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        //To enforce permissions
        return true;
    }

    public function rules(): array
    {
        return [
            'videos'   => ['required', 'array'],
            'videos.*' => ['string', 'distinct'],
        ];
    }
}

