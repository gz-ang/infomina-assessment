<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $members = Member::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })->with(['membershipPlan' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString(); 

        return Inertia::render('Members/Index', [
            'members' => $members,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        $membership_plans = MembershipPlan::all();
        return Inertia::render('Members/CreateEdit', [
            'member' => null,
            'membershipPlans' => $membership_plans,
        ]);
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'height' => 'required|integer',
            'weight' => 'required|numeric',
            'membership_plan_id' => 'required',
            'start_date' => 'required|date',
        ]);
        
        // Calculate end date base on membership plan validity
        $membership_plan = MembershipPlan::findOrFail($validated['membership_plan_id']);

        $start_date = Carbon::parse($validated['start_date']);

        $end_date = $start_date->copy();
        $end_date->add($membership_plan->validity, $membership_plan->validity_type);
        
        $validated['end_date'] = $end_date->toDateString();
        
        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        $membership_plans = MembershipPlan::all();
        return Inertia::render('Members/CreateEdit', [
            'member' => $member,
            'membershipPlans' => $membership_plans,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'height' => 'required|integer',
            'weight' => 'required|numeric',
            'membership_plan_id' => 'required',
            'start_date' => 'required|date',
        ]);

        // Calculate end date base on membership plan validity
        $membership_plan = MembershipPlan::findOrFail($validated['membership_plan_id']);

        $start_date = Carbon::parse($validated['start_date']);

        $end_date = $start_date->copy();
        $end_date->add($membership_plan->validity, $membership_plan->validity_type);
        
        $validated['end_date'] = $end_date->toDateString();

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
