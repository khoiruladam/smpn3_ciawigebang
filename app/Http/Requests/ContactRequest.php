<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isAnonymous = $this->boolean('is_anonymous');

        return [
            'name' => [
                $isAnonymous ? 'nullable' : 'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\.\-\']+$/u',
            ],
            'email' => [
                $isAnonymous ? 'nullable' : 'required',
                'email:rfc',
                'max:150',
            ],
            'message' => [
                'required',
                'string',
                'min:5',
                'max:2000',
                'not_regex:/<\s*script/i',
                'not_regex:/(javascript:|on\w+\s*=)/i',
            ],
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Nama hanya boleh berisi huruf.',
            'message.not_regex' => 'Pesan mengandung karakter yang tidak diizinkan.',
            'website.prohibited' => 'Terjadi kesalahan. Silakan coba lagi.',
        ];
    }

}