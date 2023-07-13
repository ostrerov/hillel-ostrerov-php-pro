<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'id' => ['integer', 'exists:books'],
            'name' => ['min:12', 'max:128', 'unique:books'],
            'year' => ['integer', 'min:1970', 'max:' . date('Y')],
            'lang' => ['string', 'in:en,ua,pl,de'],
            'pages' => ['integer', 'min:10', 'max:55000']
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('book')
        ]);
    }
}
