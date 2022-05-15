<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Enums\UserRole;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Sortable;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telegram',
        'referrer',
        'comment',
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

    public $sortable = [
        'id',
        'email',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            try {
                Role::findByName(UserRole::USER, 'web');
            } catch (\Exception $e) {
                throw new NotFoundHttpException('Role not found');
            }
        });

        self::created(function ($model) {
            $model->assignRole(UserRole::USER);
        });
    }

    public function logs(): HasMany
    {
        return $this->hasMany(UserUserAgent::class, 'user_id', 'id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(UserReferral::class, 'user_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'fileable_id', 'id')->where('fileable_type', '=', 'App\Models\User');
    }
}
