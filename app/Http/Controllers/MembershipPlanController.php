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
    public function edit(string $id)
    {
        $membershipPlan = MembershipPlan::findOrFail($id);
        
        if ($membershipPlan) {
            return Inertia::render('MembershipPlans/CreateEdit', [
                'membership_plan' => $membershipPlan,
            ]);
        } else {
            return redirect()->route('membership-plans.index')->with('error', 'Membership plan not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'validity_type' => 'required',
            'validity' => 'required',
        ]);

        $membershipPlan->update($request->all());

        return redirect()->route('membership-plans.index')->with('success', 'Membership plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->delete();

        return redirect()->route('membership-plans.index')->with('success', 'Membership plan deleted successfully');
    }

    /**
     * Check if the membership plan can be deleted.
     */
    public function canDelete(MembershipPlan $membershipPlan)
    {
        $inUse = Member::where('membership_plan_id', $membershipPlan->id)->exists();

        return response()->json([
            'inUse' => $inUse,
        ]);
    }
}
