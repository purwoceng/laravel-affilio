<?php

namespace App\Models;

use App\Models\NotificationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'member_type_id',
        'title',
        'description',
        'creator_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function notifications_status()
    {
        return $this->belongsTo(NotificationStatus::class, 'notification_id', 'id')->withTrashed();
    }
}
