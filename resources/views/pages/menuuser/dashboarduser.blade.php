@extends('layouts.adminuser')

@section('title', 'Dashboard SISWA')

@push('style')
<style>
    .event-style {
        background-color: indigo;
        width: 100%;
        height: auto;
        color: white;
        font-weight: bold;
    }

    .card-title {
        font-size: 24px; 
        font-weight: bold; 
        margin-bottom: 10px; 
    }

    .card-text {
        font-size: 18px; 
        font-weight: normal;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Dashboard Siswa</h3>
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

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h3 class="card-title fw-semibold mb-4">Jadwal Ujian Terdekat</h3>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Tanggal Ujian</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Jam Ujian</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Mata Pelajaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Jenis Ujian</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalujian as $key => $jadwalujian)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $key + 1 }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $jadwalujian->tanggal_ujian }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $jadwalujian->jam_ujian }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $jadwalujian->mataPelajaran()->nama_mata_pelajaran }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $jadwalujian->jenis_ujian }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h2 class="card-title fw-semibold mb-2">Penilaian Terbaru</h2>
                    <h5 class="card-text fw-semibold mb-2">Penilaian Pelajaran</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Mata Pelajaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Jenis Ujian</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Nilai</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Keterangan</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penilaianumum as $umum => $penilaianumum)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $umum + 1 }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaianumum->mapelID()->nama_mata_pelajaran }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaianumum->jenis_ujian }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaianumum->nilai }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaianumum->keterangan }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h5 class="card-text fw-semibold mb-2">Penilaian Tahfidz</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr style="background-color: #2E8CB5">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">No.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Mata Pelajaran</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Surat Awal</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Surat Akhir</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Nilai</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-white">Keterangan</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penilaiantahfidz as $tahfidz => $penilaiantahfidz)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $tahfidz + 1 }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaiantahfidz->mapelID()->nama_mata_pelajaran }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaiantahfidz->surat_awal }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaiantahfidz->surat_akhir }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaiantahfidz->nilai }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $penilaiantahfidz->keterangan }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
