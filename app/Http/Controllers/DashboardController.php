<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $recent_members = Member::activeMembers()->with('membershipPlan')->latest()->take(5)->get();
        $plan_subscribers = MembershipPlan::withSubscriberStats()->orderBy('total_subscribers', 'desc')->take(5)->get();
        $expiring_members = Member::expiringMembers()->with('membershipPlan')->take(5)->get();

        return Inertia::render('Dashboard', [
            'recent_members' => $recent_members,
            'plan_subscribers' => $plan_subscribers,
            'expiring_members' => $expiring_members,
        ]);
    }
}
