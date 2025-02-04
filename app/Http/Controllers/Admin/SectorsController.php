<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySector;
use Illuminate\Http\Request;

class SectorsController extends Controller
{
    public function index()
    {
        $sectors = CompanySector::all();
        return view('Admin.sectors.index', compact('sectors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        CompanySector::create($validated);

        return redirect()->route('administration.sectors');
    }

    public function update(Request $request, CompanySector $cs)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $cs->update($validated);

        return redirect()->route('administration.sectors');
    }

    public function destroy($id)
    {
        $cs = CompanySector::findOrFail($id);
        $cs->delete();

        return redirect()->route('administration.sectors');
    }
}
