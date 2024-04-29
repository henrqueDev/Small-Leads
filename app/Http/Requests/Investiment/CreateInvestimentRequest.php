<?php

namespace App\Http\Requests\Investiment;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvestimentRequest extends FormRequest
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
            "title" => "required",
            "investiment_date" => "required",
            "amount" => "required",
            "lead_id" => "required"
        ];
    }
}
