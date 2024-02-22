<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatiRequest extends FormRequest
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
        $title = $this->input('stati.title');
        $alias = $this->input('stati.alias');
        $request_arr = $this->stati;
        if (empty($alias)) {
            $name = str_slug($title, '-');
            $request_arr['alias'] = $name;
            $this->merge([
                'stati' => $request_arr,
            ]);
        }

        return [
            'stati.title' => 'required',
            'stati.subtitle' => 'required',
            'stati.alias' => [
                Rule::unique('statis', 'alias')->ignore($this->all()['stati']['id'])
            ],
            'stati.text' => 'required',
            'stati.seo_h1' => 'string|nullable',
            'stati.seo_title' => 'string|nullable',
            'stati.seo_description' => 'string|nullable',
            'stati.seo_keywords' => 'string|nullable',
            'stati.seo_text' => 'string|nullable',
            'stati.updated_at' => 'string|nullable',
        ];
    }
}
