<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>

    <!--FOR THE WEBCAM-->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="{{ mix('js/event/clock.js')}}" type="text/javascript" defer></script>
    <script src="{{ mix('js/event/main.js')}}" type="text/javascript" defer></script>

    <!--FOR THE CSS-->
    <link rel="stylesheet" href="{{ mix('css/event.css')}}">
</head>

<body>
<nav>
    <a href="{{ route("dashboard") }}" class="ihms-navbar" id="hover"><h1 class="ihms-navbar-h1"><b>{{ $event->title }}
                |
                Passifi</b>
        </h1></a>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>

<div class="main" id="main">
    <div class="main-1-1">
        <video id="preview" width="100%" autoplay></video>
    </div>

    <div class="main-1-2">
        <div id="clock">00:00 AM</div>
        <p class="main-1-2-p1">Scan the User QR Code</p><br>
        <form>
            <input type="text" name="text" rows="3" cols="30" id="comment" readonly=""
                   placeholder="Scan User QR Code in front of the camera." class="form-control">
            <br>
        </form>

        <p><b>NOTE: </b> User QR Code is found at ...</p><br>
        <div>
            <hr>
            <h4 class="header">ATTENDANCE STATUS</h4>
            <div id="comments"></div>
        </div>
    </div>
</div>
</body>
</html>
