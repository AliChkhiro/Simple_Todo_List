@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📋 Liste des tâches</h2>
        <a href="{{ route('todos.create') }}" class="btn btn-primary">
            ➕ Ajouter une tâche
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!--Formulaire de recherche-->
    <form action="{{ route('todos.index') }}" method="GET" class="row g-2 mb-4">
    <div class="col-md-8">
        <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher une tâche..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
    </div>
</form>


    <!-- Filtres -->
   <!-- <div class="mb-4">
        <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary btn-sm">Toutes</a>
        <a href="{{ route('todos.index', ['filter' => 'completed']) }}" class="btn btn-outline-success btn-sm">Terminées</a>
        <a href="{{ route('todos.index', ['filter' => 'active']) }}" class="btn btn-outline-warning btn-sm">Non terminées</a>
    </div>
-->
@php
    $search = request('search');
@endphp

<div class="mb-4">
    <a href="{{ route('todos.index', ['search' => $search]) }}" class="btn btn-outline-secondary btn-sm">Toutes</a>
    <a href="{{ route('todos.index', ['filter' => 'completed', 'search' => $search]) }}" class="btn btn-outline-success btn-sm">Terminées</a>
    <a href="{{ route('todos.index', ['filter' => 'active', 'search' => $search]) }}" class="btn btn-outline-warning btn-sm">Non terminées</a>
</div>


    <div class="row">
        @forelse($todos as $todo)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                    <form action="{{ route('todos.update', $todo->id) }}" method="POST" id="checkbox-form-{{ $todo->id }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="completed" value="{{ $todo->completed ? 'off' : 'on' }}">
                        <input type="checkbox" onChange="document.getElementById('checkbox-form-{{ $todo->id }}').submit()" {{ $todo->completed ? 'checked' : '' }}>
                    </form>
                    <span>{{ $todo->title }}</span>


                        {{ $todo->title }}
                        @if($todo->completed)
                            <span class="badge bg-success float-end">Terminée</span>
                        @else
                            <span class="badge bg-warning text-dark float-end">En cours</span>
                        @endif
                    </h5>
                    <p class="card-text">{{ $todo->description }}</p>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between">
                    <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-outline-info btn-sm">✏️ Modifier</a>
                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $todo->id }})">🗑️ Supprimer</button>

                    <form id="delete-form-{{ $todo->id }}" action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info">Aucune tâche à afficher.</div>
        @endforelse
    </div>
</div>

<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(todoId) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + todoId).submit();
            }
        })
    }
</script>
@endsection
