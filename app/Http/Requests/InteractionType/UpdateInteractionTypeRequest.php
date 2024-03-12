<?php

namespace App\Http\Requests\InteractionType;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lead;

class UpdateInteractionTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorize = $this->interactionType->user_id == $this->user()->id ? true : false;
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
            'id' => 'required',
            'name' => 'required|unique:interaction_types'
        ];
    }

}
