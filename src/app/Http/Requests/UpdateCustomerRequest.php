<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $email = $this->input('email');

        if (is_string($email)) {
            $this->merge([
                'email' => Str::lower(trim($email)),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:254',
                Rule::unique('customers', 'email')
                    ->ignore($this->route('customer')),
            ],
            'phone' => ['required', 'string', 'max:15'],
            'photo' => [
                'bail',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'dimensions:max_width=4096,max_height=4096',
            ],
        ];
    }
}
