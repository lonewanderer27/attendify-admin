import axios from "axios";

const video = document.getElementById('preview');
const scanner = new Instascan.Scanner({video: video});

Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else {
        console.error('No cameras found.');
    }
}).catch(function (error) {
    console.error('Error accessing camera:', error);
});


scanner.addListener('scan', function (content) {
    alert('Scanned: ' + content);

    // convert JSON into Javascript Object
    const json_obj = JSON.parse(content);

    // the basic json structure should be
    // {
    //     "user_id": 1,
    //     "event_id": 1,
    // }

    // event_id is optional, if not provided
    // then the user is trying to enter an event without approval
    // thus we need to request to the backend for approval

    if (!json_obj.hasOwnProperty("event_id")) {

    }

    // otherwise if it exists, then the user is invited to the event
    // we just need to insert a record of their attendance
    axios.post('/_api/attendees', {
        user_id: json_obj.user_id, event_id: json_obj.event_id
    }).then(res => {
        console.log(res.data);

        alert("Attendance has been recorded!");
    }).catch(err => {
        console.error(err.response);

        // Get the error message from error.response.data.errors
        const errorMessages = Object.values(err.response.data.errors);
        const errorMessage = errorMessages.flat().join('\n');

        // Display the error message to the user
        alert(errorMessage);
    })
});


//
// if (navigator.mediaDevices.getUserMedia) {
//   navigator.mediaDevices.getUserMedia({ video: true })
//     .then(function (stream) {
//       video.srcObject = stream;
//     })
//     .catch(function (error) {
//       console.log("Something went wrong!");
//     });s
// }
//
// let myComm = document.getElementById("comments");
//
// console.log(scanner)
//
// scanner.addListener("scan", function (c) {
//     document.getElementById("comment").value = c;
//
//     // Convert JSON into Javascript Object
//     json_obj = JSON.parse(c);
//     console.log(json_obj);
//     // Get data from JSON
//     let id_num = json_obj["id_num"];
//     let f_nm = json_obj["f_nm"] || "";
//     let m_nm = json_obj["m_nm"];
//     let l_nm = json_obj["l_nm"] || "";
//     let yr_lvl = json_obj["yrl_lvl"] || "";
//     let section = json_obj["section"] || "";
//     let full_name = f_nm + " " + l_nm;
//     let d = new Date();
//     let current_time =
//         d.getHours() +
//         ":" +
//         d.getMinutes() +
//         ":" +
//         d.getSeconds() +
//         ":" +
//         d.getMilliseconds();
//     let current_date =
//         d.getFullYear() + "." + (d.getMonth() + 1) + "." + d.getDate();
//
//     // Debugging Purposes
//     console.log("id_num: " + id_num);
//     console.log("f_nm: " + f_nm);
//     console.log("m_nm: " + m_nm);
//     console.log("l_nm: " + l_nm);
//     console.log(full_name);
//     console.log("yr_lvl: " + yr_lvl);
//     console.log("section" + section);
//     console.log("current time: " + current_time);
//     console.log("current date: " + current_date);
//
//     document.getElementById("id-field").value = id_num;
//     document.getElementById("f_nm").value = f_nm;
//     document.getElementById("m_nm").value = m_nm;
//     document.getElementById("l_nm").value = l_nm;
//     document.getElementById("current_time").value = current_time;
//     document.getElementById("current_date").value = current_date;
//     document.getElementById("comment").value = full_name;
//
//     axios
//         .post("https://sheetdb.io/api/v1/rxkwzdnr7nedb", {
//             data: {
//                 "id-field": id_num,
//                 f_nm: f_nm,
//                 m_nm: m_nm,
//                 l_nm: l_nm,
//                 year_level: yr_lvl,
//                 section: section,
//                 time: current_time,
//                 date: current_date,
//             },
//         })
//         .then((response) => {
//             console.log(response.data);
//         });
//
//     myComm.style.background = `#37FD12`;
//
//     setTimeout(function () {
//         document.getElementById("comment").value = " ";
//         myComm.style.background = `black`;
//     }, 2250);
// });
