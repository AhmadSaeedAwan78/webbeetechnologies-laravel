<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Workshop extends Model
{

    protected $table = 'workshops';
    protected $fillable = ['start', 'end', 'event_id', 'name'];    
    public $timestamps = ['created_at', 'updated_at'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
