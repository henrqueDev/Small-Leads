<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InteractionRequest extends FormRequest
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

    public function rules()
    {
        return [
            'description' => 'required',
            'event_date' => 'required',
            'lead_id' => 'required',
            "interaction_type_id" => "required_without:new_interaction_type",
            "new_interaction_type" => "required_without:interaction_type_id"
        ];
    }

}
