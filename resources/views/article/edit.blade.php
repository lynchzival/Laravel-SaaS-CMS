@extends('main.index', ['title' => 'edit article', 'favicon' => asset('img/feather.svg')])

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('navbrand')
    <img src="{{ asset('img/graduation-cap.svg') }}" width="30" height="30" alt="">
@endsection

@section('styles')
    <style>
        #article_thumbnail{
            background: #ecf0f1 url("{{ asset($article->thumbnail) }}") no-repeat fixed center center;
            background-size: cover;
        }
    </style>
@endsection

@section('content')
    <header class="py-5 bg-image-full article">
        <div class="container text-center my-5 text-black">
            <form action="{{ route('article.update', ['article' => $article -> slug]) }}" method="POST" 
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="modal-header border-dark">
                    <h4 class="modal-title text-uppercase">
                        <i class="fi fi-rr-pencil"></i> edit article
                        <span>{{ date('d-M-Y') }}</span>
                    </h4>
                </div>

                <div class="modal-body text-left">

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4 mt-3">
                                <div id="article_thumbnail">
                                    <input type="file" name="thumbnail">
                                    <div>
                                        Drag your image here or click in this area.
                                    </div>
                                </div>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            @if ($article -> thumbnail)
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="thumbnail_removal">
                                        <label class="form-check-label">
                                            Remove Image
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control bg-transparent border-dark" placeholder="Enter title" name="title" autocomplete="off" 
                                value="{{ $article -> title }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-select" name="category_id">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                    {{ $article -> category_id === $category -> id ? 'selected' : ''  }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Content</label>
                        <img src="{{ asset('img/loader.svg') }}" width="50" height="50" alt="">
                        <textarea class="form-control bg-transparent border-dark d-none" rows="4" name="content">{{ $article -> content }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-12 col-md-8 col-lg-6 bg-light shadow-sm rounded-pill py-2 px-4 d-flex justify-content-evenly mx-auto my-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="published"
                            {{ ($article -> published === 1) ? 'checked' : ''}}>
                            <label class="form-check-label text-uppercase">Published</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="comment"
                            {{ ($article -> comment_status === 1) ? 'checked' : ''}}>
                            <label class="form-check-label text-uppercase">Comment</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="premium"
                            {{ ($article -> is_premium === 1) ? 'checked' : ''}}>
                            <label class="form-check-label text-uppercase">
                                <i class="fi fi-rr-diamond"></i>
                            </label>
                        </div>

                        @can('admin')
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pinned"
                            {{ ($article -> isPinned()) ? 'checked' : ''}}>
                            <label class="form-check-label text-uppercase">Pinned</label>
                        </div>
                        @endcan
                    </div>

                </div>

                <div class="modal-footer border-dark">
                    <a href="{{ route('article.index') }}" 
                    class="btn btn-outline-danger text-uppercase">Close</a>

                    <button type="submit" class="btn btn-outline-dark text-uppercase">Save</button>
                </div>
            </form>
        </div>
    </header>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/tinymce.min.js" integrity="sha512-ykwx/3dGct2v2AKqqaDCHLt1QFVzdcpad7P5LfgpqY8PJCRqAqOeD4Bj63TKnSQy4Yok/6QiCHiSV/kPdxB7AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#article_thumbnail input').change(function () {
                $('#article_thumbnail div').text(this.files.length + " file(s) selected");
            });
        });
    </script>
@endsection