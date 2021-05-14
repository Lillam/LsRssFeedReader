<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | 404 Not Found</title>
        <link href="{{ asset('assets/css/application.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body class="error error-404 flex flex-full flex-center">
        <div class="error-message full-width">
            <div>
                <h1>Error <span>404</span></h1>
                <p>The page you are looking for does not exist... are you sure you clicked on the right link?</p>
                <a href="{{ url()->previous() }}">Back</a>
            </div>
        </div>
    </body>
</html>
