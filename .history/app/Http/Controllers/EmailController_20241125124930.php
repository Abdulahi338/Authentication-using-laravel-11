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
        $incomingEmails = IncomingEmail::where('user_id', auth()->id())->paginate(10);
        $outgoingEmails = OutgoingEmail::where('user_id', auth()->id())->paginate(10);
        
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

        // Also store it as an incoming email (for simulation purposes)
        IncomingEmail::create([
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

    // Dashboard method to show email statistics and recent emails
    public function dashboard()
    {
        // Count incoming and outgoing emails
        $incomingCount = IncomingEmail::where('user_id', auth()->id())->count();
        $outgoingCount = OutgoingEmail::where('user_id', auth()->id())->count();
        $totalEmails = $incomingCount + $outgoingCount;
    
        // Fetch latest emails for display
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
    
        // Pass the data to the view
        return view('emails.dashboard', compact('incomingCount', 'outgoingCount', 'totalEmails', 'emails'));
    }

    // Method to list incoming emails
    public function incomingEmails()
    {
        $incomingEmails = IncomingEmail::where('user_id', auth()->id())->paginate(10);
        return view('emails.incoming', compact('incomingEmails'));
    }

    // Method to add an incoming email (simulating an incoming email)
    public function addIncomingEmail(Request $request)
    {
        // Validate incoming email data
        $request->validate([
            'from' => 'required|email',  // Make sure 'from' is included in the form and validated
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        // Store the incoming email in the database
        IncomingEmail::create([
            'user_id' => auth()->id(),
            'from' => $request->from,  // Ensure that 'from' is being passed
            'subject' => $request->subject,
            'content' => $request->content,
            'received_at' => now(),
        ]);
    
        // Fetch all incoming emails for the user
        $incomingEmails = IncomingEmail::where('user_id', auth()->id())->get();
    
        // Return the view with the incoming emails
        return view('emails.incoming', compact('incomingEmails'))->with('message', 'Incoming email added successfully!');
    }
    

    // Method to list outgoing emails
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

    // View the email
    public function view($emailId)
    {
        $email = OutgoingEmail::findOrFail($emailId);  // Adjust this depending on whether it's an incoming or outgoing email
        return view('emails.view', compact('email'));
    }

    // Destroy (delete) an email
    public function destroy($emailId)
    {
        // Find the email or fail if not found
        $email = OutgoingEmail::findOrFail($emailId);  // You may want to adjust this to IncomingEmail if applicable
        
        // Delete the email
        $email->delete();

        // Redirect with a success message
        return redirect()->route('emails.index')->with('message', 'Email deleted successfully!');
    }
}
