<?php

namespace App\Models;

use App\Models\AuditLog;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
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
        'start_date',
        'end_date',
        'budget',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_code', 'code');
    }

    public function auditLogs(): HasMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
