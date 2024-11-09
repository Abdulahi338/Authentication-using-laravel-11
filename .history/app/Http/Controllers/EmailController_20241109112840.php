<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class EmailController extends Controller
{
    public function index()
    {
        $incomingEmails = IncomingEmail::where('user_id', auth()->id())->get();
        $outgoingEmails = OutgoingEmail::where('user_id', auth()->id())->get();
        return view('emails.index', compact('incomingEmails', 'outgoingEmails'));
    }

    public function create()
    {
        return view('emails.create');
    }

    public function store(Request $request)
    {
        // Validate and store outgoing email
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        OutgoingEmail::create([
            'user_id' => auth()->id(),
            'to' => $request->to,
            'subject' => $request->subject,
            'content' => $request->content,
            'sent_at' => now(),
        ]);

        return redirect()->route('emails.index')->with('message', 'Email sent successfully!');
    }
    

    public function destroy(IncomingEmail $incomingEmail)
    {
        $incomingEmail->delete();
        return redirect()->route('emails.index')->with('message', 'Email deleted successfully!');
    }
}

