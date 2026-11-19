<?php

namespace App\Models;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'established_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'established_at' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'company_code', 'code');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'company_code', 'code');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_code', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function auditLogs(): HasMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
