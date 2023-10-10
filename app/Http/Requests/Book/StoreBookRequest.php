<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:12', 'max:128', 'unique:books'],
            'year' => ['required', 'integer', 'min:1970', 'max:'. date('Y')],
            'lang' => ['required', Rule::enum(Lang::class)],
            'pages' => ['required', 'integer', 'min:10', 'max:55000'],
            'categoryId' => ['integer', 'exists:categories,id', 'required'],
        ];
    }

    public function validationData(): array
    {
        $validated = parent::validationData();

        if (isset($validated['lang'])) {
            $validated['lang'] = Lang::from($validated['lang']);
        }

        return $validated;
    }
}
