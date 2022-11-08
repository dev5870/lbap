<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\SystemNotice
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemNotice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemNotice extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'title',
        'description',
    ];

    public $sortable = [
        'id',
    ];
}
