<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * Store a new contact form submission (AJAX).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'number'  => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Please fix the errors and try again.',
            ], 422);
        }

        $data = $validator->validated();
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr((string) $request->userAgent(), 0, 500); 

        ContactMessage::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Thank you! Your message has been sent.',
        ]);
    }
}
