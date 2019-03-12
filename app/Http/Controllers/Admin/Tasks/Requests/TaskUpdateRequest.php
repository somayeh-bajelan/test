<?php

namespace App\Http\Controllers\Admin\Tasks\Requests;

use Illuminate\Foundation\Http\FormRequest;

/*
 *
 * for validate fields in update announcement
 *
 */
class TaskUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'size:12'],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'password' => ['required', 'min:8']
        ];

    }
}
