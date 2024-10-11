<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\UserStatusNotification;
use App\Notifications\RegistrationNotification;
use App\Notifications\SuperAdminAssignedNotification;
use Attribute;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    const ROLE_STAFF = 1;
    const ROLE_ADMIN = 2;
    const ROLE_SUPERADMIN = 3;

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
        'role',
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
            $notifications = [];
    
            $notifications[] = new UserStatusNotification(null, 'created');
    
            $superadminEmail = config('mail.superadmin_email');
            $superadmin = User::where('email', $superadminEmail)->first();
            if ($superadmin && $user->email !== $superadminEmail) {
                $superadmin->notify(new RegistrationNotification($user));
            }
    
            foreach ($notifications as $notification) {
                $user->notify($notification);
            }
        });
    
        static::updating(function ($user) {
            $notifications = [];
    
            if ($user->isDirty('status')) {
                if ($user->status === 'rejected') {
                    $user->delete();
                } elseif (in_array($user->status, ['approved', 'pending'])) {
                    $notifications[] = new UserStatusNotification($user->status, 'status');
                }
            }
    
            // if ($user->isDirty('role') && $user->role === 'superadmin') {
            //     $notifications[] = new SuperAdminAssignedNotification($user);
            // }
    
            foreach ($notifications as $notification) {
                $user->notify($notification);
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

    public function assignRole(string $role)
    {
        $this->role = $role;
        $this->save();

        if ($role === 'superadmin') {
            $this->notify(new SuperAdminAssignedNotification($this));
        }
    }
}