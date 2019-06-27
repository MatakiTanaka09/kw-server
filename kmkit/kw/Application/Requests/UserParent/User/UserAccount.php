<?php

namespace KW\Application\Requests\UserParent\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAccount extends FormRequest
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
            'parent' => [
                'user_master_id' => 'required',
                'icon'           => '',
                'sex_id'         => 'required',
                'full_name'      => 'required',
                'full_kana'      => 'required',
                'tel'            => 'required',
                'zip_code1'      => 'required',
                'zip_code2'      => 'required',
                'state'          => 'required',
                'city'           => 'required',
                'address1'       => 'required',
                'address2'       => ''
            ],
            'children' => [
                'icon'       => '',
                'sex_id'     => 'required',
                'first_kana' => 'required',
                'last_kana'  => 'required',
                'birth_day'  => 'required'
            ]
        ];
    }
}
