<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
    <title>Dashboard | Passifi</title>
</head>

<body>
@include('partials._header')
<section class="main">
    @include('partials._sidebar')
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

                    <button class="add" onclick="openModal()"><i class="ri-add-line"></i>Add Event</button>
                    <div class="modal" id="eventModal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h1>Add Event</h1>
                            <form id="eventForm">
                                <input style="display: none;" type="text" name="user_id"
                                       value="{{ auth()->user()->id }}" required><br><br>

                                <label for="eventName">Event Name:</label>
                                <input type="text" id="eventName" name="title" required><br><br>

                                <label for="eventDate">Date:</label>
                                <input type="date" id="eventDate" name="date" pattern="\d{4}-\d{2}-\d{2}"
                                       required><br><br>

                                <label for="eventTime">Time:</label>
                                <input type="time" id="eventTime" name="time" required><br><br>

                                <label for="eventLocation">Location:</label>
                                <input type="text" id="eventLocation" name="location" required><br><br>

                                <label for="eventGuest">Guests to Passifi:</label>
                                <div class="emails-input">
                                    <input class="tag-input" type="text" id="email-input" placeholder="Add email"
                                           onkeydown="handleEmailInput(event)">
                                    <div class="tags" id="tags-container">
                                    </div>
                                </div>

                                <label for="eventCode">Set Invite Code:</label>
                                <input type="text" id="eventCode" name="invite_code" required><br><br>

                                <label for="eventImage">Set Event Photo:</label>
                                <input type="file" id="eventImage" name="eventImage"><br><br>

                                <hr> <!-- Line divider -->

                                <label for="organizerName">Name of Organizer:</label>
                                <input type="text" id="organizerName" name="organizer" required><br><br>

                                <label for="organizerEmail">Organizer Email:</label>
                                <input type="text" id="organizerEmail" name="organizer_email" required><br><br>

                                <div class="toggle">
                                    <label for="organizerApproval">Organizer Approval:</label>
                                    <label class="switch">
                                        <input type="checkbox" name="organizer_approval" id="organizerApproval">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <button type="submit" class="add">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cards">
                @foreach ($events as $event)
                    <div class="card card-1">
                        <div class="card--data">
                            <div class="card--content">
                                <img src="{{ asset('images/conference-img.jpg') }}" alt=""
                                     class="card--img">
                                <h1 class="card--title">{{ $event->title }}</h1>
                                <h5>ATTENDEES</h5>
                                <h1>
                                    @if ($event->invited_guests_count > 0)
                                        {{ $event->attendees_count }} / {{ $event->invited_guests_count }}
                                    @else
                                        {{ $event->attendees_count }}
                                    @endif
                                </h1>
                            </div>
                        </div>
                        <div class="card--stats">
                                <span><i class="ri-calendar-2-fill card--icon stat--icon"></i>
                                    {{ $event->date }}
                                </span>
                            <span><i class="ri-time-fill card--icon stat--icon"></i>{{ $event->time }}</span>
                            <span><i
                                    class="ri-map-pin-2-fill card--icon map--pin"></i>{{ $event->location }}</span>
                        </div>
                        <div class="card--buttons">
                            <button class="scan-button"
                                    onclick="window.location.href = `{{ route('events') . '/id/' . $event->id . '/scanR' }}`">
                                Scan
                            </button>
                            <button class="admit-deny-button" data-event_id="{{ $event->id }}">
                                Admit and Deny
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="admit-deny-overlay" id="admitDenyOverlay">
                <div class="admit-deny-modal">
                    <span class="close" onclick="closeAdmitDenyModal()">&times;</span>

                    <!-- React is going to auto populate this table component -->
                    <div class="admit-deny-table" id="admin-deny-table">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const events = @json($events);
    console.log("events: ", events);

    const event = events[0];
    console.log("event: ", event);
</script>
<script defer>
    // Create a blank emails array
    let emails = [];

    function openModal() {
        document.getElementById('eventModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('eventModal').style.display = 'none';
    }

    // Function to handle email input and tag creation
    function handleEmailInput(event) {
        const emailInput = document.getElementById('email-input');
        const tagsContainer = document.getElementById('tags-container');

        if (event.key === 'Enter') {
            const email = emailInput.value.trim();
            if (email) {
                // Check if the email already exists in the emails array
                if (emails.includes(email)) {
                    alert('This email has already been added!');
                } else {
                    const tag = createTag(email);
                    tagsContainer.appendChild(tag);
                    emails.push(email); // Add the email to the emails array
                    emailInput.value = '';
                }
            }
            event.preventDefault();
        }

        if (event.key === 'Backspace' && emailInput.value === '') {
            const tags = tagsContainer.querySelectorAll('.tag');
            if (tags.length > 0) {
                tags[tags.length - 1].remove();
                emails.pop(); // Remove the last email from the emails array
            }
        }
    }

    // Function to create a tag element
    function createTag(email) {
        const tag = document.createElement('div');
        tag.classList.add('tag');

        const emailSpan = document.createElement('span');
        emailSpan.classList.add('email');
        emailSpan.textContent = email;

        const removeBtn = document.createElement('span');
        removeBtn.classList.add('remove');
        removeBtn.textContent = 'x';
        removeBtn.addEventListener('click', () => tag.remove());

        tag.appendChild(emailSpan);
        tag.appendChild(removeBtn);

        return tag;
    }

    // Function to redirect to event scan page
    function openScanPage(event_id) {
        window.location.replace(
            {{-- "{{ route('events') . "/id/" . $event->id . "/scan" }}" --}} `${{ route('events') . '/id/' }} ${event_id} `
        );
    }

    // Function to open the admit deny modal
    function openAdmitDenyModal(event_id) {
        // console.log("event_id: ", event_id);
        // console.log("events: ", events);
        // let eventData = events[0];
        // console.log("event: ", eventData);

        const overlay = document.getElementById('admitDenyOverlay');
        overlay.style.display = 'block';
    }

    // Function to close the admit deny modal
    function closeAdmitDenyModal() {
        const overlay = document.getElementById('admitDenyOverlay');
        overlay.style.display = 'none';
    }

    // Attach click event listeners to Admit and Deny buttons on each card
    const admitDenyButtons = document.querySelectorAll('.admit-deny-button');

    admitDenyButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const eventId = this.getAttribute('data-event_id');
            openAdmitDenyModal(eventId);
            // Add logic here to populate the table content dynamically based on the card clicked
            // For instance, you can use data attributes on buttons to identify the specific card and update the table accordingly
        });
    });

</script>
</body>

</html>
