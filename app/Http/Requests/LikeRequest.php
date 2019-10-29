<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'post_id' => [
                'required',
                Rule::unique('likes')->where(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
            ]
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'post_id.unique' => 'Post already liked.',
        ];
    }
}
