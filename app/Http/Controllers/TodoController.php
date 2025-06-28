<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // Afficher la liste des tâches
    public function index(Request $request)
{
    $filter = $request->query('filter');
    $search = $request->query('search');

    $query = Todo::query();

    if ($filter === 'completed') {
        $query->where('completed', true);
    } elseif ($filter === 'active') {
        $query->where('completed', false);
    }

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('description', 'like', "%$search%");
        });
    }

    $todos = $query->get();

    return view('todos.index', compact('todos'));
}

    // Afficher le formulaire de création
    public function create()
    {
        return view('todos.create');
    }

    // Stocker une nouvelle tâche
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);

        return redirect()->route('todos.index')->with('success', 'Tâche ajoutée avec succès.');
    }

    // Afficher le formulaire d'édition
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    // Mettre à jour une tâche
    public function update(Request $request, Todo $todo)
{
    // Cas 1 : Mise à jour via case à cocher seulement
    if ($request->has('completed') && !$request->has('title')) {
        $todo->update([
            'completed' => $request->completed === 'on',
        ]);
        return back()->with('success', 'Statut de la tâche mis à jour.');
    }

    // Cas 2 : Mise à jour complète via le formulaire d'édition
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
    ]);

    $todo->update([
        'title' => $request->title,
        'description' => $request->description,
        'completed' => $request->has('completed'),
    ]);

    return redirect()->route('todos.index')->with('success', 'Tâche mise à jour avec succès.');
}


    // Supprimer une tâche
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
