<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'startDate' => [
                'required',
                'before:endDate',
                'date',
                'after_or_equal:1970-01-01',
                'before_or_equal:' . Carbon::now()->format('Y-m-d')
            ],
            'endDate' => [
                'required',
                'after:startDate',
                'date',
                'after_or_equal:1970-01-01',
                'before_or_equal:' . Carbon::now()->format('Y-m-d')
            ],
            'year' => ['sometimes', 'integer', 'min:1970', 'max:'.date('Y')],
            'lang' => ['sometimes', Rule::enum(Lang::class)],
            'lastId' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function validationData(): array
    {
        $validated = parent::validationData();
        $validated['startDate'] = new Carbon($validated['startDate']);
        $validated['endDate'] = new Carbon($validated['endDate']);
        if (isset($validated['lang'])) {
            $validated['lang'] = Lang::from($validated['lang']);
        }
        return $validated;
    }
}
