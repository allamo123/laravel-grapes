<?php

namespace MSA\LaravelGrapes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockUpdateRequest extends FormRequest
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
        $id = (int)$this->route()->id;

        return [
            'name' => ['required', 'string', 'unique:custome_blocks,name,'.$id],
        ];
    }
}
