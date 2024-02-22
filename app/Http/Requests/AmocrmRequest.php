<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmocrmRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request_arr = $this->amocrm;
//        dd($request_arr);
        if (!empty($this->amocrm['endTokenTime'])){
            if (is_numeric($this->amocrm['endTokenTime'])) {

                $request_arr['expires_in'] = $request_arr['endTokenTime'];

                $this->merge([
                    'amocrm' => $request_arr,
                ]);
            }
        }

        return [
            'amocrm.subdomain' => 'string|nullable',
            'amocrm.client_id' => 'string|nullable',
            'amocrm.client_secret' => 'string|nullable',
            'amocrm.code' => 'string|nullable',
            'amocrm.redirect_uri' => 'string|nullable',
            'amocrm.access_token' => 'string|nullable',
            'amocrm.refresh_token' => 'string|nullable',
            'amocrm.token_type' => 'string|nullable',
            'amocrm.expires_in' => 'string|nullable',
            'amocrm.endTokenTime' => 'string|nullable',
        ];
    }
}
