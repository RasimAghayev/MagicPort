<?php

namespace App\Models;

use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'description',
        'company_code',
        'project_code',
        'user_id',
        'status',
        'due_date',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'date',
        'priority' => 'integer',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
