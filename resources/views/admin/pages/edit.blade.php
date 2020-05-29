@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary m-3" href="{{route('admin.pages.index')}}">&#8592; Annulla Modifiche</a>
                    </li>
                </ul>
                <form action="{{route('admin.pages.update', $page->id)}}" method="POST" enctype="multipart/form-data">
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
                            <input type="checkbox" name="tags[]" id="tags-{{$tag->id}}" value="{{$tag->id}}" {{((is_array(old('tags')) && in_array($tag->id, old('tags'))) ||  $page->tags->contains($tag->id)) ? 'checked' : ''}}>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h3>Photos</h3>
                        @foreach ($page->photos as $photo)
                            <img class="img-fluid"  src="{{asset('storage/'. $photo->path)}}" alt="{{$photo->name}}">
                        @endforeach
                        <input type="file" name="photo-file" >
                    </div>
                    <input type="submit" value="Salva" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
@endsection
