<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipPlan;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $recent_members = Member::activeMembers()->with('membershipPlan')->latest()->take(5)->get();
        $plan_subscribers = MembershipPlan::withSubscriberStats()->orderBy('total_subscribers', 'desc')->take(5)->get();
        $expiring_members = Member::expiringMembers()->with('membershipPlan')->take(5)->get();

        return Inertia::render('Dashboard', [
            'recentMembers' => $recent_members,
            'planSubscribers' => $plan_subscribers,
            'expiringMembers' => $expiring_members,
        ]);
    }
}
