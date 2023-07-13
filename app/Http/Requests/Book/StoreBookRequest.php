<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:12', 'max:128', 'unique:books'],
            'year' => ['required', 'integer', 'min:1970', 'max:'. date('Y')],
            'lang' => ['required', 'string', 'in:en,ua,pl,de'],
            'pages' => ['required', 'integer', 'min:10', 'max:55000']
        ];
    }
}
