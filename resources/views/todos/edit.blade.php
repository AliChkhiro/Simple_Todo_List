@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">✏️ Modifier la tâche</h3>

            <!-- Erreurs de validation -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur !</strong> Veuillez corriger les champs :
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-3">
                    <label for="title" class="form-label">📌 Titre</label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $todo->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">📝 Description</label>
                    <textarea name="description" id="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="3">{{ old('description', $todo->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut complété -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="completed" id="completed"
                        {{ old('completed', $todo->completed) ? 'checked' : '' }}>
                    <label class="form-check-label" for="completed">✅ Marquer comme complété</label>
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">💾 Mettre à jour</button>
                    <a href="{{ route('todos.index') }}" class="btn btn-secondary">↩️ Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
