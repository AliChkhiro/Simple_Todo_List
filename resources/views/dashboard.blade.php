@extends('layout')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h2>👋 Bienvenue, {{ $user->name }} !</h2>
        <p class="text-muted">Voici un aperçu de votre activité sur la To-Do App</p>
    </div>

    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">📋 Total des tâches</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">✅ Tâches complétées</h5>
                    <h2>{{ $completed }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3 shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">🕒 Tâches en cours</h5>
                    <h2>{{ $active }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('todos.create') }}" class="btn btn-success">➕ Ajouter une tâche</a>
        <a href="{{ route('todos.index') }}" class="btn btn-outline-primary">📂 Voir la liste des tâches</a>
    </div>
</div>
@endsection
