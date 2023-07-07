<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['min:12', 'max:128', 'unique:books'],
            'author' => ['min:3', 'max:64'],
            'year' => ['integer', 'min:1900', 'max:' . date('Y')],
            'countPages' => ['integer'],
        ];
    }
}
