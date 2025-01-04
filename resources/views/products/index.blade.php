<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
            <!-- Heading and Button -->
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Product
                </a>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="products-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                order: [[1, 'asc']],
                columns: [{
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type'
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
                    },
                ],
            });

            // Delete functionality
            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this product?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/products/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
                        },
                        success: function(response) {
                            toastr.success(response.success, "Success");
                            $('#products-table').DataTable().ajax.reload();
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
