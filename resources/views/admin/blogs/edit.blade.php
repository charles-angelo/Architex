@extends('layouts.admin')

@section('title', 'Blogs / Edit Blog')

@section('content')
<div class="max-w-screen-2xl mx-auto bg-white p-6 rounded-lg shadow border border-gray-100">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">EDIT BLOG</h1>

    <form id="editBlogForm" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Blog Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Blog Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Blog Title --}}
        <div>
            <label for="blog_title" class="block text-sm font-medium text-gray-700">Blog Title</label>
            <input type="text" name="blog_title" id="blog_title"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('blog_title', $blog->blog_title) }}" required>
            @error('blog_title')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Blog Date --}}
        <div>
            <label for="blog_date" class="block text-sm font-medium text-gray-700">Blog Date</label>
            <input type="date" name="blog_date" id="blog_date"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('blog_date', $blog->blog_date) }}" required>
            <p id="date-preview" class="mt-1 text-gray-500 text-sm"></p>
            @error('blog_date')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="5"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $blog->description) }}</textarea>
            @error('description')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image Type --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Change Blog Image Type</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="image_mode" value="upload" checked> Upload File
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="image_mode" value="link"> Use Link
                </label>
            </div>
        </div>

        {{-- Upload Section --}}
        <div id="upload-section" class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Change Blog Upload</p>
            <p class="text-sm text-gray-500 mb-4">Upload a Picture or Video (max 20MB)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click to upload</span>
                <input type="file" name="blog_image" id="blog_image" class="hidden" accept="image/*,video/*">
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload File</span>
            </label>
            @error('blog_image')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Link Section --}}
        <div id="link-section" class="hidden">
            <label for="blog_image_link" class="block text-sm font-medium text-gray-700">Image / Video URL</label>
            <input type="url" name="blog_image_link" id="blog_image_link"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                placeholder="https://example.com/image.jpg"
                value="{{ old('blog_image_link', Str::startsWith($blog->blog_image, ['http://', 'https://']) ? $blog->blog_image : '') }}"
                disabled>
        </div>

        {{-- Current Blog Image --}}
        @php
        use Illuminate\Support\Str;
        $isVideo = Str::endsWith($blog->blog_image, ['.mp4', '.mov', '.avi']);
        $isExternal = Str::startsWith($blog->blog_image, ['http://', 'https://']);
        $imageSrc = $isExternal ? $blog->blog_image : asset($blog->blog_image);
        @endphp
        @if ($blog->blog_image)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Blog Upload</label>
            <div class="relative inline-block">
                @if ($isVideo)
                <video src="{{ $imageSrc }}" controls class="w-56 h-36 rounded shadow"></video>
                @else
                <img src="{{ $imageSrc }}" alt="Current Blog Image" class="w-40 h-28 object-cover rounded shadow">
                @endif
            </div>
        </div>
        @endif

        {{-- Preview --}}
        <div id="preview-container" class="hidden mt-4">
            <p class="font-semibold mb-2">Preview</p>
            <div id="preview" class="relative inline-block"></div>
        </div>

        {{-- Thumbnail Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Change Thumbnail Image</p>
            <p class="text-sm text-gray-500 mb-4">Upload a smaller thumbnail (max 5MB)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click to upload thumbnail</span>
                <input type="file" name="thumbnail_image" id="thumbnail_image" class="hidden" accept="image/*">
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Thumbnail</span>
            </label>
            @error('thumbnail_image')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Current Thumbnail --}}
        @if ($blog->thumbnail_image)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Thumbnail</label>
            <img src="{{ asset($blog->thumbnail_image) }}" alt="Thumbnail" class="w-28 h-20 object-cover rounded shadow mb-2">
        </div>
        @endif

        {{-- Thumbnail Preview --}}
        <div id="thumbnail-preview-container" class="hidden mt-4">
            <p class="font-semibold mb-2">Thumbnail Preview</p>
            <div id="thumbnail-preview" class="relative inline-block"></div>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    // Toggle upload/link
    document.querySelectorAll('input[name="image_mode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const uploadSection = document.getElementById('upload-section');
            const linkSection = document.getElementById('link-section');
            const linkInput = document.getElementById('blog_image_link');

            const isLinkMode = this.value === 'link';

            uploadSection.classList.toggle('hidden', isLinkMode);
            linkSection.classList.toggle('hidden', !isLinkMode);

            // ✅ Disable when hidden
            if (isLinkMode) {
                linkInput.removeAttribute('disabled');
            } else {
                linkInput.setAttribute('disabled', 'disabled');
                linkInput.value = '';
            }
        });
    });

    // Blog Date Preview
    const blogDateInput = document.getElementById('blog_date');
    const datePreview = document.getElementById('date-preview');
    blogDateInput.addEventListener('change', () => {
        if (blogDateInput.value) {
            const d = new Date(blogDateInput.value);
            datePreview.textContent = `Selected Date: ${d.toLocaleDateString()}`;
        } else datePreview.textContent = '';
    });

    // Thumbnail preview
    document.getElementById('thumbnail_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const container = document.getElementById('thumbnail-preview-container');
        const preview = document.getElementById('thumbnail-preview');
        preview.innerHTML = '';
        if (file) {
            container.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = ev => {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'w-28 h-20 object-cover rounded shadow';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Blog image link preview
    document.getElementById('blog_image_link').addEventListener('input', function(e) {
        const url = e.target.value.trim();
        const container = document.getElementById('preview-container');
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        if (!url) return container.classList.add('hidden');

        container.classList.remove('hidden');

        if (url.match(/\.(mp4|mov|avi|webm)$/i)) {
            const video = document.createElement('video');
            video.src = url;
            video.controls = true;
            video.className = 'w-80 h-48 rounded shadow';
            preview.appendChild(video);
        } else {
            const img = document.createElement('img');
            img.src = url;
            img.className = 'w-40 h-28 object-cover rounded shadow';
            preview.appendChild(img);
        }
    });
</script>
@endpush
@endsection