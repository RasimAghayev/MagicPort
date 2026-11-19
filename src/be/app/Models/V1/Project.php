<?php

namespace App\Models\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'status' => 'string',
    ];

    protected $fillable = [
        'code',
        'name',
        'description',
        'company_code',
        'user_id',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_code', 'code');
    }
}
