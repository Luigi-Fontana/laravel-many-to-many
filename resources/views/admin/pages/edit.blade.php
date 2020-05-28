@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active btn btn-primary m-3" href="{{route('admin.pages.index')}}">Annulla Modifiche</a>
                    </li>
                </ul>
                <form action="{{route('admin.pages.update', $page->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title">Titolo</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{old('title') ?? $page->title}}">
                    </div>
                    @error('title')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="summary">Sommario</label>
                        <input type="text" name="summary" id="summary" class="form-control" value="{{old('summary') ?? $page->summary}}">
                    </div>
                    @error('summary')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="body">Testo</label>
                        <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{old('body') ?? $page->body}}</textarea>
                    </div>
                    @error('body')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="category_id">Categoria</label>
                        <select name="category_id" id="category_id">
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{(!empty(old('category_id')) || $category->id == $page->category->id) ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <span class="alert alert-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <h3>Tags</h3>
                        @foreach ($tags as $key => $tag)
                            <label for="tags-{{$tag->id}}">{{$tag->name}}</label>
                            <input type="checkbox" name="tags[]" id="tags-{{$tag->id}}" value="{{$tag->id}}" {{(!empty(old('tags.'. $key)) ||  $page->tags->contains($tag->id)) ? 'checked' : ''}}>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h3>Photos</h3>
                        @foreach ($photos as $photo)
                            <label for="photos-{{$photo->id}}">{{$photo->name}}</label>
                            <input type="checkbox" name="photos[]" id="photos-{{$photo->id}}" value="{{$photo->id}}" {{(!empty(old('photos.'. $key)) ||  $page->photos->contains($photo->id)) ? 'checked' : ''}}>
                        @endforeach
                    </div>
                    <input type="submit" value="Salva" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
@endsection
