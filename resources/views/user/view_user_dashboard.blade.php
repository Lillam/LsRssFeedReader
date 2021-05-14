@extends('main.main')
@section('js')
    <script src="{{ asset('assets/vendor/chart/chart.js') }}"></script>
@endsection
@section('body')
    <div class="page-wrapper">
        <div class="flex flex-collapse">
            <div class="rss-feeds">
                <div class="flex flex-middle flex-collapse">
                    <div class="full-width">
                        <h2 class="welcome">Hi, {{ $user->username }}, Here are your feeds</h2>
                    </div>
                    <div class="search">
                        <form method="get" action="{{ route('subscribe') }}">
                            @csrf
                            <div class="flex">
                                <input type="text" placeholder="Feed Url..." name="feed_url" />
                                <button type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-component">
                    @foreach ($user->feeds as $feed_key => $feed)
                        <a href="{{ route('feed', $feed->id) }}" class="feed-link">
                            <div class="flex feed flex-middle">
                                <div class="feed-image"
                                     style="background-image: url({{ $feed->getImageUrl() }})">
                                    <span class="feeds-read">{{ $feed->getPostsRead() }}</span>
                                </div>
                                <div class="feed-info">
                                    <h3>{{ $feed->title }} <span>Added: {{ $feed->created_at->format('jS F Y') }}</span></h3>
                                    <p>{{ $feed->description }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    @if ($user->feeds->isEmpty())
                        <p>Why not begin subscribing to some feeds?</p>
                    @endif
                </div>
            </div>
            <div class="rss-feeds-statistics">
                <h2 class="welcome">Statistics</h2>
                <div class="box-component">
                    @if ($user->feeds->isEmpty())
                        <p>Begin subscribing to feeds in order to get some statistics.</p>
                    @endif
                    @if ($user->feeds->isNotEmpty())
                        <canvas class="feed_stats"
                                width="100vh"
                                height="50vh"
                                data-total_posts="{{ $total_posts }}"
                                data-total_posts_read="{{ $total_posts_read }}"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
