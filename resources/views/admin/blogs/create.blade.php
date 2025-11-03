@extends('layouts.admin')

@section('title', 'Blogs / Create Blog')

@section('content')
<div class="max-w-screen-2xl mx-auto bg-white p-6 rounded-lg shadow border border-gray-100">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">CREATE BLOG</h1>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Blog Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Blog Category</label>
            <select name="category_id" id="category_id"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                value="{{ old('blog_title') }}" required>
            @error('blog_title')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Blog Date --}}
        <div>
            <label for="blog_date" class="block text-sm font-medium text-gray-700">Blog Date</label>
            <input type="date" name="blog_date" id="blog_date"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('blog_date') }}" required>
            <p id="date-preview" class="mt-1 text-gray-500 text-sm"></p>
            @error('blog_date')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="5"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- 🔄 Blog Image Switch --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Blog Image Type</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="image_mode" value="upload" checked> Upload File
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="image_mode" value="link"> Use Link
                </label>
            </div>
        </div>

        {{-- Blog Image Upload --}}
        <div id="upload-section" class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Blog Image</p>
            <p class="text-sm text-gray-500 mb-4">Upload a Picture or Video (max 20MB)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click button below or drag file to upload</span>
                <input type="file" name="blog_image" id="blog_image" class="hidden" accept="image/*,video/*">
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload File</span>
            </label>
            @error('blog_image')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Blog Image Link --}}
        <div id="link-section" class="hidden">
            <label for="blog_image_link" class="block text-sm font-medium text-gray-700">Image / Video URL</label>
            <input type="url" name="blog_image_link" id="blog_image_link"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                placeholder="https://example.com/image.jpg" value="{{ old('blog_image_link') }}">
        </div>

        {{-- Blog Image Preview --}}
        <div id="preview-container" class="hidden mt-4">
            <p class="font-semibold mb-2">Preview</p>
            <div id="preview" class="relative inline-block"></div>
        </div>

        {{-- 🖼️ Thumbnail Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Thumbnail Image</p>
            <p class="text-sm text-gray-500 mb-4">Upload a smaller thumbnail (max 2MB)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

        {{-- Buttons --}}
        <div class="flex justify-between">
            <a href="{{ route('admin.blogs.index') }}"
                class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Save</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    // 🔄 Toggle upload/link sections
    document.querySelectorAll('input[name="image_mode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('upload-section').classList.toggle('hidden', this.value !== 'upload');
            document.getElementById('link-section').classList.toggle('hidden', this.value !== 'link');
            document.getElementById('preview-container').classList.add('hidden');
        });
    });

    // 📅 Date preview
    const blogDateInput = document.getElementById('blog_date');
    const datePreview = document.getElementById('date-preview');

    function updateDatePreview() {
        if (blogDateInput.value) {
            const d = new Date(blogDateInput.value);
            datePreview.textContent = `Selected Date: ${d.toLocaleDateString()}`;
        } else datePreview.textContent = '';
    }
    blogDateInput.addEventListener('change', updateDatePreview);
    updateDatePreview();

    // 🖼️ File preview
    document.getElementById('blog_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        if (file) {
            previewContainer.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = function(ev) {
                let el;
                if (file.type.startsWith('image/')) {
                    el = document.createElement('img');
                    el.src = ev.target.result;
                    el.className = 'w-40 h-28 object-cover rounded shadow';
                } else {
                    el = document.createElement('video');
                    el.src = ev.target.result;
                    el.controls = true;
                    el.className = 'w-56 h-36 rounded shadow';
                }
                preview.appendChild(el);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection