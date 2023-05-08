<?php

namespace App\Models;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications_status';

    protected $fillable = [
        'id',
        'member_id',
        'notification_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','notification_id');
    }
}
