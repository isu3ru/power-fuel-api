var calendar = undefined;
var _editingScheduleEntry = undefined;

function initFullCalendar() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        eventDisplay: 'block',
        selectable: true,
        showNonCurrentDates: false,
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        dateClick: function (info) {
            document.getElementById('scheduled_on').value = info.dateStr;
        },
        events: events,
    });

    calendar.render();
}

$('#type_date').change(function () {
    toggleBlocks();
});

$('#type_repeat').change(function () {
    toggleBlocks();
});

function toggleRepeatIntervalChanges() {
    $('#block_repeating_days').addClass('d-none');
    $('#block_monthly_repeating_type').addClass('d-none');
    $('#block_monthly_repeating_weeks').addClass('d-none');

    let scheduleInterval = $('#schedule_interval').val();
    if (scheduleInterval == 'weekly') {
        // repeating days only
        $('#block_repeating_days').removeClass('d-none');
        $('#block_monthly_repeating_type').addClass('d-none');
        $('#block_monthly_repeating_weeks').addClass('d-none');
        $('#block_monthly_repeating_dates').addClass('d-none');
    } else if (scheduleInterval == 'monthly') {
        // others
        $('#block_repeating_days').addClass('d-none');
        $('#block_monthly_repeating_type').removeClass('d-none');
        $('#block_monthly_repeating_weeks').removeClass('d-none');
        $('#block_monthly_repeating_dates').removeClass('d-none');

        if ($('#monthly_repeating_date').is(':checked')) {
            $('#block_monthly_repeating_dates').removeClass('d-none');
            $('#block_monthly_repeating_weeks').addClass('d-none');
            $('#block_repeating_days').addClass('d-none');
        } else if ($('#monthly_repeating_day').is(':checked')) {
            $('#block_monthly_repeating_dates').addClass('d-none');
            $('#block_monthly_repeating_weeks').removeClass('d-none');
            $('#block_repeating_days').removeClass('d-none');
        }
    }

}

$('#schedule_interval').change(toggleRepeatIntervalChanges);

$('#monthly_repeating_date').change(toggleRepeatIntervalChanges);
$('#monthly_repeating_day').change(toggleRepeatIntervalChanges);

function toggleBlocks() {
    if ($('#type_date').is(':checked')) {
        $('#block_schedule_date').removeClass('d-none');
        $('#block_schedule_interval').addClass('d-none');
        $('#block_monthly_repeating_type').addClass('d-none');
        $('#block_monthly_repeating_weeks').addClass('d-none');
        $('#block_monthly_repeating_dates').addClass('d-none');
        $('#block_repeating_days').addClass('d-none');
    } else if ($('#type_repeat').is(':checked')) {
        $('#block_schedule_date').addClass('d-none');
        $('#block_schedule_interval').removeClass('d-none');
        $('#block_monthly_repeating_type').removeClass('d-none');
        $('#block_monthly_repeating_weeks').removeClass('d-none');
        $('#block_monthly_repeating_dates').removeClass('d-none');
        $('#block_repeating_days').removeClass('d-none');

        toggleRepeatIntervalChanges();
    }
}

function loadScheduleForRoute() {
    let routeid = $('#route_id').val();

    let routeName = $('#route_id option[value=' + routeid + ']').text();
    $('.calendar_route_name').html(routeName);

    // block tab changes
    $('.nav-link').prop('disabled', true);

    // get the calendar data for the route from API
    $.get(BASE_URL + '/admin/collection-schedule/calendar-events/' + routeid, function (res) {
        if (calendar) {
            calendar.removeAllEvents();
            calendar.addEventSource(res);
            // reset tab changes
            $('.nav-link').prop('disabled', false);
            console.log('called here');
        }
    }, 'json');
}

$('#route_id').change(function () {
    loadScheduleForRoute();
    loadEntriesTable();
});

function saveCalendarSchedule(callback) {
    let url = BASE_URL + '/admin/collection-schedule';
    let data = $('#collection-schedule-form').serialize();
    $.post(url, data, function (res) {
        if (res.status && res.status == 'success') {
            Swal.fire(
                'Success',
                'Collection schedule entry created succesfully.',
                'success'
            );
            if (typeof callback === 'function') {
                callback();
            }
        }
    }, 'json');
}

// update schedule entry
function updateCalendarSchedule(callback) {
    let url = BASE_URL + '/admin/collection-schedule/' + _editingScheduleEntry.id;
    let data = $('#collection-schedule-form').serialize();
    $.ajaxSetup({
        headers: {
            'Accept': 'application/json'
        }
    });
    $.put(url, data, function (res) {
        if (res.status && res.status == 'success') {
            Swal.fire(
                'Success',
                'Collection schedule entry updated succesfully.',
                'success'
            );
            if (typeof callback === 'function') {
                callback();
            }
        }
    }, 'json');
}

$('#send_schedule_create').click(function (e) {
    // save schedule
    saveCalendarSchedule(function () {
        resetForm();
        // refresh calendar
        loadScheduleForRoute();
    });
});

$('#send_schedule_update').click(function (e) {
    // save schedule
    updateCalendarSchedule(function () {
        resetForm();
        // refresh calendar
        loadScheduleForRoute();
    });
});

// handle edit
function handleEntryEdit(id, callback) {
    $.get(BASE_URL + '/admin/collection-schedule/entry/' + id, function (res) {
        if (res.status && res.status === 'success') {
            if (typeof callback === 'function') {
                callback(res.data);
            }
        }
    }, 'json');
}

// trigger edit button on click
$(document).on('click', '.schedule-action.edit', function (e) {
    let id = $(this).data('id');
    handleEntryEdit(id, function (data) {
        _editingScheduleEntry = data;
        editScheduleEntry(data);
    });
});

// set the data in the form and set into update mode
function editScheduleEntry(data) {
    let card = $('#collection-schedule-card');
    let form = $('#collection-schedule-form');
    let cardHeader = card.find('.card-header');

    // change colors and texts
    card.removeClass('border-primary').addClass('border-warning');
    cardHeader.removeClass('bg-primary').addClass('bg-warning');
    cardHeader.text('Update details of collection schedule entry');

    // toggle buttons
    $('#send_schedule_create').addClass('d-none');
    $('#send_schedule_update').removeClass('d-none');
    $('#reset_schedule_form').removeClass('d-none');

    // reset field values
    form.find('select').each(function (i, el) {
        $(el).val($(el).find('option:first').val());
    });

    form.find('input[type=text]').each(function (i, el) {
        $(el).val('');
    });

    form.find('input[type=date]').each(function (i, el) {
        $(el).val('');
    });

    form.find('input:checkbox').each(function (i, el) {
        $(el).prop('checked', false);
    });

    // set field values
    $('#local_authority_id').val(data.local_authority_id);
    $('#local_auroute_idthority_id').val(data.route_id);
    $('#category_id').val(data.category_id);
    if (data.schedule_type == "repeat") {
        $('#type_repeat').prop('checked', true);
        $('#type_date').prop('checked', false);
    } else {
        $('#type_date').prop('checked', true);
        $('#type_repeat').prop('checked', false);
    }
    $('#schedule_interval').val(data.schedule_interval);
    $('#scheduled_on').val(data.scheduled_on);
    $('#time_from').val(data.time_from);
    $('#time_to').val(data.time_to);

    // set days
    if (data.days) {
        let daysArray = data.days.split(',');
        for (let i = 0; i < daysArray.length; i++) {
            const day = daysArray[i];
            $('#day_' + day).prop('checked', true);
        }
    }

    // set monthly repeating type selection
    if (data.monthly_repeating_type) {
        if (data.monthly_repeating_type == 'date') {
            $('#monthly_repeating_day').prop('checked', false);
            $('#monthly_repeating_date').prop('checked', true);
        } else {
            $('#monthly_repeating_date').prop('checked', false);
            $('#monthly_repeating_day').prop('checked', true);
        }

        toggleRepeatIntervalChanges();
    }
    if (data.monthly_repeating_dates) {
        $('#monthly_repeating_dates').val(data.monthly_repeating_dates.split(',')).trigger('change');
    }

    if (data.monthly_repeating_weeks) {
        $('.monthly_repeating_weeks_check').prop('checked', false);
        let weeks = data.monthly_repeating_weeks.split(',');
        for (let i = 0; i < weeks.length; i++) {
            const week = weeks[i];
            $('#monthly_repeating_week' + week).prop('checked', true);
        }
    }

    // show hide fields and values
    toggleBlocks();
    toggleRepeatIntervalChanges();
}

function resetForm() {
    let card = $('#collection-schedule-card');
    let form = $('#collection-schedule-form');
    let cardHeader = card.find('.card-header');

    // change colors and texts
    card.addClass('border-primary').removeClass('border-warning');
    cardHeader.addClass('bg-primary').removeClass('bg-warning');
    cardHeader.text('New Collection Schedule Entry');

    // toggle buttons
    $('#send_schedule_create').removeClass('d-none');
    $('#send_schedule_update').addClass('d-none');

    // reset field values
    form.find('select').each(function (i, el) {
        $(el).val($(el).find('option:first').val());
    });

    form.find('input[type=text]').each(function (i, el) {
        $(el).val('');
    });

    form.find('input[type=date]').each(function (i, el) {
        $(el).val('');
    });

    form.find('input:checkbox').each(function (i, el) {
        $(el).prop('checked', false);
    });

    $('#type_repeat').prop('checked', true);
    $('.monthly_repeating_weeks_check').prop('checked', false);
    $('#monthly_repeating_dates').val('');
    $('#monthly_repeating_date').prop('checked', false);
    $('#monthly_repeating_day').prop('checked', true);

    toggleBlocks();
    toggleRepeatIntervalChanges();

    // load calendar and table
    loadEntriesTable();
    loadScheduleForRoute();

    _editingScheduleEntry = undefined;
}

$('#reset_schedule_form').click(resetForm);

// handle delete
function handleEntryDelete(id, callback) {
    $.delete(BASE_URL + '/admin/collection-schedule/' + id, function (res) {
        if (res.status && res.status === 'success') {
            Swal.fire(
                'Success',
                'Collection schedule entry deleted succesfully.',
                'success'
            );
            if (typeof callback === 'function') callback();
        }
    }, 'json');
}

// trigger delete button on click
$(document).on('click', '.schedule-action.delete', function (e) {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete a collection schedule entry which will affect the current schedule.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete'
    }).then((result) => {
        if (result.isConfirmed) {
            handleEntryDelete(id, function () {
                loadEntriesTable();
                loadScheduleForRoute();
            });
        }
    });
});

// load the entries table
function loadEntriesTable() {
    let routeId = $('#route_id').val();
    let container = $('#collection-schedule-list-table tbody');
    // show loading row
    container.html('<tr><td colspan="6">Please wait...</td></tr>');
    $.get(BASE_URL + '/admin/collection-schedule/entries/table/' + routeId, function (res) {
        if (res.status && res.status === 'success') {
            if (res.data.length > 0) {
                container.html(res.data);
            } else {
                container.html('<tr><td colspan="6">No collection schedules found.</td></tr>');
            }
        } else {
            container.html('<tr><td colspan="6">No collection schedules found.</td></tr>');
        }
    }, 'json');
}

var tabEl = document.querySelector('#nav-home-tab')
tabEl.addEventListener('shown.bs.tab', function (event) {
    if (event.target.id == 'nav-home-tab') {
        loadScheduleForRoute();
    }
});

$(function () {
    initFullCalendar();

    toggleBlocks();

    loadScheduleForRoute();

    $('.select2').select2({
        width: '100%'
    });

    $('.loader-overlay').css('display', 'none');
});