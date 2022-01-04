<?php

return [
    'url' => [
        'api' => env('SPOTIFY_API_URL'),
        'authorize' => env('SPOTIFY_AUTHORIZE_URL'),
        'callback' => env('SPOTIFY_CALLBACK_URL'),
        'base_url_callback' => "https://accounts.spotify.com/authorize?client_id=62f3ae5b23e04e028381423fc0bc12b2&response_type=token&redirect_uri=",
        'permissions_array' => "&token_type=Bearer&expires_in=3600&state=123&scope=user-read-recently-played user-read-playback-position user-read-email user-library-read user-top-read playlist-modify-public ugc-image-upload user-follow-modify user-modify-playback-state user-read-private playlist-read-private user-library-modify playlist-read-collaborative playlist-modify-private user-follow-read user-read-playback-state user-read-currently-playing",
    ],
];
