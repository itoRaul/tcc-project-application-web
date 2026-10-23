<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'device_id',
        'alert_type',
        'message',
        'is_resolved',
        'created_at',
        'update_at',
    ];

    public function reading()
    {
        return $this->belongsTo(Reading::class);
    }
}