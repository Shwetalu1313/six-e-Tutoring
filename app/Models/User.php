<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_action_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function tutor()
    {
        return $this->belongsTo(User::class, 'current_tutor');
    }
    public function students()
    {
        return $this->hasMany(User::class, 'current_tutor');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function waitingSchedules(): HasMany
    {
        return $this->schedules()->where('expired', false)->orderBy('date');
    }

    public function scheduleUsers(): HasMany
    {
        return $this->hasMany(ScheduleUser::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function myShareSchedules(): HasMany
    {
        return $this->scheduleUsers()->where('owner_id', Auth::id())->orderBy('created_at');
    }
    public function BrowserInfo(): HasMany
    {
        return $this->hasMany(BrowserInfo::class);
    }
}
