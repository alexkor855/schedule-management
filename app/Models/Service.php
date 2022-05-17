<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public function branchServices(): HasMany
    {
        return $this->hasMany(BranchService::class, 'service_id', 'id');
    }
}
