@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">🆕 Ajouter une nouvelle tâche</h3>

            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops !</strong> Veuillez corriger les erreurs ci-dessous :
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('todos.store') }}" method="POST">
                @csrf

                <!-- Champ Titre -->
                <div class="mb-3">
                    <label for="title" class="form-label">📌 Titre</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="Ex: Réviser Spring Boot" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">📝 Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                              rows="4" placeholder="Ex: Travailler les annotations @RestController, @Service...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                         Ajouter
                    </button>
                    <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                         Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
