<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'height',
        'weight',
        'membership_plan_id',
        'start_date',
        'end_date',
        'active',
    ];

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function scopeActiveMembers($query)
    {
        return $query->where('start_date', '<=', now())->where('end_date', '>=', now());
    }

    public function scopeExpiringMembers($query)
    {
        return $this->activeMembers()->whereRaw('DATEDIFF(end_date, NOW()) < ?', [7])->orderBy('end_date', 'asc');
    }
}
