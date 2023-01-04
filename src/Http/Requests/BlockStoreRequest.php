<?php

namespace MSA\LaravelGrapes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockStoreRequest extends FormRequest
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
            'name'       => ['required', 'string', 'unique:custom_blocks,name'],
            'block_data' => ['required'],
        ];
    }
}
