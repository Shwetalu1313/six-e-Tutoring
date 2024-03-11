<div id='calendar' class="mt-3"></div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventDetails">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
        <script>

            $(document).ready(function() {
                const jsonSchedules = {!! $jsonSchedules !!};
                $('#calendar').fullCalendar({
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay, jsEvent, view) {
                        // Find the clicked event
                        const clickedEvent = jsonSchedules.find(event => event.date  === start.format());

                        // Check if event is found
                        if (clickedEvent) {
                            // Populate modal with event details
                            $('#eventDetails').html(`

                            ${clickedEvent.important ?`<span class="text-danger">IMPORTANT</span>` : '' }


                        <p>Title: ${clickedEvent.title}</p>
                        <p>Date: ${start.format('YYYY-MM-DD')}</p>
                        <p>Time: ${clickedEvent.time}</p>
                        <p>Status:
                            <span class="badge ${clickedEvent.status === 'pending' ? 'bg-warning' : 'bg-success'}">
                                ${clickedEvent.status}
                            </span>
                        </p>

                        ${clickedEvent.location.startsWith('http') ? `<p><a href="${clickedEvent.location}" target="_blank">${clickedEvent.location}</a></p>` : `<p>Location: ${clickedEvent.location}</p> <hr>`}
                        <p> Description: <br> ${clickedEvent.description}</p>
                    `);

                            // Show the modal
                            $('#exampleModal').modal('show');
                        } else {
                            // Handle case when event is not found
                            console.error('Event not found for selected time:', start.format());
                            // Optionally, you can display an error message to the user
                        }
                    },
                    header: {
                        left: 'month, agendaWeek, agendaDay, list',
                        center: 'title',
                        right: 'prev,today,next'
                    },
                    events: jsonSchedules.map(function (event) {
                        return {
                            id: event.id,
                            title: event.important ? 'ℹ️ ' + event.title : event.title,
                            start: event.date + 'T' + event.time,
                            textColor: event.status === 'pending' ? 'black' : '',
                            color: event.status === 'confirmed' ? '' : 'yellow',
                        }
                    })
                });
            });
    </script>
@endpush

{{--$(document).ready(function() {--}}
{{--    const jsonSchedules = {!! $jsonSchedules !!};--}}
{{--    console.log(jsonSchedules);--}}

{{--    const calendarEl = $('#calendar');--}}

{{--    const calendar = new Calendar(calendarEl[0], {--}}
{{--        plugins: ['dayGrid', 'interaction'],--}}
{{--        initialView: 'dayGridMonth',--}}
{{--        editable: true,--}}
{{--        weekends: false,--}}
{{--        events: jsonSchedules.map(function(event) {--}}
{{--            return {--}}
{{--                id: event.id,--}}
{{--                title: event.title,--}}
{{--                start: event.date + 'T' + event.time,--}}
{{--            };--}}
{{--        })--}}
{{--    });--}}

{{--    calendar.render();--}}
{{--});--}}
