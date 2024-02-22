<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
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
        return [
            'home.seo_h1' => 'string|nullable',
            'home.seo_title' => 'string|nullable',
            'home.seo_description' => 'string|nullable',
            'home.seo_keywords' => 'string|nullable',
            'home.seo_text' => 'string|nullable',
        ];
    }
}
