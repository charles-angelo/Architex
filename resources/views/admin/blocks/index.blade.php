@extends('layouts.admin')

@section('title', 'Blocks')

@section('content')
<!-- Page Title -->
<h1 class="text-2xl font-semibold mb-6">BLOCKS</h1>

<!-- Top Bar -->
<div class="flex justify-between items-center mb-6">
    <!-- Create Button -->
    <button type="button"
        onclick="openCreateModal()"
        class="ml-auto inline-flex items-center gap-2 text-sm bg-gradient-to-r from-green-600 to-emerald-500 text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>

        Create Block
    </button>
</div>

<!-- Table -->
<div class="overflow-x-auto bg-white border rounded-lg">
    <table class="table-fixed w-full border-collapse" id="blocks-table">
        <thead>
            <tr class="bg-black text-white text-sm font-semibold">
                <th class="px-10 py-3 rounded-tl-lg text-center w-1/6">ID</th>
                <th class="px-10 py-3 w-1/3">Property</th>
                <th class="px-10 py-3 w-1/3">Block Number</th>
                <th class="text-center w-[20%]">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blocks as $block)
            <tr class="border-t" id="row-{{ $block->id }}">
                <td class="px-10 py-3 text-center">{{ $block->id }}</td>
                <td class="px-10 py-3 text-center">{{ $block->property->name ?? 'N/A' }}</td>
                <td class="px-10 py-3 text-center">{{ $block->block_number }}</td>
                <td class="px-6 py-3">
                    <div class="flex justify-center items-center gap-2">
                        <button type="button"
                            onclick="openEditModal({{ $block->id }}, '{{ $block->property_id }}', '{{ $block->block_number }}')"
                            class="px-3 py-1 rounded text-white"
                            style="background-color:#3B82F6;">
                            Edit
                        </button>
                        <button type="button"
                            onclick="deleteBlock({{ $block->id }})"
                            class="px-3 py-1 rounded text-white"
                            style="background-color:#EF4444;">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">No blocks found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create Block Modal -->
<div id="create-modal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-lg p-8 w-[600px] max-w-full">
        <h2 class="text-lg font-semibold mb-6">CREATE BLOCK</h2>

        <form id="create-form" method="POST" action="{{ route('admin.blocks.store') }}">
            @csrf
            <div class="mb-4">
                <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                <select name="property_id" id="property_id" required>
                    <option value="">-- Select Property --</option>
                    @foreach($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                    @endforeach
                </select>

            </div>

            <div class="mb-4">
                <label for="block_number" class="block text-sm font-medium text-gray-700">Block Number</label>
                <input type="text" name="block_number" id="block_number"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCreateModal()"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Block Modal -->
<div id="edit-modal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-lg p-8 w-[600px] max-w-full">
        <h2 class="text-lg font-semibold mb-6">EDIT BLOCK</h2>

        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_block_id">

            <div class="mb-4">
                <label for="edit_property_id" class="block text-sm font-medium text-gray-700">Property</label>
                <select name="property_id" id="edit_property_id" required>
                    <option value="">-- Select Property --</option>
                    @foreach($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="edit_block_number" class="block text-sm font-medium text-gray-700">Block Number</label>
                <input type="text" name="block_number" id="edit_block_number"
                    class="mt-1 block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table;

    function deleteBlock(blockId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/blocks/" + blockId,
                    method: "POST",
                    data: {
                        _method: "DELETE"
                    },
                    success: function() {
                        table.row($('#row-' + blockId)).remove().draw();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'The block has been deleted.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                });
            }
        });
    }

    function openCreateModal() {
        document.getElementById('create-modal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('create-modal').classList.add('hidden');
        document.getElementById('create-form').reset();
    }

    $(document).ready(function() {
        table = $('#blocks-table').DataTable({
            ordering: false
        });

        $('#create-form').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.blocks.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    table.row.add([
                        `<div class="text-center">${response.id}</div>`,
                        `<div class="text-center">${response.property_name}</div>`,
                        `<div class="text-center">${response.block_number}</div>`,
                        `<div class="flex justify-center items-center gap-2">
                        <button type="button"
                            onclick="deleteBlock(${response.id})"
                            class="px-3 py-1 rounded text-white"
                            style="background-color:#EF4444;">
                            Delete
                        </button>
                    </div>`
                    ]).draw(false);

                    closeCreateModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Block Created!',
                        text: 'Your block has been successfully saved.',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong.',
                        confirmButtonColor: '#EF4444'
                    });
                }
            });
        });
    });

    function openEditModal(id, propertyId, blockNumber) {
        $('#edit_block_id').val(id);
        $('#edit_property_id').val(propertyId);
        $('#edit_block_number').val(blockNumber);
        $('#edit-modal').removeClass('hidden');
    }

    function closeEditModal() {
        $('#edit-modal').addClass('hidden');
        $('#edit-form')[0].reset();
    }

    $('#edit-form').submit(function(e) {
        e.preventDefault();

        let blockId = $('#edit_block_id').val();
        let formData = $(this).serialize();

        $.ajax({
            url: `/admin/blocks/${blockId}`,
            method: 'POST',
            data: formData + '&_method=PUT',
            success: function(response) {
                // Update table row visually
                let row = $(`#row-${blockId}`);
                row.find('td:nth-child(2)').text(response.property_name);
                row.find('td:nth-child(3)').text(response.block_number);

                closeEditModal();

                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'The block has been updated successfully.',
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong.',
                    confirmButtonColor: '#EF4444',
                });
            },
        });
    });
</script>
@endpush