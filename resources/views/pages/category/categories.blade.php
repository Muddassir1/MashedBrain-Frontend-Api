@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card-header pb-0 row align-items-center mb-4">
            <div class="col-6">
                <h6 class="page-title">Categories<span class="data-count text-primary ms-2">(34)</span></h6>
            </div>
            <div class="col-6 text-md-end">
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
                                    <a class="btn btn-edit btn-outline-primary btn-outline-blue text-bold me-2 mb-0" data-id="{{$category->id}}" data-name="{{$category->name}}" data-image="{{$category->image_path}}">Edit</a>
                                    <a class="btn btn-outline-danger text-bold  mb-0" onclick="document.getElementById('delete-{{$category->id}}').submit()">Delete</a>
                                </p>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" id="delete-{{$category->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
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

<!-- Edit Category Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryEditModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="edit-modal-form" role="form" action={{ route('categories.update',1) }} enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="image_path" value="" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Add Image</label>
                                <img src="img/add-category.png" class="d-block m-auto mw-100 cursor-pointer img-upload-btn" />
                                <input type="file" name="category-image" class="d-none" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100 py-3">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- New Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="modal-form" role="form" action={{ route('categories') }} enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Add Image</label>
                                <img src="img/add-category.png" class="d-block m-auto mw-100 cursor-pointer img-upload-btn" />
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
<script src="{{asset('assets/js/jquery-3.6.1.min.js')}}"></script>
<script>
    $(".img-upload-btn").click(function(e) {
        $(this).parents('form').find($("[name=category-image]")).click();
    })
    
    $("[name=category-image]").change(function(e) {
        $(this).parents('form').find($(".img-upload-btn")).attr('src', URL.createObjectURL(this.files[0]));
    })

    $(".btn-edit").click(function(e){
        $form = $(".edit-modal-form");
        var id = $(this).data('id');
        var name = $(this).data('name');
        var image = $(this).data('image');
        $form.attr("action","/categories/"+id);
        $form.find("[name=id]").val(id);
        $form.find("[name=name]").val(name);
        $form.find("[name=image_path]").val(image);
        $form.find(".img-upload-btn").attr('src',image);
        $("#categoryEditModal").modal('show');
    })
</script>
@endpush