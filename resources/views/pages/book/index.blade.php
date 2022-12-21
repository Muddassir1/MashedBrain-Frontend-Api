@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card-header pb-0 row align-items-center mb-4">
            <div class="col-md-4 col-6">
                <h6 class="page-title">Books<span class="data-count text-primary ms-2">(34)</span></h6>
            </div>
            <div class="col-md-4 col-6">
                <div class="filter-dropdown dropdown">
                    <div class="filter-box dropdown-toggle cursor-pointer" id="filterdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./img/icons/misc/filter.png" />
                        <span class="filter-text">Apply Filter</span>
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="filterdropdown">
                        @foreach($categories as $category)
                        <li onclick="filterBooks('{{$category->id}}','{{$category->name}}')"><a class="dropdown-item" href="#">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">
                <a href="{{ route('books.create') }}" class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border">
                    <i class="fas fa-plus me-2"></i>Add New Book
                </a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="p-0">
                <table class="table table-books align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="">Select</th>
                            <th class="ps-2">Name & Description</th>
                            <th class="text-center">
                                Author</th>
                            <th class="text-center">
                                Uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>
                                <div class="d-flex px-3 py-1 align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" value="" onchange="selectRow(this)">
                                    </div>
                                    <div class="book-image-thumb">
                                        <img class="w-100" src="{{asset($book->image_path)}}" alt="image">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-3 text-darker">{{$book->name}}</p>
                                <p>

                                    <a href="{{route('books.edit',[$book->id])}}" class="btn btn-primary-light me-2">Edit Book</a>
                                    <button class="btn btn-primary-light me-2">Preview</button>
                                    <a class="btn btn-danger-light" onclick="document.getElementById('delete-{{$book->id}}').submit()">Delete</a>
                                </p>
                                <form class="d-none" action="{{ route('books.destroy', $book->id) }}" method="POST" id="delete-{{$book->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <p class="text-sm text-darker mb-0">{{$book->author}}</p>
                            </td>
                            <td class="align-middle text-end">
                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                    <p class="text-sm text-darker mb-0">{{date('jS M, Y',strtotime($book->created_at))}}</p>
                                </div>
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
@endsection

@push('js')
<script src="{{asset('assets/js/jquery-3.6.1.min.js')}}"></script>

<script>
    function selectRow(elem) {
        $(elem).parents('tr').toggleClass('selected-row');
    }

    function filterBooks(id, name) {
        $('.filter-text').html(name);
        $.ajax({
            url: "{{route('books.filter')}}",
            dataType: 'JSON',
            data: {
                id
            },
            success: (data) => {
                updateBooksTable(data)
            }
        })
    }

    function updateBooksTable(data) {
        $('.table-books tbody').html('');
        data.forEach(function(elem) {
            var row = template(elem);
            $('.table-books tbody').append(row);
        })

    }

    function template(data) {
        var template = `<tr>
            <td>
                <div class="d-flex px-3 py-1 align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="" onchange="selectRow(this)">
                    </div>
                    <div class="book-image-thumb">
                        <img class="w-100" src="${data.image_path}" alt="image">
                    </div>
                </div>
            </td>
            <td>
                <p class="text-sm mb-2 text-dark">${data.name}</p>
                <p>
                    <a href="/books/${data.id}/edit" class="btn btn-primary-light me-2">Edit Book</a>
                    <button class="btn btn-primary-light me-2">Preview</button>
                    <a class="btn btn-danger-light" onclick="document.getElementById('delete-${data.id}').submit()">Delete</a>
                </p>
                <form class="d-none" action="/books/${data.id}" method="POST" id="delete-${data.id}">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
            <td class="align-middle text-center text-sm">
                <p class="text-sm text-dark mb-0">${data.author}</p>
            </td>
            <td class="align-middle text-end">
                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                    <p class="text-sm text-dark mb-0">{{date('jS M, Y',strtotime($book->created_at))}}</p>
                </div>
            </td>
        </tr>
        <tr class="row-spacer"></tr>`;
        return template;
    }
</script>
@endpush