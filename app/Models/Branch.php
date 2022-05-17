<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public function workplaces(): HasMany
    {
        return $this->hasMany(Workplace::class, 'branch_id', 'id');
    }

    public function branchServices(): HasMany
    {
        return $this->hasMany(BranchService::class, 'branch_id', 'id');
    }

    public function branchEmployees(): HasMany
    {
        return $this->hasMany(BranchEmployee::class, 'branch_id', 'id');
    }

    public function serviceWorkplaces(): HasMany
    {
        return $this->hasMany(ServiceWorkplace::class, 'branch_id', 'id');
    }

    public function serviceEmployees(): HasMany
    {
        return $this->hasMany(ServiceEmployee::class, 'branch_id', 'id');
    }
}
