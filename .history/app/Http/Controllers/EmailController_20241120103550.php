<?php

namespace App\Http\Controllers;

use App\Models\IncomingEmail;
use App\Models\OutgoingEmail;
use Illuminate\Http\Request;
use App\Mail\UserEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailController extends Controller
{
    // Index method to list incoming and outgoing emails
    public function index()
    {
        $incomingEmails = IncomingEmail::where('user_id', auth()->id())->get();
        $outgoingEmails = OutgoingEmail::where('user_id', auth()->id())->get();
        
        return view('emails.index', compact('incomingEmails', 'outgoingEmails'));
    }

    // Show the email creation form
    public function create()
    {
        return view('emails.create');
    }

    // Store a new outgoing email and send it
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Store the outgoing email in the database
        $outgoingEmail = OutgoingEmail::create([
            'user_id' => auth()->id(),
            'to' => $request->to,
            'subject' => $request->subject,
            'content' => $request->content,
            'sent_at' => now(),
        ]);

        // Prepare email details
        $emailDetails = [
            'to' => $request->to,
            'subject' => $request->subject,
            'content' => $request->content,
        ];

        // Send the email using the UserEmail Mailable
        Mail::to($request->to)->send(new UserEmail($emailDetails));

        return redirect()->route('emails.index')->with('message', 'Email sent successfully!');
    }

    // Dashboard method to provide data for an admin or user dashboard
    public function dashboard()
    {
        // Calculate counts for incoming and outgoing emails
        $incomingCount = IncomingEmail::where('user_id', auth()->id())->count();
        $outgoingCount = OutgoingEmail::where('user_id', auth()->id())->count();
        $totalEmails = $incomingCount + $outgoingCount;

        // Fetch the latest 10 emails (both incoming and outgoing)
        $emails = IncomingEmail::where('user_id', auth()->id())
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->merge(
                        OutgoingEmail::where('user_id', auth()->id())
                        ->latest()
                        ->limit(5)
                        ->get()
                    )
                    ->sortByDesc('created_at'); // Sort by date

        // Pass data to the dashboard view
        return view('emails.dashboard', compact('incomingCount', 'outgoingCount', 'totalEmails', 'emails'));
    }

    

    public function incomingEmails()
{
    IncomingEmail::create([
        'user_id' => auth()->id(), // Replace with the correct user association logic
        'from' => $senderEmail,
        'subject' => $emailSubject,
        'content' => $emailBody,
        'received_at' => now(), // Replace with actual received date if available
    ]);
    
    // Fetch incoming emails for the authenticated user
    $incomingEmails = IncomingEmail::where('user_id', auth()->id())->get();

    // Pass the emails to a view
    return view('emails.incoming', compact('incomingEmails'));
}


    // List outgoing emails
    public function outgoingEmails()
    {
        // Fetch outgoing emails and parse 'sent_at' as Carbon instances
        $outgoingEmails = OutgoingEmail::where('user_id', auth()->id())
                                       ->get()
                                       ->map(function ($email) {
                                           $email->sent_at = Carbon::parse($email->sent_at);
                                           return $email;
                                       });

        // Return the 'emails.outgoing' view with outgoing emails
        return view('emails.outgoing', compact('outgoingEmails'));
    }
}
