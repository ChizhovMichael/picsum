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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 w-100">
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <h3 class="dark:text-gray-400">Photos</h3>
                <table class="w-100">
                    <thead>
                        <tr class="dark:text-gray-400 ">
                            <th>ID</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="Table"></tbody>
                </table>

            </div>
        </div>
    </div>
</body>
<script src="{{ URL::asset('js/app.js') }}"></script>
</html>
