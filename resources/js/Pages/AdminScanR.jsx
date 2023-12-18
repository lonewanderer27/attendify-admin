import React, {useEffect, useState} from "react";
import {QrReader} from "react-qr-reader";
import axios from "axios";
import Modal from "react-bootstrap/Modal";
import "bootstrap/dist/css/bootstrap.min.css";
import Pusher from "pusher-js";

export default function AdminScanR({event}) {
    const [updatedAttendee, setUpdatedAttendee] = useState(null);
    const [status, setStatus] = useState(null); // approved, denied, pending or null
    const [attendee, setAttendee] = useState(null); // [user_id, event_id, status]
    const [user, setUser] = useState(null); // [id, name, email, email_verified_at, created_at, updated_at]
    const [qrData, setQrData] = useState(null);

    useEffect(() => {
        // check if data is not null
        if (qrData) {
            // log the data
            console.log(qrData);

            // convert JSON into Javascript Object
            try {
                const json_obj = JSON.parse(qrData);

                // verify if user_id at least exists
                if (
                    !json_obj.hasOwnProperty("user_id") ||
                    !json_obj.hasOwnProperty("event_id")
                ) {
                    console.error("user_id does not exist");
                    alert("Invalid QR Code");
                    return;
                }

                // freeze the video
                document.getElementById("preview").pause();

                axios
                    .post("/_api/attendees", {
                        user_id: json_obj.user_id,
                        event_id: json_obj.event_id,
                    })
                    .then((res) => {
                        console.log(res.data);

                        console.log("checking user's status");
                        // check if the status is false
                        // we wait for the status to be true
                        if (res.data.attendee.status === false) {
                            // setting the attendee
                            console.log("setting the attendee");
                            console.log(res.data.attendee);

                            // set the attendee
                            setAttendee(res.data.attendee);

                            // set the user
                            setUser(res.data.user);

                            // set status to pending
                            setStatus("pending");
                        } else {
                            // set status to approved
                            setStatus("approved");

                            // unfreeze the video
                            document.getElementById("preview").play();
                        }
                    })
                    .catch((err) => {
                        console.error(err.response);

                        // Get the error message from error.response.data.errors
                        const errorMessages = Object.values(
                            err.response.data.errors
                        );
                        const errorMessage = errorMessages.flat().join("\n");

                        // Display the error message to the user
                        alert(errorMessage);

                        // set status to null
                        setStatus(null);

                        // unfreeze the video
                        document.getElementById("preview").play();
                    });
            } catch (e) {
                console.error(e);
                alert("Invalid QR Code");
            }
        }
    }, [qrData]);

    useEffect(() => {
        window.document.title = `${event.title} | Passifi`;

        const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            encrypted: true,
        });

        const channel = pusher.subscribe("attendees");
        channel.bind("attendee.verified", (e) => setUpdatedAttendee(e));

        return () => {
            pusher.unsubscribe("attendees");
        };
    }, []);

    useEffect(() => {
        if (updatedAttendee) {
            // display the event
            console.log("event: ", updatedAttendee);

            // display the attendee
            console.log("attendee: ", attendee);

            // display the user
            console.log("user: ", user);

            // check if the attendee is not the same
            if (attendee.user_id !== updatedAttendee.user_id) {
                // this means that the user is not the same
                // it's not the same user that we are verifying
                // we return
                return;
            }



            // check if the user's status is true
            if (updatedAttendee.verified === true && updatedAttendee.status === true) {
                // log to the console
                console.log("User has been approved");

                // set status to approved
                setStatus(() => "approved");
            }

            if (updatedAttendee.verified === true && updatedAttendee.status === false) {
                // the user has been denied
                // log to the console
                console.log("User has been denied");

                // set status to denied
                setStatus(() => "denied");
            }

            // count 1 second before doing the ff:
            // 1. set status to null
            // 2. unfreeze the video
            // 3. set the attendee to null
            // 4. set the user to null
            setTimeout(() => {
                // set status to null
                setStatus(() => null);

                // unfreeze the video
                document.getElementById("preview").play();

                // set the attendee to null
                setAttendee(() => null);

                // set the user to null
                setUser(() => null);
            }, 2500);
        }
    }, [updatedAttendee]);

    return (
        <>
            <nav>
                <a href="/" className="ihms-navbar" id="hover">
                    <h1 className="ihms-navbar-h1">
                        <b>{event.title} | Passifi</b>
                    </h1>
                </a>
                <div className="burger">
                    <div className="line1"></div>
                    <div className="line2"></div>
                    <div className="line3"></div>
                </div>
            </nav>
            {status === "pending" && <LoadingModal user={user} event={event}/>}
            {(status === "approved" || status === "denied") && (
                <VerifiedModal user={user} event={event} status={status}/>
            )}
            <div className="main" id="main">
                <div className="main-1-1">
                    <QrReader
                        videoId={"preview"}
                        onResult={(result) => {
                            if (!!result) {
                                setQrData(result?.text);
                            }
                        }}
                        style={{width: "100%"}}
                        constraints={{facingMode: "user"}}
                    />
                </div>

                <div className="main-1-2">
                    <div id="clock">00:00 AM</div>
                    <p className="main-1-2-p1">Scan the User QR Code</p>
                    <br/>
                    <input
                        type="text"
                        name="text"
                        id="comment"
                        readOnly=""
                        placeholder="Scan User QR Code in front of the camera."
                        className="form-control"
                    />
                    <br/>

                    <p>
                        <b>NOTE: </b> User QR Code is found at ...
                    </p>
                    <br/>
                    <div>
                        <hr/>
                        <h4 className="header">ATTENDANCE STATUS</h4>
                        <div id="comments"></div>
                    </div>
                </div>
            </div>
        </>
    );
}

function LoadingModal({user, event}) {
    return (
        <Modal show={true} backdrop="static" keyboard={false} centered>
            <Modal.Header>
                <Modal.Title>Verifying</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <p>
                    <b>Name:</b> {user?.name}
                </p>
                <p>
                    <b>Email:</b> {user?.email}
                </p>
                <p>
                    <b>Event:</b> {event.title}
                </p>
            </Modal.Body>
        </Modal>
    );
}

function VerifiedModal({user, event, status}) {
    return (
        <Modal show={true} backdrop="static" keyboard={false} centered>
            <Modal.Header>
                <Modal.Title>
                    {status === "approved" ? "Entry Approved" : "Entry Denied"}
                </Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <p>
                    <b>Name:</b> {user?.name}
                </p>
                <p>
                    <b>Email:</b> {user?.email}
                </p>
                <p>
                    <b>Event:</b> {event.title}
                </p>
            </Modal.Body>
        </Modal>
    );
}
