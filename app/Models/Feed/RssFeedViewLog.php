<?php

namespace App\Models\Feed;

use App\Models\User\User;
use App\Models\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RssFeedViewLog extends Model
{
    use HasFactory, CompositeKey;

    /**
    * @var string
    */
    protected $table = 'rss_feed_view_log';

    /**
    * @var string[]
    */
    protected $primaryKey = ['feed_id', 'user_id'];

    /**
    * @var bool
    */
    public $incrementing = false;

    /**
    * @var string[]
    */
    protected $fillable = [
        'feed_id',
        'user_id',
        'views',
        'items',
        'read_items'
    ];

    /**
    * @var string[]
    */
    protected $casts = [
        'feed_id'    => 'integer',
        'user_id'    => 'integer',
        'views'      => 'integer',
        'items'      => 'integer',
        'read_items' => 'string'
    ];

    /**
    * @var bool
    */
    public $timestamps = false;

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------------------------------------------------
    | The information from this point on will 100% be around the relationships that this specific model has. In this
    | specific instance: the RssFeedViewLog
    |
    */

    /**
    * @return BelongsTo
    */
    public function feed(): BelongsTo
    {
        return $this->belongsTo(RssFeed::class, 'feed_id', 'id');
    }

    /**
    * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
