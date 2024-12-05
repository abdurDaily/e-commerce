@extends('backend.layout')
@section('backend_contains')
    <section>
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <span>{{ request()->path() }}</span>
                <a href="" class="btn btn-primary">view all</a>
            </div>

            <div class="col-xl-6 mx-auto mt-3 card p-4 shadow-sm">
                <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <label for="category_name">category name <b>*</b> </label>
                    <input type="text" name="category_name" id="category_name" class="form-control mb-3" placeholder="category name">


                    <label for="parent_name">select a parent </label>
                    <select id="parent_name" name="parent_name" class="form-control">
                        <option data-display="Select" selected disabled>select one</option>
                        @foreach ($allCategorys as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        
                        @endforeach
                    </select>


                    <div class="imge_placegolder d-flex justify-content-center my-3">
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


    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#parent_name').select2({
                placeholder: "Select a parent category",
                allowClear: true
            });
        });
    </script>
@endpush
