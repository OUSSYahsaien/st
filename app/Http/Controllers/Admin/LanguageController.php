<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('Admin.languages.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255'
        ]);

        Language::create($validated);

        return redirect()->route('administration.languages')
                         ->with('success', 'Langue ajoutée avec succès');
    }

    public function update(Request $request, Language $language)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255'
        ]);

        $language->update($validated);

        return redirect()->route('administration.languages')
                         ->with('success', 'Langue mise à jour avec succès');
    }

    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->route('administration.languages')
                         ->with('success', 'Langue supprimée avec succès');
    }
}