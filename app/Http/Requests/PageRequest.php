<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
        $title = $this->input('page.title');
        $alias = $this->input('page.alias');
        $request_arr = $this->page;
        if (empty($alias)) {
            $name = str_slug($title, '-');
            $request_arr['alias'] = $name;
            $this->merge([
                'page' => $request_arr,
            ]);
        }

        return [
            'page.title' => 'required',
            'page.subtitle' => 'string|nullable',
            'page.alias' => [
                Rule::unique('pages', 'alias')->ignore($this->all()['page']['id'])
            ],
            'page.text' => 'string|nullable',
            'page.seo_h1' => 'string|nullable',
            'page.seo_title' => 'string|nullable',
            'page.seo_description' => 'string|nullable',
            'page.seo_keywords' => 'string|nullable',
            'page.seo_text' => 'string|nullable',
        ];
    }
}
