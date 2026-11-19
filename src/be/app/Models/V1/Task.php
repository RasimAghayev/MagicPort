<?php

namespace App\Models\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'status' => 'string',
        'due_date' => 'date',
    ];

    protected $fillable = [
        'code',
        'title',
        'description',
        'project_code',
        'user_id',
        'status',
        'due_date',
        'priority',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
