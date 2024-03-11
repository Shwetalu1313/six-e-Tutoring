<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\BrowserInfoFactory;
use Illuminate\Http\Request;

class BrowserInfo extends Model
{
    use HasFactory;
    protected $fillable = ['browser','ip','user_id'];
    protected $factory = BrowserInfoFactory::class;

    public static function createRecord($id, $ip, $browser)
    {
        $browserInfo = new BrowserInfo();
        $browserInfo->user_id = $id;
        $browserInfo->ip = $ip;
        $browserInfo->browser = $browser;
        $browserInfo->save();
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
