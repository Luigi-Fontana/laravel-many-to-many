@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active btn btn-primary m-3" href="{{route('admin.pages.index')}}">Torna all'indice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active btn btn-primary m-3" href="{{route('admin.pages.edit', $page->id)}}">Modifica</a>
                    </li>
                </ul>
                <h1>{{$page->title}}</h1>
                <h4>Categoria :{{$page->category->name}}</h4>
                <small>Scritto da: {{$page->user->name}}<br></small>
                <small>Ultima modifica: {{$page->updated_at}}</small>
                <div>
                    <p>{{$page->body}}</p>
                </div>
                @if($page->tags->count() > 0)
                    <div>
                        <h4>Tags</h4>
                        <ul>
                        @foreach ($page->tags as $tag)
                            <li>{{$tag->name}}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                @if($page->photos->count() > 0)
                    <div>
                        <h4>Foto</h4>
                        @foreach ($page->photos as $photo)
                            <div>
                                <p>{{$photo->name}}</p>
                                <img src="{{$photo->path}}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
