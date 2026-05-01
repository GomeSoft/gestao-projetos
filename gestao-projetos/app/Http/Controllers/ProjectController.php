<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Exibe a lista de projetos do utilizador autenticado.
     */
    public function index()
    {
        // Só retorna os projetos que pertencem ao utilizador (Segurança de Base)
        $projects = Project::where('user_id', auth()->id())->get();

        return Inertia::render('Projects/Index', [
            'projects' => $projects
        ]);
    }

    /**
     * Exibe um projeto específico.
     * Consumido pelo React: route('projects.show', id)
     */
    public function show(Project $project)
    {
        // 1. Proteção contra IDOR: Verifica a Policy que criámos antes
        $this->authorize('view', $project);

        // 2. Se passar a autorização, renderiza o componente React
        return Inertia::render('Projects/Show', [
            'project' => $project
        ]);
    }

    public function updateBudget(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        // DB Transaction para garantir que tudo corre bem ou nada corre
        DB::transaction(function () use ($request, $project) {
            // 'lockForUpdate' bloqueia a linha na DB até a transação acabar
            $projectData = Project::where('id', $project->id)
                ->lockForUpdate()
                ->first();

            $projectData->budget += $request->amount;
            $projectData->save();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store(Request $request)
    {
        // 1. O Middleware 'honeypot' já está a agir aqui via routes

        // 2. Validação rigorosa
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planeamento,execucao,concluido',
        ]);

        // 3. Criar associado ao user autenticado (Proteção de posse)
        $request->user()->projects()->create($validated);

        return redirect()->route('projects.index')->with('success', 'Projeto criado!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
