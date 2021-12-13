<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
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

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', ['project' => $project]);
    }

    public function update(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $project->update([
            'notes' => request('notes')
        ]);

        return redirect($project->path());
    }
}
