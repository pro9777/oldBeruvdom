<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $title = $this->input('product.title');
        $alias = $this->input('product.alias');
        $request_arr = $this->product;
        if (empty($alias)) {
            $name = str_slug($title, '-');
            $request_arr['alias'] = $name;
            $this->merge([
                'product' => $request_arr,
            ]);
        }

        if (isset($this->all()['product']['id'])){
            return [
                'product.title' => [
                    'required',
                    Rule::unique('products', 'title')->ignore($this->all()['product']['id'])
                ],
                'product.alias' => [
                    Rule::unique('products', 'alias')->ignore($this->all()['product']['id'])
                ],

                'product.price' => 'string|nullable',
                'product.parent_id' => 'string|nullable',
                'product.show_price' => 'string|nullable',
                'product.old_price' => 'string|nullable',
                'product.measurement' => 'string|nullable',
                'product.brend' => 'string|nullable',
                'product.articular' => 'nullable',
                'product.products_like' => 'nullable',
                'product.collection' => 'string|nullable',
                'product.keywords' => 'string|nullable',
                'product.description' => 'string|nullable',
                'product.description2' => 'string|nullable',
                'product.keywords' => 'string|nullable',
                'product.seo_h1' => 'string|nullable',
                'product.seo_title' => 'string|nullable',
                'product.seo_description' => 'string|nullable',
                'product.seo_keywords' => 'string|nullable',
                'product.seo_text' => 'string|nullable',
                'product.blueprints_text' => 'string|nullable',
            ];
        }

        return [
            'product.title' => [
                'required',
                Rule::unique('products', 'title')
            ],
            'product.alias' => [
                Rule::unique('products', 'alias')
            ],
            'product.price' => 'string|nullable',
            'product.parent_id' => 'string|nullable',
            'product.show_price' => 'string|nullable',
            'product.old_price' => 'string|nullable',
            'product.measurement' => 'string|nullable',
            'product.brend' => 'string|nullable',
            'product.articular' => 'nullable',
            'product.products_like' => 'nullable',
            'product.collection' => 'string|nullable',
            'product.keywords' => 'string|nullable',
            'product.description' => 'string|nullable',
            'product.description2' => 'string|nullable',
            'product.keywords' => 'string|nullable',
            'product.seo_h1' => 'string|nullable',
            'product.seo_title' => 'string|nullable',
            'product.seo_description' => 'string|nullable',
            'product.seo_keywords' => 'string|nullable',
            'product.seo_text' => 'string|nullable',
            'product.blueprints_text' => 'string|nullable',
        ];

    }

    public function messages(): array
    {
        return [
            'product.title.required' => '(Название) обязательное поле',
            'product.title.unique' => '(Название) - занято',
            'product.alias.required' => '(Ссылка) обязательное поле',
            'product.alias.unique' => '(Ссылка) - занята',
            'product.alias' => '(Ссылка) обязательное поле',
            'product.price' => '(Цена) обязательное поле'
        ];
    }
}
