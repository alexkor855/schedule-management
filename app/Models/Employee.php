<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public function branchEmployees(): HasMany
    {
        return $this->hasMany(BranchEmployee::class, 'employee_id', 'id');
    }
}
