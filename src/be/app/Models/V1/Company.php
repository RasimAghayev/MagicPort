<?php

namespace App\Models\V1;

use App\Enums\DefaultStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method findOrFail(int $id)
 * @method where(array string $string, $userId)
 * @method create(array $companyData)
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';
    protected $casts = [
        'status' => DefaultStatus::class,
    ];
    protected $guarded = [];
    protected $fillable = [
        "user_id",
        "name",
        "status",
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status')
            ->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
