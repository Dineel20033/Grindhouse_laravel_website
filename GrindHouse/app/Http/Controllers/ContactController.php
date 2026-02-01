<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Replaces contact_us.php (Show form)
    public function index()
    {
        // The view file is at `resources/views/contact.blade.php`
        return view('contact');
    }
    
    // Replaces send_message.php (Handle form submission)
    public function store(Request $request)
    {
        // Validation (SECURITY: Protects against SQL injection/bad data)
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Insert into database (Replaces raw INSERT query)
        ContactMessage::create($validated);

        // Redirect back to the contact form with a friendly success message (view uses session('success'))
        return redirect()->route('contact.index')->with('success', 'Your message has been sent successfully.');
    }
}