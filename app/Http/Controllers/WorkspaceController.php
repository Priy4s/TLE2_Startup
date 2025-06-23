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
            'name' => $request->name,
            'user_id' => auth()->id(),

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
        return view('workspaces.show', compact('workspace'));
    }

    public function addDocumentToSelected(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'cloudfile_id' => 'required|exists:cloud_drive_files,id',
        ]);

        $workspace = Workspace::findOrFail($request->workspace_id);
        $cloudFileId = $request->cloudfile_id;

        $workspace->cloudFiles()->attach($cloudFileId);

        return redirect()->back()->with('success', 'Document successfully added to workspace.');
    }

}