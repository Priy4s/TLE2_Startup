<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = Calendar::orderBy('date')->get();

        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        return view('calendar.index', [
            'events' => $events,
            'currentMonth' => $month,
            'currentYear' => $year,
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
        ]);

        $datetime = \Carbon\Carbon::parse($validated['date'])->format('Y-m-d H:i:s');

        Calendar::create([
            'event' => $validated['event'],
            'date' => $datetime,
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