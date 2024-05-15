<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedirectRulesRequest extends FormRequest
{
    private $table            = 'redirect_rules';
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
     * @return array
     */
    public function rules()
    {
        return [
            'data.origin' => 'required|string|unique:'.$this->table.',origin',
            'data.destination' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'required' => sprintf(':attribute %s', __('không được rỗng')),
            'unique' => sprintf(':attribute %s', __('đã tồn tại')),
            // 'name.min'      => 'Name :input chiều dài phải có ít nhất :min ký tứ',
        ];
    }
    public function attributes()
    {
        return [
            'data.origin' => __('Origin'),
            'data.destination' => __('Destination'),
        ];
    }
}
