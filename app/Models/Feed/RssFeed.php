<?php

namespace App\Models\Feed;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RssFeed extends Model
{
    use HasFactory;

    protected $table = 'rss_feed';

    protected $fillable = [
        'user_id',
        'feed_url',
        'title',
        'description',
        'image',
        'items'
    ];

    protected $casts = [
        'user_id'     => 'integer',
        'feed_url'    => 'string',
        'title'       => 'string',
        'description' => 'string',
        'image'       => 'string',
        'items'       => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime'
    ];

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Getters
    |-------------------------------------------------------------------------------------------------------------------
    | The methods from this point are dedicated for helper methods for interacting with RssFeeds.
    |
    */

    /**
    * @return string
    */
    public function getImageUrl(): string
    {
        return $this->image === ''
            ? asset('assets/images/placeholder-feed.png')
            : $this->image;
    }

    /**
    * we are going to trust that this is always going to be returning an array, due to the fact that you can only
    * enter valid rss links...
    *
    * @return array
    */
    public function getPosts()
    {
        return (simplexml_load_file($this->feed_url))->channel->item;
    }

    /**
    * This method would be more optimal providing you have loaded the relationship, otherwise this is going to
    * attempt to load it itself.
    *
    * @return string
    */
    public function getPostsRead(): string
    {
        return collect(explode(',', $this->feed_view_log->read_items))->filter(function ($post) {
            return $post !== '';
        })->count() . "/$this->items";
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------------------------------------------------
    | The information from this point on will 100% be around the relationships that this specific model has. In this
    | specific instance: the RssFeed
    |
    */

    /**
    * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
    * @return HasOne
    */
    public function feed_view_log(): HasOne
    {
        return $this->hasOne(RssFeedViewLog::class, 'feed_id', 'id');
    }
}
