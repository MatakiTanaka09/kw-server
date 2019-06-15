<?php

namespace KW\Application\Requests\UserChild\User;

use Illuminate\Foundation\Http\FormRequest;

class UserChild extends FormRequest
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
            'icon'       => '',
            'sex_id'     => 'required',
            'first_kana' => 'required',
            'last_kana'  => 'required',
            'birth_day'  => 'required'
        ];
    }
}
