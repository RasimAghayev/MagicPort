<?php

namespace App\Models\V1;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'amount'       => 'decimal:2',
        'tax_amount'   => 'decimal:2',
        'total_amount' => 'decimal:2',
        'issued_at'    => 'date',
        'due_date'     => 'date',
        'paid_at'      => 'date',
        'deleted_at'   => 'datetime',
    ];

    protected $fillable = [
        'code',
        'invoice_number',
        'company_code',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'issued_at',
        'due_date',
        'paid_at',
        'notes',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_code', 'code');
    }
}
