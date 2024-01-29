<?php

namespace App\Http\Requests;

use App\Rules\correctBrazilCellPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;


class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required","min:3"],
            "email" => [
                "required",
                "min:5",
                "email",
                Rule::unique('contacts')->where(fn (Builder $query) => $query->where('user_id', $this->user()->id))->ignore($this->id)
            ],
            "address" => ["required","min:5"],
            "phone_numbers.*.id" => ["nullable","integer"],
            "phone_numbers.*.number" => [new correctBrazilCellPhone()]
        ];
    }
}
