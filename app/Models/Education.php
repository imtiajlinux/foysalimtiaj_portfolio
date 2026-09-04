<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'institution',
        'degree',
        'field_of_study',
        'location',
        'start_date',
        'end_date',
        'currently_studying',
        'grade',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'currently_studying' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
