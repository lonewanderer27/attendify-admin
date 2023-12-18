import axios from "axios";
import {AdminVerifyR} from "./Components/AdminDenyTable";
import {App} from "./Components/App";
import {createRoot} from "react-dom/client";

let dayjs = require("dayjs");

let menu = document.querySelectorAll(".menu");
let sidebar = document.querySelector(".sidebar");
let mainContent = document.querySelector(".main--content");

menu.forEach((menu) => {
    menu.addEventListener("click", () => {
        sidebar.classList.toggle("active");
        mainContent.classList.toggle("active");
    });
});

// assign onclick listeners on all card element class
let cardTitle = document.querySelectorAll(".card--title");
cardTitle.forEach((card) => {
    card.addEventListener("click", () => {
        // navigate to the event page
        window.location.href = "/event";

        // make the cursor a pointer when hovering on the card
        card.style.cursor = "pointer";
    });
});

// Optional: Handle form submission
document
    .getElementById("eventForm")
    .addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form submission for now, you can handle it as needed
        console.log("Form submitted");

        // get the form data
        const formData = new FormData(event.target);
        const user_id = formData.get("user_id");
        const title = formData.get("title");
        const date = formData.get("date");
        const time = formData.get("time");
        const location = formData.get("location");
        const invite_code = formData.get("invite_code");
        const organizer = formData.get("organizer");
        const organizer_email = formData.get("organizer_email");
        const organizer_approval =
            document.getElementById("organizerApproval").checked;

        // Get all elements with the class name "email"
        const emailInputs = document.getElementsByClassName("email");

        // Convert the HTMLCollection to an array for easier manipulation (if needed)
        const emailArray = Array.from(emailInputs);

        // Create a blank emails array
        let emails = [];

        // Iterate through the array of email inputs
        emailArray.forEach(function (emailInput) {
            const emailAddress = emailInput.textContent;
            emails.push(emailAddress);
            console.log(emailAddress);
        });

        // construct event data
        let eventData = {
            title,
            date: dayjs(date).format("YYYY-MM-DD"),
            time,
            location,
            invite_code,
            organizer,
            organizer_email,
            organizer_approval,
            user_id: user_id,
        };

        // Send a POST request
        axios
            .post("/_api/events", eventData)
            .then((response) => {
                console.log(response.data);

                // check if emailArray is empty
                if (emailArray.length === 0) {
                    alert("Event has been created!");

                    // immediately reload the window
                    return window.location.reload();
                }

                // otherwise create guestsData
                const guestsData = {
                    emails: emails,
                };

                // fetch the event id from response.data
                const eventId = response.data.event.id;

                axios
                    .post(
                        `/_api/invited_guests/event/id/${eventId}`,
                        guestsData
                    )
                    .then((response) => {
                        console.log(response.data);

                        alert("Guests to the event has been invited!");

                        return window.location.reload();
                    })
                    .catch((error) => {
                        console.error(error.response);

                        // Get the error message from error.response.data.errors
                        const errorMessages = Object.values(
                            error.response.data.errors
                        );
                        const errorMessage = errorMessages.flat().join("\n");

                        // Display the error message to the user
                        alert(errorMessage);
                    });
            })
            .catch((error) => {
                console.error(error.response);

                // Get the error message from error.response.data.errors
                const errorMessages = Object.values(error.response.data.errors);
                const errorMessage = errorMessages.flat().join("\n");

                // Display the error message to the user
                alert(errorMessage);
            });
    });


const component = document.getElementById("admin-deny-table");
if (component) {
    const root = createRoot(component);
    root.render(
        <App>
            <AdminVerifyR event={event} />
        </App>
    );
}
