<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Statistics</title>

    <!-- Styles -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href='{{ asset('css/statistics.css') }}'>
    <script src="{{ mix('js/statistics.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    @include('partials._header')
    <section class="main">
        @include('partials._sidebar')
        <div class="main--content">
            <div class="overview">
                <div class="recent--events">
                    <div class="title">
                        <h2 class="section--title">STATISTICS | Completed Events</h2>
                    </div>
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Organizer</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>No. of Guests</th>
                                    <th>No. Attended</th>
                                    <th>% of Attendees</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->title  }}</td>
                                    <td>{{ $event->organizer  }}</td>
                                    <td>{{ $event->date  }}</td>
                                    <td>{{ $event->time  }}</td>
                                    <td>{{ $event->capacity  }}</td>
                                    <td>{{ $event->attendees_count  }}</td>
                                    <td>-</td>
                                    <td>
                                        <button class="print-button">Print</button>
                                        <button class="delete-button">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</body>
