<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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

        $title = $this->input('category.title');
        $alias = $this->input('category.alias');
        $request_arr = $this->category;
        if (empty($alias)) {
            $name = str_slug($title, '-');
            $request_arr['alias'] = $name;
            $this->merge([
                'category' => $request_arr,
            ]);
        }
        $stati = $this->input('category.stati');
        if (empty($stati)) {
            $request_arr['stati'] = '';
            $this->merge([
                'category' => $request_arr,
            ]);
        }

//        dd($this->all());
        if (isset($this->all()['category']['id'])) {
            return [
                'category.title' => [
                    'required',
                    Rule::unique('categories', 'title')->ignore($this->all()['category']['id'])
                ],
                'category.alias' => [
                    Rule::unique('categories', 'alias')->ignore($this->all()['category']['id'])
                ],
                'category.parent_id' => 'string|nullable',
                'category.description' => 'string|nullable',
                'category.description' => 'string|nullable',
                'category.keywords' => 'string|nullable',
                'category.blueprints_text' => 'string|nullable',
                'category.seo_h1' => 'string|nullable',
                'category.seo_title' => 'string|nullable',
                'category.seo_description' => 'string|nullable',
                'category.seo_keywords' => 'string|nullable',
                'category.seo_text' => 'string|nullable',
                'category.stati' => 'nullable',
            ];
        }
        return [
            'category.title' => [
                'required',
                Rule::unique('categories', 'title')
            ],
            'category.alias' => [
                'required',
                Rule::unique('categories', 'alias')
            ],
            'category.parent_id' => 'string|nullable',
            'category.description' => 'string|nullable',
            'category.keywords' => 'string|nullable',
            'category.seo_h1' => 'string|nullable',
            'category.seo_title' => 'string|nullable',
            'category.seo_description' => 'string|nullable',
            'category.seo_keywords' => 'string|nullable',
            'category.blueprints_text' => 'string|nullable',
            'category.seo_text' => 'string|nullable',
            'category.stati' => 'nullable',
        ];

    }

    public function messages(): array
    {
        return [
            //required
            'category.title' => '(Имя) - Обязательное поле',
            'category.alias' => '(Ссылка) - ссылка занята',
            'category.title.unique' => '(Имя) - занято',
            'category.description.unique' => '(Ссылка) - занята'
        ];
    }
}
