<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'Required',
            'body' => 'Required|max:100',
            'user_id' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages():array
    {
        return [
            'title.required' => __('validation.required'),
            'body.max' => __('validation.max.string', ['max' => 100]),
            'body.required' => __('validation.required'),
        ];
    }

    /** 
     * 
    */
    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->category->id,
            'user_id' => auth()->user()->id
        ]);
    }

}
