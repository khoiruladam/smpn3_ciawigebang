<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SskDemographic extends Model
{
    protected $fillable = ['kelas', 'male_count', 'female_count', 'sort_order'];
}