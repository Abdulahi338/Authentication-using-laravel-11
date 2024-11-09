<?php

namespace App\Http\Controllers;

use App\Models\IncomingEmail;
use App\Models\OutgoingEmail;
use Illuminate\Http\Request;
use Carbon\Carbon; // Add this line to import Carbon


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

    public function dashboard()
    {
        // Get counts for the dashboard
        $incomingCount = Email::where('type', 'incoming')->count();
        $outgoingCount = Email::where('type', 'outgoing')->count();
        $totalEmails = Email::count();

        // Get emails to display (e.g., latest 10 emails)
        $emails = Email::latest()->limit(10)->get();

        // Pass data to the view
        return view('posts.dashboard', compact('incomingCount', 'outgoingCount', 'totalEmails', 'emails'));
    }


    public function outgoingEmails()
    {
        // Fetch outgoing emails and ensure 'sent_at' is a Carbon instance
        $outgoingEmails = OutgoingEmail::where('user_id', auth()->id())
                                       ->get()
                                       ->map(function ($email) {
                                           // Ensure 'sent_at' is a Carbon instance
                                           $email->sent_at = Carbon::parse($email->sent_at);
                                           return $email;
                                       });
        
        // Return the 'emails.outgoing' view with outgoing emails data
        return view('emails.outgoing', compact('outgoingEmails'));
    }
}
