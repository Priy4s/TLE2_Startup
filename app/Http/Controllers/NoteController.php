<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'content' => 'required|string|max:1000'
        ]);

        Note::create([
            'workspace_id' => $request->workspace_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Note added successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return back()->with('success', 'Note deleted.');
    }
}
