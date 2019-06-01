<?php

namespace KW\Application\Requests\EventDetail;

use Illuminate\Foundation\Http\FormRequest;

class EventDetail extends FormRequest
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
            'event_master_id'  => 'required',
            'event_pr_id'      => 'required',
            'title'            => 'required',
            'detail'           => 'required',
            'handing'          => 'required',
            'started_at'       => 'required',
            'expired_at'       => 'required',
            'capacity_members' => 'required',
            'event_minutes'    => 'required',
            'target_min_age'   => 'required',
            'target_max_age'   => 'required',
            'parent_attendant' => 'required',
            'price'            => 'required',
            'cancel_policy'    => 'required',
            'cancel_deadline'  => 'required',
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
