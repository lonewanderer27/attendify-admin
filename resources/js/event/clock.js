let clock = document.getElementById("clock");

setInterval(function () {
    let date = new Date();
    clock.innerHTML = date.toLocaleTimeString(navigator.language, {
        hour: "2-digit",
        minute: "2-digit",
    });
}, 1000);
