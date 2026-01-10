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
}
