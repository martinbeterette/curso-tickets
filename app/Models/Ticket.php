<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'support_id',
        'description',
        'status',
    ];

    //Relacion con Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //Relacion con Support
    public function support()
    {
        return $this->belongsTo(Support::class, 'support_id');
    }
}
