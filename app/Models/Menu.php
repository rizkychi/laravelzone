<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'route_name',
        'url',
        'parent_id',
        'order',
        'is_active',
        'is_system',
        'permission_name'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    protected static function booted()
    {
        static::saved(fn() => \App\Services\MenuTreeService::bustAll());
        static::deleted(fn() => \App\Services\MenuTreeService::bustAll());
    }
}
