<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customer_master';
    protected $guarded = [];

    public function entry()
    {
        return $this->hasMany(EntryMaster::class, 'customer_id', 'id');
    }
}
