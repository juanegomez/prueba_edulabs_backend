<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id',
    ];

    //Relación con la tabla de categories
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    //Relación con la tabla de users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * filtrar por category_id y ordenar por fecha.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId)
            ->orderBy('created_at', 'desc');
    }
}