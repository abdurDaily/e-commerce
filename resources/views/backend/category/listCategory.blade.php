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


            <table class="table mt-3">
                <tr>
                    <th>#</th>
                    <th>Categoty Name</th>
                    <th>image</th>
                    <th>status</th>
                    <th>action</th>
                </tr>
               
                @forelse($categories as $key => $category)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $category->category_name }} </td>
                        <td> {{ $category->category_img }} </td>
                        <td> {{ $category->status }} </td>
                        <td> 
                            <a href="">Edit</a> / 
                            <a href="">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <b class="text-danger">no data found!</b>
                        </td>
                    </tr>
                @endforelse



                
            </table>



        </div>
    </section>
@endsection

