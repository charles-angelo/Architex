<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = ContactUs::orderBy('created_at', 'desc')->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Step 1: Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'phone_number' => 'required|digits:11',
            'message' => 'required|string|max:1000',
            'g-recaptcha-response' => 'required',
        ]);

        // ✅ Step 2: Verify Google reCAPTCHA using Laravel HTTP client
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $recaptchaResponse->json();

        if (!($responseBody['success'] ?? false)) {
            return back()
                ->withErrors(['g-recaptcha-response' => 'Please verify that you are not a robot.'])
                ->withInput();
        }

        // ✅ Step 3: Store valid contact message
        ContactUs::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'phone_number' => $validated['phone_number'],
            'message' => $validated['message'],
        ]);

        // ✅ Step 4: Response handling
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Your contact has been submitted successfully']);
        }

        return redirect()->back()->with('success', 'Your contact has been submitted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted successfully');
    }

    /**
     * Export contacts to Excel
     */
    public function export()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
