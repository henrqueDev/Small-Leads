<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        $authorize = $this->lead->user_id == $this->user()->id ? true : false;
        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "last_name" => "required",
            "email" => "required",
            "phone" => "required",
            "company_id" => "required_without:new_company",
            "new_company" => "required_without:company_id",
            "converted" => "required_with:is_paying",
            "is_paying" => "required_with:converted"
        ];
    }
}
