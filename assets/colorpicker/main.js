$(function () {
    var currentDate; // Holds the day clicked when adding a new event
    var currentEvent; // Holds the event object when editing an event

    $('#color').colorpicker(); // Color picker

    // Prepares the modal window according to data passed
    function modal(data) {
        // Set modal title
        $('#event-modal-title').html(data.title);
        // Clear buttons except Cancel
        $('.modal-footer button:not(".btn-default")').remove();
        // Set input values
        var user_id = $('#user_id').val(data.event ? data.event.user_id : '0');
        $('#title').val(data.event ? data.event.title : '');
        var event_title_length = $('#title').val(data.event ? data.event.title : '');
        if (!data.event) {
            // When adding set timepicker to current time
            var now = new Date();
            var time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes());
        } else {
            // When editing set timepicker to event's time
            var time = data.event.date.split(' ')[1].slice(0, -3);
            time = time.charAt(0) === '0' ? time.slice(1) : time;
        }
        $('#user_id').val();
        $('#time').val(time);
        $('#description').val(data.event ? data.event.description : '');
        $('#color').val(data.event ? data.event.color : '#3a87ad');
        // Create Butttons
        $.each(data.buttons, function (index, button) {
            if (user_id.val() == '0' && event_title_length.val().length > 0) {
                //  alert('vfsdbfd');
            } else {
                $('#event-modal-footer').prepend('<button type="button" id="' + button.id + '" class="btn ' + button.css + '">' + button.label + '</button>')
            }
        })
        //Show Modal
        $('#event-modal').modal('show');
    }

    // Handle Click on Add Button
    $('#event-modal').on('click', '#add-event', function (e) {
        if (validator(['title', 'description'])) {
            $.post(base_url + 'calendar/addEvent', {
                user_id: $('#id').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                date: currentDate + ' ' + getTime()
            }, function (result) {
                $('#event-modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
            });
        }
    });

    // Handle click on Update Button
    $('#event-modal').on('click', '#update-event', function (e) {
        if (validator(['title', 'description'])) {
            $.post(base_url + 'calendar/updateEvent', {
                id: currentEvent._id,
                user_id: $('#user_id').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                date: currentEvent.date.split(' ')[0] + ' ' + getTime()
            }, function (result) {
                $('#event-modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
            });
        }
    });

    // Handle Click on Delete Button
    $('#event-modal').on('click', '#delete-event', function (e) {
        $.get(base_url + 'calendar/deleteEvent?id=' + currentEvent._id, function (result) {
            $('#event-modal').modal('hide');
            $('#calendar').fullCalendar("refetchEvents");
        });
    });


    // Get Formated Time From Timepicker
    function getTime() {
        var time = $('#time').val();
        return (time.indexOf(':') == 1 ? '0' + time : time) + ':00';
    }

    // Dead Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function (index, element) {
            if ($.trim($('#' + element).val()) == '') errors++;
        });
        if (errors) {
            $('.error').html('Please insert title and description');
            return false;
        }
        return true;
    }
});