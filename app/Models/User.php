<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /**
     * For the UUID
     */
    use HasUuids;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'user_id';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nickname',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Relationship with the read_history table
     * 
     * @return HasMany
     */
    public function history(): HasMany
    {
        return $this->hasMany(ReadHistory::class,'read_history_user');
    }

    /**
     * Relation with the Works table
     * 
     * @return HasMany
     */
    public function work(): HasMany
    {
        return $this->hasMany(Works::class,'work_author');
    }

    /**
     * Relation with the readlist table
     * @return HasMany<ReadLists, User>
     */
    public function readList():HasMany
    {
        return $this->hasMany(ReadLists::class,'read_list_user');
    }

    /**
     * Relationship with the comment table
     * 
     * @return HasMany
     */
    public function comment(): HasMany
    {
        return $this->hasMany(Comments::class,'comment_user');
    }

    /**
     * Relation with the collections table
     * 
     * 
     * @return HasMany<Collections, User>
     */
    public function collection():HasMany
    {
        return $this->hasMany(Collections::class,'collection_user');
    }

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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
}
