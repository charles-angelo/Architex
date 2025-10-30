<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->paginate();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Banner store method called', ['request_data' => $request->all()]);

        try {
            // ✅ Validation (supports images, GIFs, and videos)
            $request->validate([
                'title'    => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'media'    => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi',
            ]);

            $file = $request->file('media');
            $mimeType = $file->getMimeType();

            // ✅ Determine file size limit (GIF included with images)
            $maxSize = str_starts_with($mimeType, 'image/')
                ? 5 * 1024 * 1024 // 5 MB for images and GIFs
                : 25 * 1024 * 1024; // 25 MB for videos

            if ($file->getSize() > $maxSize) {
                return back()->withErrors([
                    'media' => 'File too large! Max size is ' . ($maxSize / 1024 / 1024) . ' MB.'
                ])->withInput();
            }

            // ✅ Generate unique filename
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/banners'), $filename);
            $filePath = 'storage/banners/' . $filename;

            // ✅ Save to database
            Banner::create([
                'title'    => $request->title,
                'subtitle' => $request->subtitle,
                'image'    => $filePath, // keep column name 'image' for backward compatibility
            ]);

            Log::info('Banner created successfully', ['file_path' => $filePath]);

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error storing banner', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong. Please check logs.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        Log::info('Banner update method called', [
            'banner_id'    => $banner->id,
            'request_data' => $request->all()
        ]);

        try {
            // ✅ Validation (GIF now allowed)
            $validated = $request->validate([
                'title'    => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'media'    => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi',
            ]);

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $mimeType = $file->getMimeType();

                // ✅ Determine limit (GIF included)
                $maxSize = str_starts_with($mimeType, 'image/')
                    ? 5 * 1024 * 1024
                    : 25 * 1024 * 1024;

                if ($file->getSize() > $maxSize) {
                    return back()->withErrors([
                        'media' => 'File too large! Max size is ' . ($maxSize / 1024 / 1024) . ' MB.'
                    ])->withInput();
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/banners'), $filename);
                $filePath = 'storage/banners/' . $filename;

                // ✅ Delete old file
                if ($banner->image && file_exists(public_path($banner->image))) {
                    unlink(public_path($banner->image));
                    Log::info('Old media deleted', ['old_file' => $banner->image]);
                }

                $validated['image'] = $filePath;
                Log::info('New media stored successfully', ['new_file' => $validated['image']]);
            } else {
                $validated['image'] = $banner->image;
                Log::info('No new media uploaded, keeping old one', ['existing_file' => $banner->image]);
            }

            $banner->update($validated);

            Log::info('Banner updated successfully', [
                'banner_id' => $banner->id,
                'updated_data' => $validated
            ]);

            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating banner', [
                'banner_id' => $banner->id,
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong during update. Please check logs.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
            Log::info('Banner file deleted', ['file' => $banner->image]);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
