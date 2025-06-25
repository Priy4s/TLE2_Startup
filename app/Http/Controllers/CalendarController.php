<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Illuminate\Support\Carbon;
use App\Models\Workspace;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = Calendar::where('user_id', auth()->id())
            ->orderBy('date')
            ->get();

        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $workspaces = Workspace::where('user_id', auth()->id())->get();

        return view('calendar.index', [
            'events' => $events,
            'currentMonth' => $month,
            'currentYear' => $year,
            'workspaces' => $workspaces,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event' => 'required|string|max:255',
            'date' => 'required|date',
            'workspace_id' => 'nullable|exists:workspaces,id',
        ]);

        $datetime = \Carbon\Carbon::parse($validated['date'])->format('Y-m-d H:i:s');

        Calendar::create([
            'event' => $validated['event'],
            'date' => $datetime,
            'user_id' => auth()->id(),
            'workspace_id' => $validated['workspace_id'],
        ]);

        return redirect()->route('calendar.index')->with('success', 'Event created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Calendar::findOrFail($id);
        $workspaces = Workspace::where('user_id', auth()->id())->get();
        return view('calendar.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'event' => 'required|string|max:255',
            'date' => 'required|date',
            'workspace_id' => 'nullable|exists:workspaces,id',
        ]);

        $event = Calendar::findOrFail($id);
        $event->update([
            'event' => $validated['event'],
            'date' => \Carbon\Carbon::parse($validated['date'])->format('Y-m-d H:i:s'),
        ]);

        return redirect()->route('calendar.index')->with('success', 'Event updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Calendar::findOrFail($id);
        $event->delete();

        return redirect()->route('calendar.index')->with('success', 'Event deleted!');
    }
}