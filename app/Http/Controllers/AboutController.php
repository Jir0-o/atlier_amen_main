<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can Access About')->only('index', 'store');
    }
    public function index()
    {
        $about = About::first();
        return view('backend.about.about', compact('about'));
    }

    /**
     * Create or update About (AJAX).
     */
    public function store(AboutRequest $request): JsonResponse
    {
        $about = About::first() ?? new About();

        $about->title = $request->input('title');
        $about->body  = $request->input('body');

        // Image upload (optional)
        if ($request->hasFile('image')) {
            // Delete old file (if exists)
            if ($about->image_path && Storage::disk('public')->exists($about->image_path)) {
                Storage::disk('public')->delete($about->image_path);
            }

            // Store new
            if ($request->hasFile('image')) {
                // Create folder if not exists
                $destination = public_path('uploads/about');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                // Delete old image if exists
                if ($about->image_path && file_exists(public_path($about->image_path))) {
                    unlink(public_path($about->image_path));
                }

                // Generate unique name
                $filename = uniqid('about_') . '.' . $request->file('image')->getClientOriginalExtension();

                // Move file to public/uploads/about
                $request->file('image')->move($destination, $filename);

                // Save relative path for DB
                $about->image_path = 'uploads/about/' . $filename;
            }
        }

        $about->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'About section saved successfully.',
            'title'     => $about->title,
            'body'      => $about->body,
            'image_url' => $about->image_url,
        ]);
    }
}