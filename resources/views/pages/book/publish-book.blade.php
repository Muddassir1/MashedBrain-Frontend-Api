@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card-header pb-0 row align-items-center mb-4">
                <div class="col-6">
                    <h6 class="page-title"><i
                            class="fas fa-university me-2 text-dark-gray rounded-circle bg-gray-150 p-2"></i>Add a New Book
                    </h6>
                </div>
                <div class="col-6 text-md-end">
                    <a href="" class="btn btn-cancel font-weight-bold mb-0 me-3 w-25">
                        Cancel
                    </a>
                    <a href="#"
                        class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border w-25"
                        onclick="$('#publish-book').submit();return false;">
                        @if (isset($update))
                            Update
                        @else
                            Publish
                        @endif
                    </a>
                </div>
            </div>
            <form id="publish-book" class="add-form" role="form" method="POST" action={{ route('books.publish') }}
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="book_id" value="{{ $id }}" />
                @php($i = 1)
                @if (count($pages) > 0)
                    @foreach ($pages as $page)
                        <input type="hidden" name="id[]" value="{{ $page->id }}" />
                        <div class="card form-template mb-3">
                            <div class="card-header">
                                <h6 class="page-title">Page {{ $i }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Page Title</label>
                                    <input class="form-control" type="text" name="title[]" value="{{ $page->title }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Description</label>
                                    <textarea class="form-control" name="description[]" rows="10">{{ $page->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        @php($i++)
                    @endforeach
                @else
                    <div class="card form-template mb-3">
                        <div class="card-header">
                            <h6 class="page-title">Page 1</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label">Page Title</label>
                                <input class="form-control" type="text" name="title[]" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <textarea class="form-control" name="description[]" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                @endif

            </form>
            <div class="add-page my-4 cursor-pointer">
                <div class="btn-add-page"><i class="fal fa-plus me-2"></i>Add More Page</div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script>
        var page = $(".form-template").length;
        $(".btn-add-page").click(() => {
            var form_template = $(".form-template").last().clone();
            form_template.find('input,textarea').val('');
            form_template.find('.page-title').html("Page" + (page + 1));
            form_template.removeClass('form-template');
            $('form#publish-book').append($(form_template));
            page++;
        })
    </script>
@endpush
