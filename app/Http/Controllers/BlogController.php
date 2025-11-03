<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs.
     */
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('category_name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        Log::info('Blog store method called', ['request_data' => $request->all()]);

        try {
            $request->validate([
                'category_id' => 'required|exists:blog_categories,id',
                'blog_title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'blog_date' => 'required|date',
                'blog_image' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi|max:20000',
                'blog_image_link' => 'nullable|string',
                'thumbnail_image' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5000',
            ]);

            // ✅ Handle main blog image
            $blogImagePath = null;

            if ($request->hasFile('blog_image')) {
                $blogImage = $request->file('blog_image');
                $filename = time() . '_' . uniqid() . '.' . $blogImage->getClientOriginalExtension();
                $blogImage->move(public_path('storage/blogs'), $filename);
                $blogImagePath = 'storage/blogs/' . $filename;
            } elseif (!empty($request->blog_image_link)) {
                $blogImagePath = $request->blog_image_link;
            } else {
                throw new \Exception('Please provide either an image file or a link.');
            }

            // ✅ Handle thumbnail
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail_image')) {
                $thumb = $request->file('thumbnail_image');
                $thumbFilename = time() . '_thumb_' . uniqid() . '.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('storage/blog_thumbnails'), $thumbFilename);
                $thumbnailPath = 'storage/blog_thumbnails/' . $thumbFilename;
            }

            // ✅ Create blog record
            Blog::create([
                'category_id' => $request->category_id,
                'blog_title' => $request->blog_title,
                'description' => $request->description,
                'blog_image' => $blogImagePath,
                'thumbnail_image' => $thumbnailPath,
                'blog_date' => $request->blog_date,
            ]);

            return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing blog', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::orderBy('category_name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        Log::info('Blog update method called', ['blog_id' => $blog->id, 'request_data' => $request->all()]);

        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:blog_categories,id',
                'blog_title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'blog_date' => 'required|date',
                'blog_image' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi|max:20000',
                'blog_image_link' => 'nullable|string',
                'thumbnail_image' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5000',
            ]);

            $blogImagePath = $blog->blog_image; // keep old by default

            // ✅ If file uploaded, replace old
            if ($request->hasFile('blog_image')) {
                if ($blog->blog_image && file_exists(public_path($blog->blog_image))) {
                    unlink(public_path($blog->blog_image));
                }

                $newImage = $request->file('blog_image');
                $filename = time() . '_' . uniqid() . '.' . $newImage->getClientOriginalExtension();
                $newImage->move(public_path('storage/blogs'), $filename);
                $blogImagePath = 'storage/blogs/' . $filename;
            }
            // ✅ If link provided (and no file uploaded), replace with new link
            elseif (!empty($request->blog_image_link)) {
                // If previous image is local file, delete it
                if ($blog->blog_image && file_exists(public_path($blog->blog_image))) {
                    unlink(public_path($blog->blog_image));
                }
                $blogImagePath = $request->blog_image_link;
            }

            // ✅ Handle thumbnail replacement
            $thumbnailPath = $blog->thumbnail_image;
            if ($request->hasFile('thumbnail_image')) {
                if ($blog->thumbnail_image && file_exists(public_path($blog->thumbnail_image))) {
                    unlink(public_path($blog->thumbnail_image));
                }

                $thumb = $request->file('thumbnail_image');
                $thumbName = time() . '_thumb_' . uniqid() . '.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('storage/blog_thumbnails'), $thumbName);
                $thumbnailPath = 'storage/blog_thumbnails/' . $thumbName;
            }

            // ✅ Update blog record
            $blog->update([
                'category_id' => $request->category_id,
                'blog_title' => $request->blog_title,
                'description' => $request->description,
                'blog_date' => $request->blog_date,
                'blog_image' => $blogImagePath,
                'thumbnail_image' => $thumbnailPath,
            ]);

            return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating blog', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified blog from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->blog_image && file_exists(public_path($blog->blog_image))) {
            unlink(public_path($blog->blog_image));
        }

        if ($blog->thumbnail_image && file_exists(public_path($blog->thumbnail_image))) {
            unlink(public_path($blog->thumbnail_image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
