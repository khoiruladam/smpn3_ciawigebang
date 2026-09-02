<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Endpoint publik — tidak perlu autentikasi.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi parameter pencarian.
     * - 'q' bersifat opsional, tapi jika ada harus string dan max 100 karakter.
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
        ];
    }
}
