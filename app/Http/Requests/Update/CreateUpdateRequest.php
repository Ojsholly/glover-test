<?php

namespace App\Http\Requests\Update;

use App\Models\Update;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,uuid'],
            'requested_by' => ['required', 'uuid', 'exists:users,uuid'],
            'type' => ['required', 'in:'.Update::CREATE.','.Update::UPDATE.','.Update::DELETE,'string'],
            'details' => ['required_unless:type,'.Update::DELETE,'array'],
            'details.*' => ['string']
        ];
    }
}
