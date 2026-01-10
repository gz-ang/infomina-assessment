<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class MemberController extends Controller
{
    public function index()
    {
        return Inertia::render('Members/Index', [
            'members' => Member::with(['membershipPlan' => function ($query) {
                $query->withTrashed();
            }])->latest()->get(),
        ]);
    }

    public function create()
    {
        $membershipPlans = MembershipPlan::all();
        return Inertia::render('Members/CreateEdit', [
            'member' => null,
            'membershipPlans' => $membershipPlans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:members',
            'membership_plan_id' => 'required',
        ]);
        
        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        $membershipPlans = MembershipPlan::all();
        return Inertia::render('Members/CreateEdit', [
            'member' => $member,
            'membershipPlans' => $membershipPlans,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'membership_plan_id' => 'required',
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
