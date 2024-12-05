@extends('backend.layout')
@section('backend_contains')
    @push('backend_css')
        <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    @endpush

    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="d-flex justify-content-between mb-4 ">
                        <h4>Role's</h4>
                        <div class="div">
                            <a href="" data-bs-toggle="modal" data-bs-target="#role" class="btn btn-primary">Add a new
                                role</a>
                        </div>
                    </div>

                    <div class=" table-responsive">
                        <table id="users-table" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th width="20%">Permissions</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="role" tabindex="-1" aria-labelledby="roleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="roleLabel">Add a new role </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.role.store.role') }}" method="post">
                        @csrf
                        <input name="role_name" type="text" placeholder="role name" class="form-control role_name">
                        <button class="btn btn-primary w-100 mt-3">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    @push('backend_js')
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- for table --}}
        <script>
            $(document).ready(function() {
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.role.get') }}', // Adjust the route as needed
                    columns: [{
                            data: null, // Use null for custom rendering
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; // Sequential number
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'permissions', // Assuming this contains the permissions data
                            render: function(data, type, row) {
                                // Check if permissions data is empty
                                if (data && data.trim() !== '') {
                                    let allData = data.split(', ').map(function(permission) {
                                        return `<span class="badge m-1 bg-primary badge-primary">${permission}</span>`;
                                    }).join(' '); // Join badges with a space

                                    return `<div style="width: 500px; display: flex; flex-wrap: wrap;">${allData}</div>`;
                                }
                                return '<div> <b>No permission available !  </b></div>'; // Return message if no permissions
                            }
                        },
                        {
                            data: null, // Use null for custom rendering
                            render: function(data, type, row) {
                                return `
                                    <div class="d-flex justify-content-between w-50">
                                        <a href="" data-id="${row.id}"> <span><iconify-icon icon="mingcute:pen-line" width="20" height="20"></iconify-icon></span> </a>
                                        <a class="delete" href="" data-id="${row.id}"> <span><iconify-icon icon="ic:outline-delete" width="20" height="20"></iconify-icon></span> </a>
                                        <a href="" data-id="${row.id}"> <span><iconify-icon icon="mdi:key-outline" width="20" height="20"></iconify-icon></span> </a>
                                    </div>
                                `;
                            }
                        },
                    ],
                    order: [
                        [1, 'asc']
                    ], // Sort by the second column (name) in ascending order, adjust if necessary
                });
            });
        </script>
        {{-- for table end --}}



        {{-- DELETE TR --}}
        <script>
            $(document).ready(function() {
                $('#users-table').on('click', '.delete', function(e) {
                    e.preventDefault();
                    const roleId = $(this).attr('data-id'); // Get the dynamic ID from the clicked element

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('admin.role.delete.role', '') }}/" +
                        roleId, // Use the dynamic ID here
                        data: {
                            id: roleId
                        },
                        success: function(data) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: data.message
                            });
                            $('#users-table').DataTable().ajax.reload();

                        },
                        error: function(xhr) {
                            alert('Error deleting role: ' + xhr
                            .responseText); // Handle errors if needed
                        }
                    });
                });
            });
        </script>
        {{-- DELETE TR END --}}
    @endpush
@endsection
