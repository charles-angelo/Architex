@extends('layouts.admin')

@section('title', 'Homepage Banner / Edit Banner')

@section('content')
<div class="max-w-1xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">EDIT BANNER</h1>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('title', $banner->title) }}" required>
            @error('title')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Subtitle --}}
        <div>
            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
            <textarea name="subtitle" id="subtitle" rows="5"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('subtitle', $banner->subtitle) }}</textarea>
            @error('subtitle')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- File Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Image / Video Upload</p>
            <p class="text-sm text-gray-500 mb-4">
                Upload a new file to replace the current one.<br>
                Max of 2MB (image) or 25MB (video)
            </p>

            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click below or drag file to upload</span>

                {{-- ✅ Changed to media for both image/video --}}
                <input type="file" name="media" id="media" class="hidden" accept="image/*,video/*">

                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload File</span>
            </label>

            {{-- 🖼 Current Media --}}
            @if ($banner->image)
            @php
            $ext = strtolower(pathinfo($banner->image, PATHINFO_EXTENSION));
            $isVideo = in_array($ext, ['mp4', 'mov', 'avi']);
            @endphp

            <div id="current-media" class="mt-4 text-center">
                <p class="text-sm font-medium mb-2">Current File:</p>
                <div class="flex justify-center">
                    @if ($isVideo)
                    <video controls class="w-56 h-36 rounded shadow">
                        <source src="{{ asset($banner->image) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @else
                    <img src="{{ asset($banner->image) }}" class="w-40 h-28 object-cover rounded shadow">
                    @endif
                </div>
            </div>
            @endif

            {{-- 🔄 New Media Preview --}}
            <div id="new-media-container" class="hidden mt-4 text-center">
                <p class="text-sm font-medium mb-2">New File Preview:</p>
                <div id="preview" class="relative inline-block"></div>
            </div>

            @error('media')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.banners.index') }}"
                class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit"
                class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>

{{-- CKEditor & Preview Script --}}
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // ✅ CKEditor
    ClassicEditor.create(document.querySelector('#subtitle')).catch(error => console.error(error));

    // ✅ File preview (image or video)
    document.getElementById('media').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('new-media-container');
        const preview = document.getElementById('preview');
        const currentMedia = document.getElementById('current-media');
        preview.innerHTML = ""; // clear previous preview

        if (file) {
            previewContainer.classList.remove('hidden');
            if (currentMedia) currentMedia.classList.add('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                let element;

                if (file.type.startsWith("image/")) {
                    element = document.createElement("img");
                    element.src = e.target.result;
                    element.className = "w-40 h-28 object-cover rounded shadow";
                } else if (file.type.startsWith("video/")) {
                    element = document.createElement("video");
                    element.src = e.target.result;
                    element.controls = true;
                    element.className = "w-56 h-36 rounded shadow";
                }

                preview.appendChild(element);

                // 🗑 Remove Button
                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "✖";
                removeBtn.className =
                    "absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition";
                removeBtn.onclick = function() {
                    document.getElementById('media').value = "";
                    preview.innerHTML = "";
                    previewContainer.classList.add('hidden');
                    if (currentMedia) currentMedia.classList.remove('hidden');
                };
                preview.appendChild(removeBtn);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection