@extends('layouts.adminuser')

@section('title', 'Dashboard USER')

@push('style')
<style>
    .event-style {
        background-color: indigo;
        width: 100%;
        height: auto;
        color: white;
        font-weight: bold;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard Siswa</h4>
                    <p class="card-text">Selamat datang di dashboard siswa.</p>
                    <div id='calendar'></div>
                    <br>
                    <h5>Keterangan:</h5>
                    <ul>
                        <li>Biru = Penilaian Harian</li>
                        <li>Hijau = UTS</li>
                        <li>Merah = UAS</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'Asia/Jakarta',
        initialView: 'dayGridMonth',
        aspectRatio: 1.5,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,listWeek'
        },
        editable: true,
        resourceAreaHeaderContent: 'Jadwal Ujian',
        // resources: 'https://fullcalendar.io/api/demo-feeds/resources.json?with-nesting&with-colors',
        // events: 'https://fullcalendar.io/api/demo-feeds/events.json?single-day&for-resource-timeline'
        events: "{{ route('getEvents') }}",
        eventContent: function(arg) {
            // Check if the event has a description
            if (arg.event.extendedProps.description) {
                // Split the description by newline character to create multiple lines
                var lines = arg.event.extendedProps.description.split('\n');
                // Create a div for the event content
                var contentEl = document.createElement('div');
                contentEl.classList.add('event-style');
                contentEl.style.backgroundColor = arg.event.backgroundColor;
                var descT = document.createElement('p');
                descT.style.margin = '0';
                descT.style.padding = '0';
                descT.textContent = arg.event.title;
                contentEl.appendChild(descT);

                // Loop through each line and create a paragraph element for it
                lines.forEach(function(line) {
                    var descEl = document.createElement('p');
                    descEl.style.margin = '0';
                    descEl.style.padding = '0';
                    descEl.textContent = line;
                    contentEl.appendChild(descEl);
                });
                return { domNodes: [contentEl] };
            } else {
                // If there's no description, return default content
                return { domNodes: [document.createTextNode(arg.event.title)] };
            }
        }
    });

    calendar.render();
    window.calendar = calendar;
  });

</script>
@endsection
