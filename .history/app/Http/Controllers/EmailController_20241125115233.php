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
    public function incomingEmails()
{
    $incomingEmails = IncomingEmail::where('user_id', auth()->id())->paginate(10);

    return view('emails.incoming', compact('incomingEmails'));
}

    

    // Method to add an incoming email (e.g., from an external source or simulation)
    // public function incomingEmails(Request $request)
    // {
    //     // Validate the incoming email data
    //     $request->validate([
    //         'from' => 'required|email',
    //         'subject' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);
    
    //     // Create an incoming email record in the database
    //     IncomingEmail::create([
    //         'user_id' => auth()->id(),
    //         'from' => $request->from, // The sender's email
    //         'subject' => $request->subject, // The subject of the email
    //         'content' => $request->content, // The content of the email
    //         'received_at' => now(), // Current timestamp or actual received date
    //     ]);
    
    //     // Fetch incoming emails for the authenticated user
    //     $incomingEmails = IncomingEmail::where('user_id', auth()->id())->get();
    
    //     // Return the view with incoming emails
    //     return view('emails.incoming', compact('incomingEmails'))->with('message', 'Incoming email added successfully!');
    // }


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

    // view the email

    public function view($emailId)
{
    $email = OutgoingEmail::findOrFail($emailId);  // Adjust this depending on whether it's an incoming or outgoing email
    return view('emails.view', compact('email'));
}

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
