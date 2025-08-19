<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string',
            'name' => 'required|string',
        ]);

        $email = $request->email;
        $code = $request->code;
        $name  = $request->name;

        try {
            // Send email
            $this->sendEmail($email, $name, $code);
            return response()->json([
                'success' => true,
                'message' => 'Reset code sent successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Password Reset Email Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset code. Please try again.'
            ], 500);
        }
    }

    private function sendEmail($email, $name, $code)
    {
        $htmlContent = view('emails.password_reset_mobile', [
            'name' => $name,
            'code' => $code,
        ])->render();

        Mail::html($htmlContent, function ($message) use ($email) {
            $message->to($email)
                ->subject('Password Reset - Tara');
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



}
