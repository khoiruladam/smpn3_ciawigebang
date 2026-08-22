<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'is_anonymous',
        'message',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function displayName(): string
    {
        return $this->is_anonymous || !$this->name ? 'Anonim' : $this->name;
    }
}