$(document).ready(function() {
    var audioElement = new Audio("sounds/notif.mp3");
    var shouldPlayAudio = false;

    function updateQueueView() {
        $.ajax({
            url: '/getUpdatedQueueData',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#table_container').html(data.html);
                updateQueueInfo();
                                
               console.log('Audio should be playing now.');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function updateQueueInfo() {
        $.ajax({
            url: '/getUpdatedQueueInfo',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('.current_serve').text('Serving: ' + data.currentPriorityNumber);
                $('.latest').text('Latest: ' + data.latestPriorityNumber);
                $('.waiting').text('Waiting: ' + data.waitingCount);
                console.log(data.currentPriorityNumber + " This shit is working perfectly");
                console.log("Testing changes: " + data.newChanges + data.waitingCount);
                console.log(shouldPlayAudio);
                if (data.newChanges) {
                    // Play the audio when an update is detected
                    var audio = new Audio('/sounds/notif.mp3'); 
                    audio.play();
                    console.log("data.newChanges working");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    audioElement.onended = function() {
        shouldPlayAudio = false;
    };

    updateQueueInfo();
    setInterval(updateQueueView, 3000);

});
