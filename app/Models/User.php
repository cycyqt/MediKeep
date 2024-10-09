<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\UserStatusNotification;
use App\Notifications\RegistrationNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["staff", "admin", "superadmin"][$value]
        );
    }

    /**
     * Boot method to add model event listeners.
     */
    protected static function boot()
    {
        parent::boot();
    
        static::created(function ($user) {
            $user->notify(new UserStatusNotification(null, 'created'));
    
            // Notify the superadmin when someone wants to register an account
            $superadminEmail = config('mail.superadmin_email');
            $superadmin = User::where('email', $superadminEmail)->first();
            if ($superadmin) {
                $superadmin->notify(new RegistrationNotification($user));
            }
        });
    
        static::updating(function ($user) {
            // Check if the user's role has been updated
            if ($user->isDirty('role')) {
                if ($user->role === 'superadmin') {
                    // Notify the user that they are now a superadmin
                    $user->notify(new SuperAdminAssignedNotification($user));
                }
            }
    
            // Handle status changes
            if ($user->isDirty('status')) {
                if ($user->status === 'rejected') {
                    $user->delete();
                } elseif (in_array($user->status, ['approved', 'pending'])) {
                    $user->notify(new UserStatusNotification($user->status, 'status'));
                }
            }
        });
        
        static::deleting(function ($user) {
            if (!$user->isForceDeleting()) {
                if ($user->status !== 'disabled') {
                    $user->status = 'disabled';
                    $user->save();
                    $user->notify(new UserStatusNotification(null, 'archived'));
                }
            } else {
                $user->notify(new UserStatusNotification(null, 'deleted'));
            }
        });
    
        static::restoring(function ($user) {
            $user->status = 'pending';
            $user->save();
            $user->notify(new UserStatusNotification(null, 'restored'));
        });
    }
}