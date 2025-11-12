@extends('layouts.admin')

@section('title', 'Lots / Edit Lot')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">EDIT LOT</h1>

    <form action="{{ route('admin.lots.update', $lot->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Block --}}
        <div>
            <label for="block_id" class="block text-sm font-medium text-gray-700">Block</label>
            <select name="block_id" id="block_id" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">Select Block</option>
                @foreach($blocks as $block)
                <option value="{{ $block->id }}" {{ old('block_id', $lot->block_id) == $block->id ? 'selected' : '' }}>
                    {{ $block->block_number }}
                </option>
                @endforeach
            </select>
            @error('block_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $lot->category_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Type --}}
        <div>
            <label for="type_id" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type_id" id="type_id" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">Select Type</option>
                @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('type_id', $lot->type_id) == $type->id ? 'selected' : '' }}>
                    {{ $type->type_name }}
                </option>
                @endforeach
            </select>
            @error('type_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Lot Name --}}
        <div>
            <label for="lot_name" class="block text-sm font-medium text-gray-700">Lot Name</label>
            <input type="text" name="lot_name" id="lot_name" value="{{ old('lot_name', $lot->lot_name) }}" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            @error('lot_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Area & Price --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="area" class="block text-sm font-medium text-gray-700">Area (sqm)</label>
                <input
                    type="number"
                    name="area"
                    id="area"
                    step="0.01"
                    min="0"
                    value="{{ old('area', $lot->area) }}"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $lot->price) }}" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                @foreach(['available', 'sold', 'reserved'] as $status)
                <option value="{{ $status }}" {{ old('status', $lot->status) == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 🏷️ Listing Type --}}
        <div>
            <label for="listing_type" class="block text-sm font-medium text-gray-700">Listing Type</label>
            <select name="listing_type" id="listing_type" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="for_sale" {{ old('listing_type', $lot->listing_type) == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                <option value="for_rent" {{ old('listing_type', $lot->listing_type) == 'for_rent' ? 'selected' : '' }}>For Rent</option>
            </select>
            @error('listing_type') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="6" class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $lot->description) }}</textarea>
        </div>

        {{-- Lot Images Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center mt-6">
            <p class="font-semibold">Lot Gallery</p>
            <p class="text-sm text-gray-500 mb-4">Upload multiple lot images (JPG, PNG, WEBP, Max: 2MB each)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click or drag files to upload</span>
                <input type="file" name="images[]" id="lot_images" class="hidden" accept="image/*" multiple>
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Images</span>
            </label>
        </div>

        {{-- Lot Images Preview --}}
        <div id="new-images-container" class="flex flex-wrap gap-4 mt-4 hidden"></div>

        {{-- Existing Lot Images --}}
        @if($lot->images && $lot->images->count() > 0)
        <div class="mt-6">
            <p class="font-semibold mb-2">Existing Images</p>
            <div class="flex flex-wrap gap-4">
                @foreach($lot->images as $img)
                <div class="relative inline-block" id="existing-image-{{ $img->id }}">
                    <img src="{{ asset($img->image) }}" class="w-40 h-28 object-cover rounded shadow">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition" onclick="removeExistingImage({{ $img->id }})">✖</button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Floor Plan Images Upload --}}
        <div class="border-2 border-dashed rounded-lg p-6 text-center mt-6">
            <p class="font-semibold">Floor Plan Gallery</p>
            <p class="text-sm text-gray-500 mb-4">Upload multiple floor plan images (JPG, PNG, WEBP, Max: 2MB each)</p>
            <label class="cursor-pointer inline-flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 014-4h.586a1 1 0 01.707.293l2.414 2.414a1 1 0 001.414 0l2.414-2.414a1 1 0 01.707-.293H17a4 4 0 014 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1z" />
                </svg>
                <span class="text-gray-600">Click or drag files to upload</span>
                <input type="file" name="floor_plan[]" id="floor_plan" class="hidden" accept="image/*" multiple>
                <span class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Upload Floor Plans</span>
            </label>
        </div>

        {{-- Floor Plan Preview --}}
        <div id="floorplan-preview-container" class="flex flex-wrap gap-4 mt-4 hidden"></div>

        {{-- Existing Floor Plan Images --}}
        @if($lot->floor_plan && $lot->floor_plan->count() > 0)
        <div class="mt-6">
            <p class="font-semibold mb-2">Existing Floor Plans</p>
            <div class="flex flex-wrap gap-4">
                @foreach($lot->floor_plan as $fp)
                <div class="relative inline-block" id="existing-floorplan-{{ $fp->id }}">
                    <img src="{{ asset($fp->floor_plan) }}" class="w-40 h-28 object-cover rounded shadow">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition" onclick="removeExistingFloorPlan({{ $fp->id }})">✖</button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Buttons --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.lots.index') }}" class="px-4 py-2 border rounded bg-gray-100 hover:bg-gray-200">Back</a>
            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Update Lot</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

    function handleFileInput(inputElement, previewContainer) {
        previewContainer.innerHTML = '';
        Array.from(inputElement.files).forEach(file => {
            // File size check
            if (file.size > MAX_FILE_SIZE) {
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('text-red-600', 'text-sm', 'mt-1');
                errorDiv.textContent = `File "${file.name}" exceeds the maximum size of 2MB.`;
                previewContainer.appendChild(errorDiv);
                return; // skip preview for this file
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(ev) {
                const div = document.createElement('div');
                div.classList.add('relative', 'inline-block');
                div.innerHTML = `
                    <img src="${ev.target.result}" class="w-40 h-28 object-cover rounded shadow">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transition">✖</button>`;
                div.querySelector('button').addEventListener('click', () => div.remove());
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        if (inputElement.files.length > 0) {
            previewContainer.classList.remove('hidden');
        }
    }

    // Lot Images
    const lotImagesInput = document.getElementById('lot_images');
    const newImagesContainer = document.getElementById('new-images-container');
    lotImagesInput?.addEventListener('change', function() {
        handleFileInput(lotImagesInput, newImagesContainer);
    });

    // Floor Plan Images
    const floorPlanInput = document.getElementById('floor_plan');
    const floorPlanContainer = document.getElementById('floorplan-preview-container');
    floorPlanInput?.addEventListener('change', function() {
        handleFileInput(floorPlanInput, floorPlanContainer);
    });

    // Remove existing images
    function removeExistingImage(id) {
        const imgDiv = document.getElementById(`existing-image-${id}`);
        if (imgDiv) imgDiv.remove();

        const form = document.querySelector('form[action*="lots"]');
        if (!form) return;

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = id;
        form.appendChild(input);
    }

    // Remove existing floor plans
    function removeExistingFloorPlan(id) {
        const div = document.getElementById(`existing-floorplan-${id}`);
        if (div) div.remove();

        const form = document.querySelector('form[action*="lots"]');
        if (!form) return;

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_floorplans[]';
        input.value = id;
        form.appendChild(input);
    }
</script>
@endpush
@endsection