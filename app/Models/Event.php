<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Workshop;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = ['name'];
    public $timestamps = ['created_at', 'updated_at'];

    public function workshops()
    {
        return $this->hasMany(Workshop::class, 'event_id', 'id');
    }
}
