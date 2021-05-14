@extends('main.main')
@section('body')
    <div class="banner full" style="background-image: url({{ $feed->getImageUrl() }})"></div>
    <div class="page-wrapper">
        <div class="feed-wrapper">
            <h1>{{ $feed->title }} <a href="{{ route('unsubscribe', $feed->id) }}">Unsubscribe From Feed</a></h1>
            <div class="flex">
                <div class="box-component feed-feeds">
                    @foreach ($feed->getPosts() as $post)
                        <div class="feed-post">
                            <h2>{{ $post->title }}</h2>
                            <p>{{ $post->description }}</p>
                            <p>Read more:
                                <a href="{{ route('feed_post', [$feed->id, str_replace('/', '|', $post->link)]) }}" target="_blank">{{ $post->link }}</a>
                            </p>
                            <div class="feed-post-read-status">
                                {!! array_key_exists((string) $post->link, $read_feeds)
                                    ? '<span class="read">Read</span>'
                                    : '<span class="unread">Unread</span>'
                                !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="feed-content">
                    <div class="box-component">
                        <h2>Description</h2>
                        <p>{{ $feed->description }}</p>
                        <p>Would you like to subscribe to this feed yourself? <a href="{{ $feed->feed_url }}" target="_blank">{{ $feed->feed_url }}</a></p>
                        <h2>Other Feeds</h2>
                        @foreach(Auth::user()->feeds as $feed)
                            <a href="{{ route('feed', $feed->id) }}" class="feed-link">
                                <div class="flex feed flex-middle">
                                    <div class="feed-image"
                                         style="background-image: url({{ $feed->getImageUrl() }})"></div>
                                    <div class="feed-info">
                                        <h3>{{ $feed->title }}</h3>
                                        <p>{{ $feed->description }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        <a class="margin-top" href="{{ route('dashboard') }}">View all Feeds</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
