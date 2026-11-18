<?php

namespace App\Models\V1;

use App\Enums\V1\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';
    protected $casts = [
        'status' => TaskStatus::class,
    ];
    protected $guarded = [];
    protected $fillable = [
        "company_id",
        "user_id",
        "project_id",
        "name",
        "description",
        "status",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
