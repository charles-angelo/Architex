@extends('layouts.admin')

@section('title', 'Properties / Edit Property')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">EDIT PROPERTY</h1>

    <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Property Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
            <input type="text" name="name" id="name"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('name', $property->name) }}" required>
            @error('name')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="6"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $property->description) }}</textarea>
            @error('description')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        {{-- Thumbnail Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Thumbnail Upload</p>
            <p class="text-sm text-gray-500 mb-4">Upload a Thumbnail Image (JPG, PNG, WEBP, Max: 5MB)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click below or drag file to upload</span>
                <input type="file" name="property_thumbnail" id="property_thumbnail" class="hidden" accept="image/*">
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Thumbnail</span>
            </label>
            @error('property_thumbnail')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Thumbnail Preview --}}
        <div id="thumb-preview-container" class="{{ $property->property_thumbnail ? '' : 'hidden' }} mt-4">
            <p class="font-semibold mb-2">Thumbnail Preview</p>
            <div id="thumb-preview" class="relative inline-block">
                @if($property->property_thumbnail)
                <img src="{{ asset($property->property_thumbnail) }}" class="w-40 h-28 object-cover rounded shadow" alt="Thumbnail">
                <button type="button" id="remove-thumb"
                    class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition">
                    ✖
                </button>
                @endif
            </div>
        </div>

        {{-- Multiple Images Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center mt-6">
            <p class="font-semibold">Property Gallery</p>
            <p class="text-sm text-gray-500 mb-4">Upload multiple property images (JPG, PNG, WEBP, Max: 5MB each)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click below or drag files to upload</span>
                <input type="file" name="property_images[]" id="property_images" class="hidden" accept="image/*" multiple>
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Images</span>
            </label>
            @error('property_images.*')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- New Images Preview --}}
        <div id="new-images-container" class="flex flex-wrap gap-4 mt-4 hidden"></div>

        {{-- Existing Images --}}
        @if($property->images->count() > 0)
        <div class="mt-6">
            <p class="font-semibold mb-2">Existing Images</p>
            <div class="flex flex-wrap gap-4 justify-start">
                @foreach($property->images as $img)
                <div class="relative inline-block" id="existing-image-{{ $img->id }}">
                    <img src="{{ asset($img->image) }}" class="w-40 h-28 object-cover rounded shadow" alt="Property Image">
                    <button type="button"
                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition"
                        onclick="removeExistingImage({{ $img->id }})">
                        ✖
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Buttons --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.properties.index') }}" class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    // Thumbnail Preview
    const thumbInput = document.getElementById('property_thumbnail');
    const thumbContainer = document.getElementById('thumb-preview-container');
    const thumbPreview = document.getElementById('thumb-preview');

    thumbInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        thumbContainer.classList.remove('hidden');
        thumbPreview.innerHTML = '';
        const reader = new FileReader();
        reader.onload = function(ev) {
            thumbPreview.innerHTML = `
                <img src="${ev.target.result}" class="w-40 h-28 object-cover rounded shadow">
                <button type="button" id="remove-thumb" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition">✖</button>
            `;
            document.getElementById('remove-thumb').onclick = () => {
                thumbInput.value = '';
                thumbPreview.innerHTML = '';
                thumbContainer.classList.add('hidden');
            };
        };
        reader.readAsDataURL(file);
    });

    // Multiple Images Preview
    const multiInput = document.getElementById('property_images');
    const newImagesContainer = document.getElementById('new-images-container');

    multiInput?.addEventListener('change', function(e) {
        newImagesContainer.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const div = document.createElement('div');
                div.classList.add('relative', 'inline-block');
                div.innerHTML = `
                    <img src="${ev.target.result}" class="w-40 h-28 object-cover rounded shadow">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition">✖</button>
                `;
                div.querySelector('button').addEventListener('click', () => div.remove());
                newImagesContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
        newImagesContainer.classList.remove('hidden');
    });

   function removeExistingImage(id) {
    const imgDiv = document.getElementById(`existing-image-${id}`);
    if (imgDiv) imgDiv.remove();

    // 🔒 Append a hidden input inside the same form
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'remove_images[]';
    input.value = id;

    const form = document.querySelector('form[enctype="multipart/form-data"]');
    if (form) form.appendChild(input);
}

</script>
@endpush
@endsection