<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','type','description'];
    protected $guarded = [];
    public static function createLog($type, $description)
    {
        $activity = new Activity();
        $activity->user_id = Auth::id();
        $activity->type = $type;
        $activity->description = $description;
        $activity->save();

        $user = Auth::user();
        $user->last_action_at = now();
        $user->save();
    }
}
