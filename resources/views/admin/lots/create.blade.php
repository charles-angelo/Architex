@extends('layouts.admin')

@section('title', 'Lots / Create Lot')

@section('content')
<div class="max-w-screen-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">CREATE LOT</h1>

    <form action="{{ route('admin.lots.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Lot Name --}}
        <div>
            <label for="lot_name" class="block text-sm font-medium text-gray-700">
                Lot Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="lot_name" id="lot_name"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                value="{{ old('lot_name') }}" required>
            @error('lot_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Block --}}
        <div>
            <label for="block_id" class="block text-sm font-medium text-gray-700">
                Block <span class="text-red-500">*</span>
            </label>
            <select name="block_id" id="block_id"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select Block</option>
                @foreach ($blocks as $block)
                <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>
                    {{ $block->block_number }}
                </option>
                @endforeach
            </select>
            @error('block_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">
                Category <span class="text-red-500">*</span>
            </label>
            <select name="category_id" id="category_id"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type_id" class="block text-sm font-medium text-gray-700">
                Type <span class="text-red-500">*</span>
            </label>
            <select name="type_id" id="type_id"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select Type</option>
                @foreach ($types as $type)
                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->type_name }}
                </option>
                @endforeach
            </select>
            @error('type_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Area & Price --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="area" class="block text-sm font-medium text-gray-700">Area (sqm)</label>
                <input type="number" name="area" id="area" step="0.01"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    value="{{ old('area') }}" required>
                @error('area') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price (₱)</label>
                <input type="number" name="price" id="price" step="0.01"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    value="{{ old('price') }}" required>
                @error('price') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select Status</option>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
            </select>
            @error('status') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Listing Type --}}
        <div>
            <label for="listing_type" class="block text-sm font-medium text-gray-700">
                Listing Type <span class="text-red-500">*</span>
            </label>
            <select name="listing_type" id="listing_type"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select Listing Type</option>
                <option value="for_sale" {{ old('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                <option value="for_rent" {{ old('listing_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
            </select>
            @error('listing_type') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>



        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="5"
                class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Lot Images --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center">
            <p class="font-semibold">Lot Images</p>
            <p class="text-sm text-gray-500 mb-4">Upload one or more images (Max 2MB each)</p>

            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click or drag to upload</span>
                <input type="file" name="images[]" id="images" class="hidden" accept="image/*" multiple>
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Images</span>
            </label>
            @error('images.*')
            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lot Images Preview --}}
        <div id="preview-container" class="hidden">
            <p class="font-semibold mb-2">Preview</p>
            <div id="preview" class="flex flex-wrap gap-4"></div>
        </div>

        {{-- Floor Plan Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center mt-4">
            <p class="font-semibold">Floor Plans</p>
            <p class="text-sm text-gray-500 mb-4">Upload one or more floor plans (JPG, PNG, WEBP, PDF; Max 2MB each)</p>

            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click or drag to upload</span>
                <input type="file" name="floor_plan[]" id="floor_plan" class="hidden" accept="image/*,.pdf" multiple>
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Floor Plans</span>
            </label>
            @error('floor_plan.*')
            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- Floor Plan Preview --}}
        <div id="floor-preview-container" class="hidden mt-2">
            <p class="font-semibold mb-2">Floor Plan Preview</p>
            <div id="floor-preview" class="flex flex-wrap gap-4"></div>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.lots.index') }}" class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Save</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

    // Lot Images Preview
    document.getElementById('images').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview');
        preview.innerHTML = "";

        if (files.length > 0) {
            previewContainer.classList.remove('hidden');
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "relative";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "w-32 h-24 object-cover rounded shadow";

                    const removeBtn = document.createElement("button");
                    removeBtn.innerHTML = "✖";
                    removeBtn.className =
                        "absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition";
                    removeBtn.onclick = () => wrapper.remove();

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    // Floor Plan Preview
    document.getElementById('floor_plan').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('floor-preview-container');
        const preview = document.getElementById('floor-preview');
        preview.innerHTML = "";

        if (files.length > 0) {
            previewContainer.classList.remove('hidden');
            Array.from(files).forEach(file => {
                const wrapper = document.createElement("div");
                wrapper.className = "relative w-32 h-24 flex items-center justify-center border rounded bg-gray-100 text-xs text-gray-700 overflow-hidden";
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.className = "w-full h-full object-cover";
                        wrapper.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    wrapper.textContent = file.name;
                }

                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "✖";
                removeBtn.className =
                    "absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition";
                removeBtn.onclick = () => wrapper.remove();

                wrapper.appendChild(removeBtn);
                preview.appendChild(wrapper);
            });
        } else {
            previewContainer.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection