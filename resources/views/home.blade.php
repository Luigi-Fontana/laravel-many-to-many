@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-secondary m-3" href="{{route('admin.users.index')}}">Gestisci Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active btn btn-secondary m-3" href="{{route('admin.info_users.index')}}">Gestisci Utenti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active btn btn-primary m-3" href="{{route('admin.pages.index')}}">Gestisci Pagine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active btn btn-secondary m-3" href="{{route('admin.categories.index')}}">Gestisci Categorie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active btn btn-secondary m-3" href="{{route('admin.tags.index')}}">Gestisci Tag</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active btn btn-secondary m-3" href="{{route('admin.photos.index')}}">Gestisci Foto</a>
                        </li>
                    </ul>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
