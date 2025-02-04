<?php

namespace App\Http\Controllers;

use App\Models\AboutTeamMember;
use App\Models\TeamMember;
use App\Models\TeamMemberSocialLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    public function viewTeamMember($id)
    {
    $user = Auth::user();

    $aboutTeamMember = AboutTeamMember::where('member_id', $id)->first();
    $socialLinks = TeamMemberSocialLinks::where('member_id', $id)->get();
  
    // Initialiser les variables pour chaque type de lien
    $linkedin = $socialLinks->firstWhere('type', 'linkedin');
    $xLink = $socialLinks->firstWhere('type', 'x');
    $website = $socialLinks->firstWhere('type', 'website');

    
    $teamMember = TeamMember::where('id', $id)
        ->where('company_id', $user->id)
        ->whereNotNull('full_name')
        ->firstOrFail();

        return view('Company.team.view', compact('linkedin', 'xLink', 'website', 'teamMember', 'aboutTeamMember', 'socialLinks'));
    }

    public function editAboutTeamMember(Request $request)
    {
        $teamMemberId = $request->id_member;
    
        $teamMember = TeamMember::find($teamMemberId);
        if (!$teamMember) {
            return redirect()->back()->with('error', 'Empresa no encontrada.');
        }

        $description = $request->ta_about ? $request->ta_about : "";
        
    
        AboutTeamMember::updateOrCreate(
            ['member_id' => $teamMemberId],
            ['description' => $description]
        );
    
        // Redirection avec un message flash
        return redirect()->back()->with('success', 'La descripción se actualizó correctamente.');
    }

    
    public function updateTeamMemberSocialLinks(Request $request)
    {

        $validated = $request->validate([
            'linkedin' => 'nullable|url',
            'x_handle' => 'nullable|string',
            'website' => 'nullable|url',
            'id_member' => 'required'
        ]);
        
        $teamMemberId = $request->id_member;
    
        if (!empty($validated['linkedin'])) {
            TeamMemberSocialLinks::updateOrCreate(
                ['member_id' => $teamMemberId, 'type' => 'linkedin'],
                ['value' => $validated['linkedin']]
            );
        }
    
        if (!empty($validated['x_handle'])) {
            TeamMemberSocialLinks::updateOrCreate(
                ['member_id' => $teamMemberId, 'type' => 'x'],
                ['value' => $validated['x_handle']]
            );
        }
    
        if (!empty($validated['website'])) {
            TeamMemberSocialLinks::updateOrCreate(
                ['member_id' => $teamMemberId, 'type' => 'website'],
                ['value' => $validated['website']]
            );
        }
    
        return redirect()->back()->with('success', 'Los enlaces sociales se han actualizado correctamente.');
    }



    
    public function updateDetails(Request $request)
    {
        $validated = $request->validate([
            'id_member' => 'required',
            'email' => [
                'required',
                'email',
            ],
            'phone-1' => [
                'required',
                'regex:/^\+?[0-9]{8,20}$/',
            ],
            'phone-2' => [
                'nullable',
                'regex:/^\+?[0-9]{8,20}$/',
            ],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, introduce un correo electrónico válido.',
            'phone-1.required' => 'El número de teléfono 1 es obligatorio.',
            'phone-1.regex' => 'Por favor, introduce un número de teléfono válido (8 a 20 dígitos).',
            'phone-2.regex' => 'Por favor, introduce un número de teléfono válido (8 a 20 dígitos).',
        ]);
        
        
        $teamMemberId = $request->id_member;
    
        $teamMember = TeamMember::where('id', $teamMemberId)->first();
        if (!$teamMember) {
            return response()->json(['success' => false, 'message' => 'Candidat introuvable.'], 404);
        }
        
        $teamMember->email = $validated['email'];
        $teamMember->tel_1 = $validated['phone-1'];
        $teamMember->tel_2 = $validated['phone-2'];
        $teamMember->save();

        return redirect()->back()->with('success', 'Los detalles se han actualizado correctamente.');
    }


    
    public function updateTeamMemberAvatar(Request $request)
    {
        dd($request->all());
        
        $validated = $request->validate([
            'avatar' => 'required|string',
            'memberId' => 'required|integer',
        ]);

        $teamMember = TeamMember::find($request->memberId);

        $teamMember->avatar_path = $validated['avatar'];
        $teamMember->save();

        return response()->json(['success' => true]);
    }
    

    public function updateMemberAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|string',
            'memberID' => 'required'
        ]);

        $memberID = $validated['memberID'];
        $member = TeamMember::findOrFail($memberID);

        // Mise à jour de la colonne avatar_path dans la base de données
        $member->avatar_pic = $validated['avatar'];
        $member->save();

        return response()->json(['success' => true]);
    }
    
}
