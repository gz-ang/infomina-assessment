<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPlan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'price',
        'validity_type',
        'validity',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function scopeWithSubscriberStats($query)
    {
        return $query->withCount([
            'members as total_subscribers',
            'members as active_subscribers' => function ($q) {
                $q->whereRaw('NOW() BETWEEN start_date AND end_date');
            },
        ]);
    }
}
