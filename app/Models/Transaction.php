<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'sender_id',
        'receiver_id',
        'amount',
        'balance',
        'type',
        'description',
    ];

    protected $appends = ["created_date"]; 

    public function getCreatedDateAttribute() {
        $createdAt = Carbon::parse($this->created_at);
        return $createdAt->format('M d Y');
    }
}