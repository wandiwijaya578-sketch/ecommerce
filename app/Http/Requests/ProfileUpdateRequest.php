<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini.
     * Karena route sudah pakai middleware auth,
     * maka user yang login boleh update profilnya sendiri.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi data profil.
     */
    public function rules(): array
    {
        return [
            // Nama wajib
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            // Email wajib & unik (kecuali milik user sendiri)
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Nomor HP Indonesia (opsional)
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/',
            ],

            // Alamat (opsional)
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            // Avatar (opsional)
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
        ];
    }

    /**
     * Pesan error custom (Bahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan 08xx atau +628xx.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
            'avatar.dimensions' => 'Dimensi foto harus antara 100x100 sampai 2000x2000 pixel.',
        ];
    }

    /**
     * Nama field yang lebih ramah untuk error message.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'alamat email',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'avatar' => 'foto profil',
        ];
    }
}
