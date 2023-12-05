<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>

    <!--FOR THE WEBCAM-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://github.com/schmich/instascan/releases/download/1.0.0/instascan.min.js"></script>
    <!--<script src="script.js"></script>-->
    <!--FOR THE DATABASE-->
    <script src="https://cdn.firebase.com/js/client/2.4.0/firebase.js"></script>

    <!--FOR THE CSS-->
    <link rel="stylesheet" href="{{ asset('css/event.css')}}">
</head>

<body>
  <nav>
    <a href="index.html" class="ihms-navbar" id="hover"><h1 class="ihms-navbar-h1"><b>Event Name | passifi</b></h1></a>
    <div class="burger">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
  </nav>

    <div class="main" id="main">
            <div class="main-1-1">
                <video id="preview" width="100%"></video>
            </div>

            <div class="main-1-2">
        <div id="clock">00:00 AM</div>
                <p class="main-1-2-p1">Scan the DIC QR Code</p><br>
        <!-- <form action="#" onsubmit="event.preventDefault(); postComment()">
                  <input type="text" name="text" rows="3" cols="30" id="comment" readonly="" placeholder="Scan the DIC in front of the camera." class="form-control"><br>
        </form> -->
        <form 
            method="post"
            action="https://sheetdb.io/api/v1/rxkwzdnr7nedb"
            id="sheetdb-form">
            <input type="text" name="text" rows="3" cols="30" id="comment" readonly="" placeholder="Scan the DIC in front of the camera." class="form-control">
            <br>
            <input name="data[id-field]" type="hidden" id="id-field">
            <input name="data[f_nm]" type="hidden" id="f_nm">
            <input name="data[m_nm]" type="hidden" id="m_nm">
            <input name="data[l_nm]" type="hidden" id="l_nm">
            <input name="data[yr_lvl]" type="hidden" id="yr_lvl">
            <input name="data[current_time]" type="hidden" id="current_time">
            <input name="data[current_date]" type="hidden" id="current_date">
        </form>
        
        <p><b>NOTE: </b> DIC stands for Digital Identification Card.</p><br>
        <div>
          <hr>
          <h4 class="header">ATTENDANCE STATUS</h4>
          <div id="comments"></div>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>

    <script scr="{{ asset('js/event/main.js') }}"> </script>

    <script src="{{ asset('js/event/clock.js')}}" type="text/javascript"> </script>
</body>

</html>