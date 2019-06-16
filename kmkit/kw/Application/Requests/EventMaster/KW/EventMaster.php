<?php

namespace KW\Application\Requests\EventMaster\KW;

use Illuminate\Foundation\Http\FormRequest;

class EventMaster extends FormRequest
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
            'title'            => 'required',
            'detail'           => 'required',
            'handing'          => 'required',
            'event_minutes'    => 'required',
            'target_min_age'   => 'required',
            'target_max_age'   => 'required',
            'parent_attendant' => 'required',
            'price'            => 'required',
            'cancel_policy'    => 'required',
            'pub_state'        => 'required',
            'arrived_at'       => 'required',
            'zip_code1'        => 'required',
            'zip_code2'        => 'required',
            'state'            => 'required',
            'city'             => 'required',
            'address1'         => 'required',
            'address2'         => 'required',
            'longitude'        => 'required',
            'latitude'         => 'required'
        ];
    }
}
