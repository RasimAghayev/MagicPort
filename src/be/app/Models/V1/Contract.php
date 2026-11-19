<?php

namespace App\Models\V1;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contracts';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'value'     => 'decimal:2',
        'start_date'=> 'date',
        'end_date'  => 'date',
        'signed_at' => 'date',
        'deleted_at'=> 'datetime',
    ];

    protected $fillable = [
        'code',
        'contract_number',
        'company_code',
        'title',
        'description',
        'start_date',
        'end_date',
        'value',
        'status',
        'signed_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }
}
