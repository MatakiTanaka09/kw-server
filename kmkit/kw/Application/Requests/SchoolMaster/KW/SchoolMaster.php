<?php

namespace KW\Application\Requests\SchoolMaster\KW;

use Illuminate\Foundation\Http\FormRequest;

class SchoolMaster extends FormRequest
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
            'name'      => 'required',
            'detail'    => 'required',
            'email'     => 'required',
            'url'       => 'required',
            'tel'       => 'required',
            'icon'      => 'required',
            'zip_code1' => 'required',
            'zip_code2' => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'address1'  => 'required',
            'address2'  => 'required',
            'longitude' => 'required',
            'latitude'  => 'required'
        ];
    }
}
