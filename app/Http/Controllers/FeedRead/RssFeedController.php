<?php

namespace App\Http\Controllers\FeedRead;

use Exception;
use App\Models\Feed\RssFeed;
use Illuminate\Http\Request;
use App\Models\Feed\RssFeedViewLog;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Foundation\Application;

class RssFeedController extends Controller
{
    /**
    * @param Request $request
    * @return RedirectResponse
    * @throws ValidationException
    */
    public function _subscribeToRssFeed(Request $request): RedirectResponse
    {
        $this->validate($request, [ 'feed_url' => 'required|unique:rss_feed' ]);

        try {
            $feeds = simplexml_load_file($rss_feed_url = $request->input('feed_url'));
            $feed_channel = $feeds->channel;
            $feed_title = $feed_channel->title ?? '';
            $feed_description = $feed_channel->description ?? '';
            $feed_image = $feed_channel->image->url ?? '';

            $rss_feed = RssFeed::create([
                'user_id'     => $auth_id = Auth::id(),
                'feed_url'    => $rss_feed_url,
                'title'       => $feed_title,
                'description' => $feed_description,
                'image'       => $feed_image,
                'items'       => count($feed_channel->item) ?? 0
            ]);

            RssFeedViewLog::create([
                'user_id'    => $auth_id,
                'feed_id'    => $rss_feed->id,
                'items'      => $rss_feed->items,
                'views'      => 0,
                'read_items' => null
            ]);
        } catch (Exception $exception) {
            Session::flash('message', 'Please provide a valid rss source');
        }

        return back();
    }

    /**
    * @param Request $request
    * @param RssFeed $feed
    * @return RedirectResponse
    */
    public function _unsubscribeFromRssFeed(Request $request, RssFeed $feed): RedirectResponse
    {
        $feed->delete();
        return redirect()->route('dashboard');
    }

    /**
    * @param Request $request
    * @param RssFeed $feed
    * @return Application|Factory|View
    */
    public function _viewRssFeed(Request $request, RssFeed $feed): Application|Factory|View
    {
        $this->vs->setTitle("Feeds | {$feed->title}");

        Auth::user()->load([
            'feeds' => function($query) use ($feed) {
                $query->where('id', '!=', $feed->id)
                      ->limit(3);
            },
            'feed_view_log' => function($query) use ($feed) {
                $query->where('feed_id', '=', $feed->id);
            }
        ]);

        $read_feeds = array_flip(explode(',', Auth::user()->feed_view_log->read_items));

        Auth::user()->feed_view_log->increment('views');

        return view('feed.view_rss_feed', compact(
            'feed',
            'read_feeds'
        ));
    }

    /**
    * @param Request $request
    * @param RssFeed $feed  this is for the specific post, so we can grab the accurate feed log.
    * @param string $feed_post_url  this will be passed in with the slashes replaced for pipes, and converted back.
    * @return RedirectResponse
    */
    public function _viewRssFeedPost(Request $request, RssFeed $feed, string $feed_post_url): RedirectResponse
    {
        // reconvert the url back to normal (this was necessary to get it into the parameter, as it was reading it
        // as a directive utilising "/" - but now we need it back as a use-able url.
        $feed_post_url = str_replace('|', '/', $feed_post_url);

        ($user = Auth::user())->load(['feed_view_log' => function($query) use ($feed) {
            $query->where('feed_id', '=', $feed->id);
        }]);

        // convert this to an array so we can see if the item already exists, and if not, we're going to append and
        // then transform back to being a string (this is super inefficient but super quick to code).
        $read_articles = $user->feed_view_log->read_items !== null
            ? explode(',', $user->feed_view_log->read_items)
            : [];

        // over time this will get super slow... especially the bigger the string value is. ( we could alternatively
        // use a json field in the database ).
        if (! in_array($feed_post_url, $read_articles))
            $read_articles[] = $feed_post_url;

        // put the array back into a string... so we can utilise this later, this is just a check to see whether or not
        // we can add the particular read post into the array...
        $user->feed_view_log->read_items = implode(',', $read_articles);
        $user->feed_view_log->save();

        return redirect($feed_post_url);
    }
}
