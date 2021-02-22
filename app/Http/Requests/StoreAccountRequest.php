<?php

namespace App\Http\Requests;

use App\Models\Accounts;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('accounts_create');
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
