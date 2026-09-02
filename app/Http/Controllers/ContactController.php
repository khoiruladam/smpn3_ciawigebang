<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $isAnonymous = $request->boolean('is_anonymous');
        $validated = $request->validated();

        ContactMessage::create([
            'name' => $isAnonymous ? null : strip_tags($validated['name'] ?? ''),
            'email' => $isAnonymous ? null : $validated['email'],
            'is_anonymous' => $isAnonymous,
            'message' => strip_tags($validated['message']),
        ]);

        return redirect()
            ->to(url()->previous() . '#kontak')
            ->with('success', 'Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.');
    }
}