@extends('backend.layout')
@section('backend_contains')
    <section>
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <span>{{ request()->path() }}</span>
                <a href="" class="btn btn-primary">view all</a>
            </div>

            <div class="col-xl-6 mx-auto mt-3 card p-4 shadow-sm">
                <form id="category_submit" enctype="multipart/form-data">
                    @csrf

                    <label for="category_name">category name <b>*</b> </label>
                    <input type="text" name="category_name" id="category_name" class="form-control mb-3"
                        placeholder="category name">

                     
                    <label for="parent_name">select a parent </label>
                    <select id="parent_name" name="parent_name" class="form-control">
                        <option data-display="Select" selected disabled>select one</option>
                        @foreach ($allCategorys as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>


                    <div class="img_placegolder d-flex justify-content-center my-3">
                        <label for="category_img" style="cursor: pointer;">
                            <img src="{{ asset('assets/images/category_image.png') }}" alt="">
                        </label>
                        <input type="file" hidden id="category_img" name="category_img">
                    </div>


                    <button class="btn btn-primary w-100" type="submit">submit</button>

                </form>
            </div>
        </div>
    </section>
@endsection

@push('backend_css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
@endpush
@push('backend_js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#parent_name').select2({
                placeholder: "Select a parent category",
                allowClear: true
            });
        });






        // FOR STORE CATEGORY DATA....
        $(function() {
            $('#category_submit').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.category.store') }}',
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire({
                            title: res.status,
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            timer:3000
                        });
                        $('#category_submit').trigger('reset');
                    }
                })
            })
        })
    </script>
@endpush
