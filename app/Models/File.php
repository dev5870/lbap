<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;

class File extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'file_name',
        'fileable_id',
        'fileable_type',
    ];

    public $sortable = [
        'id',
        'created_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'fileable_id');
    }
}
