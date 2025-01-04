<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
            <!-- Heading and Button -->
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Category
                </a>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="categories-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                order: [[0, 'asc']],
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            // Delete category functionality
            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this category?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/categories/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
                        },
                        success: function(response) {
                            toastr.success(response.success, "Success");
                            $('#categories-table').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            toastr.error("An error occurred. Please try again.", "Error");
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
