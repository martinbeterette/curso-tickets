<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supports = Support::paginate(10);
        return Inertia::render('Supports/Index', [
            'supports' => $supports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Supports/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:technical_supports,email',
                'phone' => 'nullable|string|in:Software,Hardware,Networking,Operating Systems'
            ]);
            Support::create($validated);
            return redirect()
                ->route('support.index')
                ->with('success', 'Registry created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Could not create record: ' . $e->getMessage());
        }
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
    public function edit(Support $support)
    {
        return inertia::render('Supports/Edit', [
            'support' => $support
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Support $support)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:supports,email,' . $support->id,
                'phone' => 'nullable|string|max:20',
                'speciality' => 'nullable|string|in:Software,Hardware,Networking,Operating Systems',
            ]);
            $support::update($validated);
            return redirect()
                ->route('supports.index')
                ->with('success', 'Registry updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Could not create record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Support $support)
    {
        try {
            if (!$request->has('confirm') && $support->tickets()->count() > 0) {
                return back()->with('warning', "this Support has {$support->tickets()->count()} ticket(s) associated with it. If you deleted it, all of those tickets will also be deleted. please confirm to continue.");
            }
            $support->delete();
            return redirect()
                ->route('supports.index')
                ->with('success', 'Support and their tickets successfully deleted.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Could not delete client: ' . $e->getMessage());
        }
    }
}
