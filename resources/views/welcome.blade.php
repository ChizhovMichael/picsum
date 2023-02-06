<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Project</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet"></link>

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div>
                        <div class="p-6" id="Image">
                            <div>
                                <img src="/img/default.jpg" alt="image" class="w-100 rounded-lg image-cover" height="200" id="js-image">
                            </div>
                            <div class="flex items-center mt-8 justify-between">
                                <button type="button" class="rounded-lg py-4 px-6 bg-secondary text-white" id="js-image-cancel" data-status="false">Cancel</button>
                                <button type="button" class="rounded-lg py-4 px-6 bg-primary text-white" id="js-image-accept" data-status="true">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ URL::asset('js/app.js') }}"></script>
</html>
