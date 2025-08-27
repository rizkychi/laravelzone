<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'route_name',
        'action',
        'method',
        'uri',
        'is_active',
        'permission_name'
    ];

    public function scopeOnlyIndex($q)
    {
        return $q->where(function ($qq) {
            $qq->whereNotNull('route_name')->where('route_name', 'like', '%.index')
            ->orWhere(function ($qqq) {
                $qqq->whereNotNull('action')->where('action', 'like', '%@index');
            });
        });
    }

}
