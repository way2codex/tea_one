<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'entry_master';
    protected $guarded = [];

    public function customer()
    {
        return $this->hasOne(CustomerMaster::class, 'id', 'customer_id');
    }
}
