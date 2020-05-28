@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active btn btn-primary m-3" href="{{route('home')}}">Torna alla Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active btn btn-primary m-3" href="{{route('admin.pages.create')}}">Nuova Pagina</a>
                    </li>
                </ul>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Titolo</th>
                            <th>Categoria</th>
                            <th>Tags</th>
                            <th>Modificato</th>
                            <th colspan="3">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{$page->id}}</td>
                                <td>{{$page->title}}</td>
                                <td>{{$page->category->name}}</td>
                                <td>
                                    @foreach ($page->tags as $tag)
                                        <small>#{{$tag->name}} </small>
                                    @endforeach
                                </td>
                                <td>{{$page->updated_at}}</td>
                                <td><a class="btn btn-warning" href="{{route('admin.pages.show', $page->id)}}">Visualizza</a></td>
                                <td><a class="btn btn-warning" href="{{route('admin.pages.edit', $page->id)}}">Modifica</a></td>
                                <td>
                                    @if(Auth::id() == $page->user_id)
                                        <form action="{{route('admin.pages.destroy', $page->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input class="btn btn-danger" type="submit" value="Elimina">
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$pages->links()}}
            </div>
        </div>
    </div>
@endsection
