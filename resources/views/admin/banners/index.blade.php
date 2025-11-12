@extends('layouts.admin')

@section('title', 'Homepage Banner')

@section('content')
<!-- Page Title -->
<h1 class="text-2xl font-semibold mb-6">HOMEPAGE BANNER</h1>

<!-- Top Bar -->
<div class="flex justify-between items-center mb-6">
    <!-- Create Button -->
    <a href="{{ route('admin.banners.create') }}"
        class="ml-auto inline-flex items-center gap-2 text-sm bg-gradient-to-r from-green-600 to-emerald-500 text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Create Banner
    </a>
</div>


<!-- Table -->
<div class="overflow-x-auto bg-white border rounded-lg">
    <table class="table-fixed w-full border-collapse" id="users-table">
        <thead>
            <tr class="bg-black text-white text-sm font-semibold">
                <th class="px-10 py-3 rounded-tl-lg text-center w-16">ID</th>
                <th class="px-10 py-3 w-1/4">Title</th>
                <th class="px-10 py-3 w-1/4">Subtitle</th>
                <th class="px-10 py-3 w-1/4 text-center">Image</th>
                <th class="px-10 py-3 rounded-tr-lg text-center whitespace-nowrap w-40">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
            <tr class="border-t">
                <td class="px-10 py-3 text-center">{{ $banner->id }}</td>
                <td class="px-10 py-3 text-center">{{ $banner->title }}</td>
                <td class="px-10 py-3 text-center">{!! $banner->subtitle !!}</td>
                <td class="px-10 py-3 text-center">
                    <div class="flex justify-center items-center">
                        @php
                        $extension = pathinfo($banner->image, PATHINFO_EXTENSION);
                        $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                        @endphp

                        @if ($isVideo)
                        <video autoplay muted loop class="w-20 h-12 object-cover rounded shadow">
                            <source src="{{ asset($banner->image) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        @else
                        <img src="{{ asset($banner->image) }}" class="w-20 h-12 object-cover rounded shadow" alt="Banner">
                        @endif
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="flex justify-center items-center gap-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                            class="px-3 py-1 rounded text-white" style="background-color:#3B82F6;">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}"
                            method="POST" class="inline delete-form">
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
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            ordering: false
        });

        // ✅ SweetAlert Delete
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: "Are you sure?",
                text: "This banner will be permanently deleted.",
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

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush