@extends('layouts.admin')

@section('title', 'Lots')

@section('content')
<!-- Page Title -->
<h1 class="text-2xl font-semibold mb-6">LOTS MANAGEMENT</h1>

<!-- Top Bar -->
<div class="flex justify-between items-center mb-6">
    <!-- Create Button -->
    <a href="{{ route('admin.lots.create') }}"
        class="ml-auto inline-flex items-center gap-2 text-sm bg-gradient-to-r from-green-600 to-emerald-500 text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>

        Create Lot
    </a>
</div>

<!-- Table -->
<div class="overflow-x-auto bg-white border rounded-lg">
    <table class="table-fixed w-full border-collapse" id="lots-table">
        <thead>
            <tr class="bg-black text-white text-sm font-semibold">
                <th class="px-6 py-3 text-center w-16">ID</th>
                <th class="px-6 py-3 w-1/5 text-center">Lot Name</th>
                <th class="px-6 py-3 w-1/5 text-center">Block</th>
                <th class="px-6 py-3 w-1/5 text-center">Category</th>
                <th class="px-6 py-3 w-1/5 text-center">Type</th>
                <th class="px-6 py-3 w-1/5 text-center">Area (sqm)</th>
                <th class="px-6 py-3 w-1/5 text-center">Price (₱)</th>
                <th class="px-6 py-3 w-1/5 text-center">Images</th>
                <th class="px-6 py-3 w-1/5 text-center">Floor Plans</th>
                <th class="px-6 py-3 w-1/5 text-center">Status</th>
                <th class="px-6 py-3 w-1/5 text-center">Type</th>
                <th class="px-6 py-3 rounded-tr-lg text-center whitespace-nowrap w-40">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lots as $lot)
            <tr class="border-t text-center">
                <td class="px-6 py-3">{{ $lot->id }}</td>
                <td class="px-6 py-3 font-semibold">{{ $lot->lot_name }}</td>
                <td class="px-6 py-3">{{ $lot->block?->block_number ?? 'N/A' }}</td>
                <td class="px-6 py-3">{{ $lot->category?->category_name ?? 'N/A' }}</td>
                <td class="px-6 py-3">{{ $lot->type?->type_name ?? 'N/A' }}</td>
                <td class="px-6 py-3">{{ number_format($lot->area, 2) }}</td>
                <td class="px-6 py-3">₱{{ number_format($lot->price, 2) }}</td>

                <!-- 🖼️ Lot Images Column -->
                <td class="px-6 py-3">
                    @if($lot->images && $lot->images->count() > 0)
                    <div class="flex justify-center items-center gap-1">
                        @foreach($lot->images->take(1) as $image)
                        <img src="{{ asset($image->image) }}"
                            alt="Lot Image"
                            class="w-10 h-10 object-cover rounded-md border">
                        @endforeach
                        @if($lot->images->count() > 1)
                        <span class="text-xs text-gray-500">+{{ $lot->images->count() - 1 }}</span>
                        @endif
                    </div>
                    @else
                    <span class="text-gray-400 text-xs italic">No images</span>
                    @endif
                </td>

                <!-- 🖼️ Floor Plan Column -->
                <td class="px-6 py-3">
                    @if($lot->floor_plan && $lot->floor_plan->count() > 0)
                    <div class="flex justify-center items-center gap-1">
                        @foreach($lot->floor_plan->take(1) as $fp)
                        <img src="{{ asset($fp->floor_plan) }}"
                            alt="Floor Plan"
                            class="w-10 h-10 object-cover rounded-md border">
                        @endforeach
                        @if($lot->floor_plan->count() > 1)
                        <span class="text-xs text-gray-500">+{{ $lot->floor_plan->count() - 1 }}</span>
                        @endif
                    </div>
                    @else
                    <span class="text-gray-400 text-xs italic">No floor plan</span>
                    @endif
                </td>


                <!-- 🟢 Status Column -->
                <td class="px-6 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
            @if($lot->status == 'available') bg-green-100 text-green-800
            @elseif($lot->status == 'sold') bg-red-100 text-red-800
            @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($lot->status) }}
                    </span>
                </td>

                <!-- 🟣 Listing Type Column -->
                <td class="px-6 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
        @if($lot->listing_type == 'for_sale') bg-blue-100 text-blue-800
        @elseif($lot->listing_type == 'for_rent') bg-purple-100 text-purple-800
        @endif">
                        @if($lot->listing_type == 'for_sale')
                        FOR SALE
                        @elseif($lot->listing_type == 'for_rent')
                        FOR RENT
                        @else
                        N/A
                        @endif
                    </span>
                </td>



                <!-- ⚙️ Actions -->
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="flex justify-center items-center gap-2">
                        <a href="{{ route('admin.lots.edit', $lot->id) }}"
                            class="px-3 py-1 rounded text-white" style="background-color:#3B82F6;">
                            Edit
                        </a>

                        <form action="{{ route('admin.lots.destroy', $lot->id) }}" method="POST"
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="delete-btn px-3 py-1 rounded text-white"
                                style="background-color:#EF4444;">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="9" class="py-6 text-center text-gray-500">No lots found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $lots->links() }}
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#lots-table').DataTable({
            ordering: false
        });

        // ✅ SweetAlert Delete
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: "Are you sure?",
                text: "This lot will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@if(session('Success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('Success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush