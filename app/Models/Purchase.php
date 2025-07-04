<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'supplier_name', 'description', 'quantity', 'total_amount', 'purchase_date'];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (auth()->check()) {
                $query->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}

