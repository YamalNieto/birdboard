<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => ['required'],
            'description' => ['required'],
            'notes' => ['max:255']
        ]);

        $attributes['user_id'] = auth()->id();

        $project = Project::create($attributes);

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', ['project' => $project]);
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = request()->validate([
            'title' => ['required', 'sometimes'],
            'description' => ['required', 'sometimes'],
            'notes' => ['max:255']
        ]);

        $project->update($attributes);

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
