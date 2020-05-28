@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary m-3" href="{{route('admin.pages.index')}}">&#8592; Torna all'indice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-warning m-3" href="{{route('admin.pages.edit', $page->id)}}">Modifica</a>
                    </li>
                    <li class="nav-item">
                        @if(Auth::id() == $page->user_id)
                            <form action="{{route('admin.pages.destroy', $page->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input class="nav-link btn btn-danger m-3" type="submit" value="Elimina">
                            </form>
                        @endif
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
                        @foreach ($page->tags as $tag)
                            <small>#{{$tag->name}} </small>
                        @endforeach
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
