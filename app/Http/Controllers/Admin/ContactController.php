<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\CompanyDetail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    //admin contact inquiries
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('AdminDashboard.Contact.index', compact('messages'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_comment' => 'required|string',
        ]);

        $message = ContactMessage::findOrFail($id);

        // Update reply info
        $message->update([
            'reply_comment' => $request->reply_comment,
            'is_replied' => true,
            'replied_at' => now(),
        ]);

        // Send reply email to sender
        Mail::send('emails.contact_reply', [
            'messageData' => $message
        ], function ($mail) use ($message) {
            $mail->to($message->email)
                 ->subject('Reply to Your Inquiry');
        });

        return back()->with('success', 'Reply sent successfully.');
    }


    //store contact message from frontend
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = ContactMessage::create($request->only([
            'name',
            'email',
            'phone',
            'subject',
            'message',
        ]));

        // Get company email from .env
        $companyEmail = env('COMPANY_EMAIL', 'manuw2819@gmail.com'); 

        // Send email if company email exists
        if ($companyEmail) {
            Mail::send('emails.contact_message', [
                'contact' => $contact
            ], function ($mail) use ($companyEmail) {
                $mail->to($companyEmail)
                    ->subject('New Contact Inquiry');
            });
        }

        return back()->with('success', 'Your message has been sent successfully.');
    }


       public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'message deleted successfully.');
    }

}