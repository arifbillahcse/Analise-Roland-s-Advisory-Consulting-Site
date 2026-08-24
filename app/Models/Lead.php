<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_CONTACTED = 'contacted';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'name',
        'email',
        'company',
        'message',
        'source',
        'status',
        'ip_address',
        'user_agent',
    ];
}
