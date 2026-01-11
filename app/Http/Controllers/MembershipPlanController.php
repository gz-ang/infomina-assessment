<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MembershipPlan;
use App\Models\Member;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('MembershipPlans/Index', [
            'membershipPlans' => MembershipPlan::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MembershipPlans/CreateEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'validity_type' => 'required',
            'validity' => 'required',
        ]);

        MembershipPlan::create($request->all());

        return redirect()->route('membership-plans.index')->with('success', 'Membership plan created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembershipPlan $membership_plan)
    {
        return Inertia::render('MembershipPlans/CreateEdit', [
            'membershipPlan' => $membership_plan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembershipPlan $membership_plan)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'validity_type' => 'required',
            'validity' => 'required',
        ]);

        $membership_plan->update($request->all());

        return redirect()->route('membership-plans.index')->with('success', 'Membership plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipPlan $membership_plan)
    {
        $membership_plan->delete();

        return redirect()->route('membership-plans.index')->with('success', 'Membership plan deleted successfully');
    }

    /**
     * Check if the membership plan can be deleted.
     */
    public function canDelete(int $membership_plan_id)
    {
        // Check if the membership plan is in use
        $in_use = Member::where('membership_plan_id', $membership_plan_id)->exists();

        return response()->json([
            'inUse' => $in_use,
        ]);
    }
}
