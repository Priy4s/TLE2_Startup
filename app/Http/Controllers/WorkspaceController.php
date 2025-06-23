<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::all();
        return view('workspaces.index', compact('workspaces'));
    }

    public function create()
    {
        return view('workspaces.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Workspace::create([
            'name' => $request->name
        ]);

        return redirect()->route('workspaces.index');
    }

    public function edit(Workspace $workspace)
    {
        return view('workspaces.edit', compact('workspace'));
    }

    public function update(Request $request, Workspace $workspace)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $workspace->update($request->all());
        return redirect()->route('workspaces.index');
    }

    public function destroy(Workspace $workspace)
    {
        $workspace->delete();
        return redirect()->route('workspaces.index');
    }

    public function show(Workspace $workspace)
    {
        // Eager load notes and links
        $workspace->load(['notes', 'links']);
        return view('workspaces.show', compact('workspace'));
    }
}
