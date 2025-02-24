<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function showForm() : View
    {
        return view('houses.sections.contact');
    }
    public function submitForm(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type_of_question' => 'required|string',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->route('contact.form')->with('success', 'Your message has been sent successfully!');
    }
}
