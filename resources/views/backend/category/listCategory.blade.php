@extends('backend.layout')
@section('backend_contains')
    <section>
        <div class="container">

            <div class="heading d-flex justify-content-between align-items-center">
                <span>
                    {{ request()->path() }}
                </span>
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary">create category</a>
            </div>


            <div class="table-responsive">


                <table class="table mt-3 table-striped-columns text-center">
                    <tr>
                        <th>#</th>
                        <th>Categoty Name</th>
                        <th>image</th>
                        <th>status</th>
                        <th>action</th>
                    </tr>

                    <tbody class="data-container">
                        @forelse($categories as $key => $category)
                            <tr data-id="{{ $category->id }}"> <!-- Add data-id to the row for easy access -->
                                <td style="vertical-align: middle;">{{ ++$key }}</td>
                                <td style="vertical-align: middle;">{{ $category->category_name }}</td>
                                <td>
                                    <img style="height: 60px; "
                                        src="{{ $category->category_img ? $category->category_img : asset('assets/images/category_image.png') }}"
                                        alt="Category Image">
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="#" class="status_btn" data-id="{{ $category->id }}">
                                        <iconify-icon class=" {{ $category->status == 0 ? 'text-danger' : '' }} "
                                            icon="{{ $category->status == 0 ? 'ri:eye-off-line' : 'solar:eye-broken' }}"
                                            width="24" height="24"></iconify-icon>
                                    </a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="" id="editCategory" class="me-3" data-edit-id="{{ $category->id }}"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span><iconify-icon icon="mingcute:pen-line" width="24"
                                                height="24"></iconify-icon></span>
                                    </a>
                                    <a href="" class="deleteCategory" deleteId="{{ $category->id }}">
                                        <span><iconify-icon icon="proicons:delete" width="24"
                                                height="24"></iconify-icon></span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <b class="text-danger">No data found!</b>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>




                </table>
            </div>


        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" enctype="multipart/form-data">
                            @csrf

                            <input id="edit_category_name" type="text" value="" class="form-control  my-3"
                                name="category_name">

                            <label for="parent_name">select a parent </label>
                            <label for="parent_name">Select a parent</label>
                            <select id="" name="parent_name" class="form-control">
                                <option selected disabled></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>


                            <div class="img_placegolder d-flex justify-content-center my-3">
                                <label for="category_img" style="cursor: pointer;">
                                    <img id="edit_category_img" style="height: 200px;"
                                        src="{{ asset('assets/images/category_image.png') }}" alt="">
                                </label>
                                <input type="file" accept=".png, .jpg, .gif, .jpeg, .webp" hidden id="category_img"
                                    name="category_img">
                            </div>

                            <button class="btn btn-primary w-100 mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('backend_css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
@endpush


@push('backend_js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            // Initialize Select2 when the modal is shown
            $('#exampleModal').on('shown.bs.modal', function() {
                $('#parent_name').select2({
                    placeholder: "Select a parent category",
                    allowClear: true,
                });
            });
        });
    </script>



    {{-- CATEGORY SATATUS --}}
    <script>
        $(function() {
            $('.status_btn').on('click', function(e) {
                e.preventDefault();
                let statusId = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('admin.category.status') }}',
                    data: {
                        id: statusId
                    },
                    success: function(response) {
                        // Assuming the response contains the updated status
                        const {
                            status
                        } = response;

                        // Update the icon based on the new status
                        const icon = status == 0 ? 'ri:eye-off-line' : 'solar:eye-broken';
                        // Find the corresponding status button and update the icon
                        $(`.status_btn[data-id="${statusId}"]`).html(
                            `<iconify-icon class="${status == 0 ? 'text-danger' : ''}" icon="${icon}" width="24" height="24"></iconify-icon>`
                        );


                        // ALERT FOR STATUS ACTIVE/DECLINED...
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });


                        if (response.status) {
                            Toast.fire({
                                icon: "success",
                                title: "category activate"
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "category declined!"
                            });
                        }


                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status:', error);
                    }
                });
            });
        });
    </script>



    <script>
        // CATEGORY DELETE 
        $(function() {
            $('.deleteCategory').on('click', function(e) {
                e.preventDefault();
                let delete_id = $(this).attr('deleteId');
                let tr = $(this).closest('tr');

                // First confirmation dialog
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Second confirmation dialog
                        Swal.fire({
                            title: "Confirm Deletion",
                            text: "Are you really sure you want to delete this category?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Make the AJAX request to delete the category
                                $.ajax({
                                    type: 'GET',
                                    url: "{{ route('admin.category.delete', '') }}/" +
                                        delete_id,
                                    data: {
                                        'id': delete_id
                                    },
                                    success: function(response) {
                                        // Remove the row from the DOM
                                        tr.remove();
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your category has been deleted.",
                                            icon: "success"
                                        });
                                    },
                                    error: function(xhr) {
                                        console.log(xhr);
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });




        //EDIT CATEGORY 
        $(document).on('click', '#editCategory', function(e) {
            e.preventDefault();
            let edit_id = $(this).attr('data-edit-id');

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.category.edit', '') }}/" + edit_id,
                data: {
                    'id': edit_id
                },
                success: function(response) {
                    $('#edit_category_name').val(response.category_name);
                    // Check if the image URL is valid
                    if (response.category_img && response.category_img !== '') {
                        $('#edit_category_img').attr('src', response.category_img);
                    } else {
                        // Set a default image if the category image is not found
                        $('#edit_category_img').attr('src',
                            '{{ asset('assets/images/category_image.png') }}');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching category data:', xhr);
                }
            });

        });
    </script>
@endpush
