@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card-header pb-0 row align-items-center mb-4">
            <div class="col-4">
                <h6 class="page-title">Categories<span class="data-count text-primary ms-2">(34)</span></h6>
            </div>
            <div class="col-4">
                <div class="filter-dropdown dropdown">
                    <div class="filter-box dropdown-toggle cursor-pointer" id="filterdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./img/icons/misc/filter.png" />
                        Apply Filter
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="filterdropdown">
                        <li><a class="dropdown-item" href="#">Sort by Name</a></li>
                        <li><a class="dropdown-item" href="#">Sort by Author</a></li>
                        <li><a class="dropdown-item" href="#">Sort by Date</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-4 col-4 text-md-end">
                <button class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus me-2"></i>Add New Category
                </button>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table table-books align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="w-10">Select</th>
                            <th class="ps-2">Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1 align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" value="">
                                        </div>
                                        <div class="row-img">
                                            <img src="{{asset($category->image_path)}}" alt="image">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-md mb-2 text-darker">{{$category->name}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="text-sm text-dark mb-0">
                                        <a class="btn btn-outline-primary btn-outline-blue text-bold me-2 mb-0">Edit</a>
                                        <a href="{{$category->id}}" class="btn btn-outline-danger text-bold  mb-0">Delete</a>
                                    </p>
                                </td>
                            </tr>
                            <tr class="row-spacer"></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="modal-form" role="form" action={{ route('categories') }} enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Add Image</label>
                                <img src="img/add-category.png" class="w-100 cursor-pointer img-upload-btn" />
                                <input type="file" name="category-image" class="d-none" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100 py-3">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
<script src="assets/js/jquery-3.6.1.min.js"></script>
<script>
    $(".img-upload-btn").click(() => {
        $("[name=category-image]").click();
    })
    $("[name=category-image]").change(function(){
        $(".img-upload-btn").attr('src', URL.createObjectURL(this.files[0]));
    })
</script>
@endpush