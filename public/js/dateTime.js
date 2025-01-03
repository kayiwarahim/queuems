function updateDateTime() {
    const currentDate = new Date();
    const day = currentDate.toLocaleString('en-us', { weekday: 'long' });
    const date = currentDate.toLocaleDateString('en-us', { day: 'numeric', month: 'short' });
    const time = currentDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

    const dateTimeString = `${day} | ${date} | ${time}`;
    const datetimeDiv = document.getElementById('datetime_div');
    datetimeDiv.textContent = dateTimeString;
}

updateDateTime();
setInterval(updateDateTime, 1000);