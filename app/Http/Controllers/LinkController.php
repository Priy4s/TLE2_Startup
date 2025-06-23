<?php
namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'url' => 'required|url',
            'label' => 'nullable|string|max:255',
        ]);

        Link::create($request->only('workspace_id', 'url', 'label'));

        return back()->with('success', 'Link toegevoegd!');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return back()->with('success', 'Link verwijderd.');
    }
}
