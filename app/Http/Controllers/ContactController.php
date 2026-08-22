<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $isAnonymous = $request->boolean('is_anonymous');

        $validated = $request->validate([
            'name' => [$isAnonymous ? 'nullable' : 'required', 'string', 'max:255'],
            'email' => [$isAnonymous ? 'nullable' : 'required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create([
            'name' => $isAnonymous ? null : $validated['name'],
            'email' => $isAnonymous ? null : $validated['email'],
            'is_anonymous' => $isAnonymous,
            'message' => $validated['message'],
        ]);

        return redirect()->to(url()->previous() . '#kontak')->with('success', 'Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.');
    }
}