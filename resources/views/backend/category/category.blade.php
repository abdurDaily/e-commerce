@extends('backend.layout')
@section('backend_contains')
    @push('backend_css')
        <style>
            #category .select2-selection--single {
                height: 41px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: #000;
                border: 1px solid #dee2e6;
            }

            #category .select2-container--default .select2-selection--single .select2-selection__clear {
                cursor: pointer;
                float: right;
                font-weight: bold;
                background: red;
                position: absolute;
                right: 4%;
                top: 5px;
                width: 30px;
                height: 30px;
                line-height: 30px;
                text-align: center;
                color: #fff;
                font-size: 18px;
                z-index: 6;
            }

            #category .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 1px;
                right: 1px;
                width: 20px;
                position: absolute;
                top: 7px;
                right: 3%;
                color: #dee2e6;
                z-index: 5;

            }

            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid #dee2e6 !important;
                padding: 10px;
            }
        </style>
    @endpush


    <section id="category">
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
                    <div class="error-message" id="category_name_error" style="color: red;"></div>


                    <label for="parent_name">select a parent </label>
                    <select id="parent_name" name="parent_name" class="form-control">
                        <option selected disabled></option>
                        @foreach ($allCategorys as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>

                    <div class="img_placegolder d-flex justify-content-center my-3">
                        <label for="category_img" style="cursor: pointer;">
                            <img class="img-fluid" src="{{ asset('assets/images/category_image.png') }}" alt="">
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
                allowClear: true,
                ajax: {
                    url: `{{ route('admin.category.process') }}`,
                    dataType: 'json',
                    processResults: function(data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        }
                    },
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }

                }
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
                        $('.error-message').html('');
                        $('#parent_name').html('');
                        Swal.fire({
                            title: res.status,
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'cancel',
                            timer: 3000
                        });
                        $('#category_submit').trigger('reset');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON;
                        $('.error-message').html(errors.errors.category_name);
                    }
                });
            });
        });
    </script>
@endpush
