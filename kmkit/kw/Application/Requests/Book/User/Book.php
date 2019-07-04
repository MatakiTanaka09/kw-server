<?php

namespace KW\Application\Requests\Book\User;
use Illuminate\Foundation\Http\FormRequest;

class Book extends FormRequest
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
            'user_parent_id'   => 'required|string|size:36',
            'user_child_id'    => 'required|string|size:36',
            'event_detail_id'  => 'required|string|size:36',
            'school_master_id' => 'required|string|size:36',
            'status'           => 'required|integer',
            'price'            => 'required',
            'remark'           => ''
        ];
    }
}
