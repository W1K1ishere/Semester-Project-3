<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /** @use HasFactory<\Database\Factories\TableFactory> */
    use HasFactory;

    protected $fillable = [
    'desk_mac',
    'current_height',
    'department_id'
];

    public function users()
    {
        return $this->belongsToMany(User::class, 'is_assigned', 'id', 'id');
    }
}
