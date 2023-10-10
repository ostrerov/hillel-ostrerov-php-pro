<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'id' => ['integer', 'exists:books'],
            'name' => ['string', 'min:1', 'max:255', 'unique:books,name,' . $this->id],
            'year' => ['integer', 'min:1970', 'max:' . Carbon::now()->format('Y')],
            'lang' => [Rule::enum(Lang::class)],
            'pages' => ['integer', 'min:10', 'max:55000'],
            'categoryId'    => ['integer', 'exists:categories,id'],
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

    public function validationData(): array
    {
        $validated = parent::validationData();

        $validated['lang'] = Lang::from($validated['lang']);

        return $validated;
    }
}
