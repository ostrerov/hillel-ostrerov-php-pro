<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class IndexBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'startDate' => [
                'required',
                'before:endDate',
                'date_format:Y-m-d',
                'after_or_equal:1970-01-01',
                'before_or_equal:'.date('Y-m-d')
            ],
            'endDate' => [
                'required',
                'after:startDate',
                'date_format:Y-m-d',
                'after_or_equal:1970-01-01',
                'before_or_equal:'.date('Y-m-d')
            ],
            'year' => ['sometimes', 'integer', 'min:1970', 'max:'.date('Y')],
            'lang' => ['sometimes', 'string', 'in:en,ua,pl,de']
        ];
    }
}
