import React, {useEffect, useState} from "react";
import axios from "axios";
import Pusher from "pusher-js";
import {useQuery} from "react-query";

const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

export function AdminVerifyR({ event }) {
    const [pending, setPending] = useState(false);
    const {data: attendees, refetch} = useQuery({
        queryKey: ["attendees"],
        queryFn: async () => {
            const res = await axios.get(
                "/_api/attendees/event/id/" + event.id + "/pending"
            );
            return res.data.attendees;
        },
        enabled: !!event,
    });

    const handleAdmit = async (attedance_id) => {
        setPending(true);
        const res = await axios.post(
            "_api/attendees/id/" + attedance_id + "/approve"
        );
        if (res) {
            refetch();
            setPending(false);
            console.log(res.data);
        }
    };

    const handleDeny = async (attedance_id) => {
        setPending(true);
        const res = await axios.post(
            "_api/attendees/id/" + attedance_id + "/deny"
        );
        if (res) {
            refetch();
            setPending(false);
            console.log(res.data);
        }
    };

    useEffect(() => {
        const channel = pusher.subscribe("attendees");
        channel.bind("attendee.verified", (e) => refetch());
        channel.bind("attendee.scanned", (e) => refetch());

        return () => {
            channel.unbind_all();
        };
    }, []);

    console.log("attendees: ", attendees);

    return (
        <>
            <h1>{event && event.title ? event.title : "Event Name"}</h1>
            <table>
                <thead>
                <tr>
                    <th>Requester</th>
                    <th></th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {attendees &&
                    attendees.map((attendee) => (
                        <tr>
                            <td className="profile-column">
                                <div className="profile-picture">
                                    {/* Empty container for background image */}
                                </div>
                            </td>
                            <td>{attendee.user.name}</td>
                            <td>{attendee.user.email}</td>
                            <td>
                                <button
                                    className="admit-button"
                                    onClick={() => handleAdmit(attendee.id)}
                                >
                                    Admit
                                </button>
                                <button
                                    className="deny-button"
                                    onClick={() => handleDeny(attendee.id)}
                                >
                                    Deny
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </>
    );
}
