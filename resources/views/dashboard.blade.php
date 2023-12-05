<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Dashboard | Passifi</title>
</head>

<body>
    <section class="header">
        <div class="logo">
            <img src="{{ asset('images/passifi-logo.png') }}" alt="" class="passifi-logo">
        </div>
        <div class="search--notification--profile">
            <div class="search">
                <input type="text" placeholder="Search Event">
                <button><i class="ri-search-2-line"></i></button>
            </div>
            <div class="notification--profile">
                <div class="picon profile">
                    <i class="ri-account-circle-fill"></i>
                </div>
            </div>
        </div>
    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="#" id="active--link">
                        <span class="icon"><i class="ri-layout-grid-line"></i></span>
                        <span class="sidebar--item">Dashboard</span>
                    </a>
                </li>
                    <a href="{{ route('activity') }}">
                        <span class="icon"><i class="ri-line-chart-line"></i></span>
                        <span class="sidebar--item">Activity</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('support')}}">
                        <span class="icon"><i class="ri-customer-service-line"></i></span>
                        <span class="sidebar--item">Support</span>
                    </a>
                </li>
            </ul>
            <ul class="sidebar--bottom-items">
                <li>
                    <a href="{{ route('settings') }}">
                        <span class="icon"><i class="ri-settings-3-line"></i></span>
                        <span class="sidebar--item">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('signup')}}">
                        <span class="icon"><i class="ri-logout-box-r-line"></i></span>
                        <span class="sidebar--item">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main--content">
            <div class="overview">
                <div class="title">
                    <h1 class="section--title">EVENTS</h1>
                    <div class="events--right--btns">
                        <select name="date" id="date" class="dropdown">
                            <option value="today">Today</option>
                            <option value="future">Future</option>
                            <option value="past">Past</option>
                            <option value="alltime">All</option>
                        </select>
                        <button class="add"><i class="ri-add-line"></i>Add Event</button>
                    </div>
                </div>
                <div class="cards">
                    <div class="card card-1">
                        <div class="card--data">
                            <div class="card--content">
                                <img src="{{ asset('images/conference-img.jpg') }}" alt="" class="card--img">
                                <h1 class="card--title">EVENT NAME</h1>
                                <h5>ATTENDEES</h5>
                                <h1>- / n</h1>
                            </div>
                        </div>
                        <div class="card--stats">
                            <span><i class="ri-calendar-2-fill card--icon stat--icon"></i>DD/MM/YYYY</span>
                            <span><i class="ri-map-pin-2-fill card--icon map--pin"></i>LOCATION</span>
                        </div>
                    </div>
                    <div class="card card-1">
                        <div class="card--data">
                            <div class="card--content">
                                <img src="{{ asset('images/conference-img.jpg') }}" alt="" class="card--img">
                                <h1 class="card--title">EVENT NAME</h1>
                                <h5>ATTENDEES</h5>
                                <h1>- / n</h1>
                            </div>
                        </div>
                        <div class="card--stats">
                            <span><i class="ri-calendar-2-fill card--icon stat--icon"></i>DD/MM/YYYY</span>
                            <span><i class="ri-map-pin-2-fill card--icon map--pin"></i>LOCATION</span>
                        </div>
                    </div>
                    <div class="card card-1">
                        <div class="card--data">
                            <div class="card--content">
                                <img src="{{ asset('images/conference-img.jpg') }}" alt="" class="card--img">
                                <h1 class="card--title">EVENT NAME</h1>
                                <h5>ATTENDEES</h5>
                                <h1>- / n</h1>
                             </div>
                        </div>
                        <div class="card--stats">
                            <span><i class="ri-calendar-2-fill card--icon stat--icon"></i>DD/MM/YYYY</span>
                            <span><i class="ri-map-pin-2-fill card--icon map--pin"></i>LOCATION</span>
                        </div>
                    </div>
                    <div class="card card-1">
                        <div class="card--data">
                            <div class="card--content">
                                <img src="{{ asset('images/conference-img.jpg') }}" alt="" class="card--img">
                                <h1 class="card--title">EVENT NAME</h1>
                                <h5>ATTENDEES</h5>
                                <h1>- / n</h1>
                            </div>
                        </div>
                        <div class="card--stats">
                            <span><i class="ri-calendar-2-fill card--icon stat--icon"></i>DD/MM/YYYY</span>
                            <span><i class="ri-map-pin-2-fill card--icon map--pin"></i>LOCATION</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/dashboard/main.js') }}"></script>
</body>

</html>