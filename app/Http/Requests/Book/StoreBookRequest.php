<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:12', 'max:128', 'unique:books'],
            'author' => ['required', 'min:3', 'max:64'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'countPages' => ['required', 'integer'],
        ];
    }
}
