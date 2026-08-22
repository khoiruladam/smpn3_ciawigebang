<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SskStat extends Model
{
    protected $fillable = ['icon', 'label', 'value', 'suffix', 'decimals', 'sub', 'sort_order'];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
        ];
    }
}