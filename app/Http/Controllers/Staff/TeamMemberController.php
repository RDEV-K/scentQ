<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = TeamMember::latest('id')->get();
        return view('staff.team-member.index', compact('members'));
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
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'description' => 'required',
            'linkedin_url' => 'required',
            'avatar' => 'required|image'
        ]);

        $url = uploadImage($request->avatar, 'team-member');

        TeamMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'description' => $request->description,
            'linkedin_url' =>  $request->linkedin_url,
            'img_url' => $url,
        ]);

        return redirect()->back()->withSuccess(__('Data saved.'));
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
    public function edit(TeamMember $team_member)
    {
        $members = TeamMember::latest('id')->get();
        return view('staff.team-member.index', compact('members', 'team_member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $team_member)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'description' => 'required',
            'linkedin_url' => 'required',
            'avatar' => 'nullable|image'
        ]);

        $url = $team_member->img_url;
        if ($request->hasFile('avatar')) {
            deleteImage($team_member->img_url);
            $url = uploadImage($request->avatar, 'team-member');
        }

        $team_member->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'description' => $request->description,
            'linkedin_url' =>  $request->linkedin_url,
            'img_url' => $url,
        ]);

        return redirect()->route('staff.team-member.index')->withSuccess(__('Data updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $team_member)
    {
        deleteImage($team_member->img_url);
        $team_member->delete();

        return redirect()->route('staff.team-member.index')->withSuccess(__('Data deleted.'));
    }
}
