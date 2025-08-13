<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use TomatoPHP\FilamentLanguageSwitcher\Traits\InteractsWithLanguages;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use InteractsWithLanguages;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'telegram_user_id',
        'telegram_chat_id',
        'telegram_username',
        'telegram_avatar_url',
        'telegram_connect_token',
        'locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->telegram_connect_token)) {
                $user->telegram_connect_token = Str::uuid();
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isSuperAdmin();
        }

        return true;
    }
    /**
     * Check if the user is a super admin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function routeNotificationForTelegram()
    {
        return $this->telegram_chat_id;
    }
}
