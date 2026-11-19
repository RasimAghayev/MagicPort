<?php

namespace App\Models\V1;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'resolved_at' => 'date',
        'closed_at'   => 'date',
        'deleted_at'  => 'datetime',
    ];

    protected $fillable = [
        'code',
        'ticket_number',
        'company_code',
        'user_id',
        'subject',
        'description',
        'priority',
        'status',
        'resolved_at',
        'closed_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
