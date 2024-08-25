<?php

namespace App\Models\V1;

use app\Enums\DefaultStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static findOrFail($id)
 * @method static create(array $all)
 * @property mixed $id
 */
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';
    protected $casts = [
        'status' => DefaultStatus::class,
    ];
    protected $guarded = [];
    protected $fillable = [
        "company_id",
        "user_id",
        "name",
        "description",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
