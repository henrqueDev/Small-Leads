<?php

namespace App\Http\Requests\Interaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInteractionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorize = $this->interaction->user_id == $this->user()->id ? true : false;
        return $authorize;
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
