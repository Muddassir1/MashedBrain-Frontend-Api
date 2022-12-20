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
                    <a href="{{ route('books.create') }}" class="btn btn-cancel font-weight-bold mb-0 me-3 w-25">
                        Cancel
                    </a>
                    <a href="#"
                        class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border w-25 btn-continue">
                        Continue
                    </a>
                </div>
            </div>
            <div class="card">
                <form id="book-add-form" class="add-form" role="form" method="POST" action={{ route('books.store') }}
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="form-control-label">Book Name</label>
                                    <input class="form-control" type="text" name="name" value="">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Author Name</label>
                                    <input class="form-control" type="text" name="author" value="">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Language</label>
                                            <select class="form-control" name="language">
                                                <option>Select option</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Category</label>
                                            <select class="form-control" name="category">
                                                <option>Select option</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Recommended</label>
                                            <select class="form-control" name="recommended">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Popular</label>
                                            <select class="form-control" name="popular">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Read Time</label>
                                            <input name="time" placeholder="10 minutes" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Book Image</label>
                                            <img src="{{ asset('img/book-img-upload.png') }}"
                                                class="w-100 cursor-pointer img-upload-btn" />
                                            <input type="file" name="book_image" class="d-none" accept="image/*" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Book Audio</label>
                                            <img src="{{ asset('img/upload-audio.png') }}"
                                                class="w-100 cursor-pointer audio-upload-btn" />
                                            <input type="file" name="book_audio" class="d-none" accept="audio/*" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">What's it about</label>
                                <textarea class="form-control pe-5" name="about_book" rows="10">If you look past the decluttering books, the best books on minimalism help you understand the Why of a minimalist lifestyle. You can declutter your house, but unless you change your mindset about your possessions and your needs versus wants, you are just going to end up right back where you started.</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Who is it for</label>
                                <textarea class="form-control" name="about_audience" rows="10">If you look past the decluttering books, the best books on minimalism help you understand the Why of a minimalist lifestyle. You can declutter your house, but unless you change your mindset about your possessions and your needs versus wants, you are just going to end up right back where you started.</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">About the Author</label>
                                <textarea class="form-control" name="about_author" rows="10">If you look past the decluttering books, the best books on minimalism help you understand the Why of a minimalist lifestyle. You can declutter your house, but unless you change your mindset about your possessions and your needs versus wants, you are just going to end up right back where you started.</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto d-none">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script>
        $(".img-upload-btn").click(function(e) {
            $(this).parents('form').find($("[name=book_image]")).click();
        })
        $(".audio-upload-btn").click(function(e) {
            $(this).parents('form').find($("[name=book_audio]")).click();
        })

        $("[name=book_image]").change(function(e) {
            $(this).parents('form').find($(".img-upload-btn")).attr('src', URL.createObjectURL(this.files[0]));
        })

        $(".btn-continue").click(function() {
            $("#book-add-form").submit();
        })
    </script>
@endpush
