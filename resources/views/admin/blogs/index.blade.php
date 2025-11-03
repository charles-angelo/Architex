@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
<!-- Page Title -->
<h1 class="text-2xl font-semibold mb-6">BLOGS</h1>

<!-- Top Bar -->
<div class="flex justify-between items-center mb-6">
    <!-- Create Button -->
    <a href="{{ route('admin.blogs.create') }}"
        class="ml-auto inline-flex items-center gap-2 text-sm bg-gradient-to-r from-green-600 to-emerald-500 text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>

        Create Blog
    </a>
</div>

<!-- Table -->
<div class="overflow-x-auto bg-white border rounded-lg">
    <table class="text-center table-fixed w-full border-collapse" id="blogs-table">
        <thead>
            <tr class="bg-black text-white text-sm font-semibold">
                <th class="px-6 py-3 w-16">ID</th>
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Blog Title</th>
                <th class="px-6 py-3">Description</th>
                <th class="px-6 py-3">Blog Image</th>
                <th class="px-6 py-3">Blog Thumbnail</th>
                <th class="px-6 py-3">Date</th>
                <th class="px-6 py-3 whitespace-nowrap w-40">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blogs as $blog)
            <tr class="border-t">
                <td class="px-6 py-3 text-center">{{ $blog->id }}</td>

                <!-- Category -->
                <td class="px-6 py-3 text-center">
                    {{ $blog->category->category_name ?? '—' }}
                </td>

                <td class="px-6 py-3 text-center">{{ $blog->blog_title }}</td>

                <td class="px-6 py-3 text-center break-words max-w-xs">
                    {!! Str::limit($blog->description, 150, '...') !!}
                </td>

                <!-- Blog Image -->
                <td class="px-6 py-3 text-center">
                    @php
                    $blogImage = null;

                    if ($blog->blog_image) {
                    // ✅ If it's a YouTube link
                    if (Str::contains($blog->blog_image, 'youtube.com/watch')) {
                    preg_match('/v=([^&]+)/', $blog->blog_image, $matches);
                    $videoId = $matches[1] ?? null;
                    if ($videoId) {
                    $blogImage = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                    }
                    }
                    // ✅ If it's an external image URL
                    elseif (Str::startsWith($blog->blog_image, ['http://', 'https://'])) {
                    $blogImage = $blog->blog_image;
                    }
                    // ✅ Otherwise, it's a local upload
                    else {
                    $blogImage = asset($blog->blog_image);
                    }
                    }
                    @endphp

                    @if($blogImage)
                    <div class="flex justify-center items-center">
                        <img src="{{ $blogImage }}" class="h-12 w-20 object-cover rounded shadow-sm border border-gray-200" alt="Blog">
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </td>



                <td class="px-6 py-3 text-center">
                    @if($blog->thumbnail_image)
                    <div class="flex justify-center items-center">
                        <img src="{{ asset($blog->thumbnail_image) }}" class="h-12 w-20 object-cover rounded shadow-sm" alt="Blog">
                    </div>
                    @else
                    <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </td>

                <!-- Date -->
                <td class="px-6 py-3 text-center">
                    {{ \Carbon\Carbon::parse($blog->blog_date)->format('M d, Y') }}
                </td>

                <!-- Actions -->
                <td class="px-6 py-3">
                    <div class="flex justify-center items-center gap-2">
                        <!-- Edit -->
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                            class="px-3 py-1 rounded text-white bg-blue-500 hover:bg-blue-600 transition">
                            Edit
                        </a>

                        <!-- Delete -->
                        <button type="button"
                            onclick="confirmDelete({{ $blog->id }})"
                            class="px-3 py-1 rounded text-white bg-red-500 hover:bg-red-600 transition">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-4 text-gray-500">No blogs found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $blogs->links() }}
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#blogs-table').DataTable({
            ordering: false,
            paging: false,
            info: false
        });
    });

    // SweetAlert delete confirmation
    function confirmDelete(blogId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete this blog? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = "/admin/blogs/" + blogId;

                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";

                let method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

{{-- SweetAlert Success after CRUD --}}
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