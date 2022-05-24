<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

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
