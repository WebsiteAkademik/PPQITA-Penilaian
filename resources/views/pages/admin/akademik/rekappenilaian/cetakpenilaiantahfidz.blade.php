<!DOCTYPE html>
<html>
<head>
	<title>Penilaian Tahfidz</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php
    date_default_timezone_set('Asia/Jakarta'); //Sesuai zona waktu
	?>
    
	<style type="text/css">
        .content {
            width: 85%;
            margin: 0 auto;
        }

        table {
            width: 100%;
        }

        table * {
            border-collapse: collapse;
            border: 1px solid black;
        }

		table tr td,
		table tr th{
			font-size: 14px;
		}

        .page-break {
            page-break-after: always;
        }

        .noborder * {
            border: none !important;
        }
	</style>

			<center><img src="assets/galeri/kop-rapor.png" width="100%"/></center> <br/>
	@php setlocale(LC_TIME, 'id_ID'); @endphp
	@php $i=1 @endphp
	<center>
		<h6>REKAP PENILAIAN TAHFIDZ SANTRI</h6>
		<h6>TAHUN PELAJARAN {{ $tahunajar->tahun_ajaran }}</h6>
	</center>
    <div class="content">
	<table class="noborder">
            <tbody>
                <tr>
                    <th style="width: 100px;">Kelas</th>
                    <th style="width: 10px;">:</th>
                    <th style="width: 300px;">{{ $kelas->kelas }}</th>
                    <th style="width: 100px;">Semester</th>
                    <th style="width: 10px;">:</th>
                    <th>{{ $tahunajar->semester}}</th>
                </tr>
            </tbody>
        </table><br/>
		<table>
			<thead>
				<tr>
					<th style="text-align: center; vertical-align: middle" rowspan="2">
						No.
					</th>
					<th style="text-align: center; vertical-align: middle" rowspan="2">
						Nama
					</th>
					<th style="text-align: center" colspan="{{ count($mapel) }}">
						Nilai
					</th>
					<th style="text-align: center; vertical-align: middle" rowspan="2">
						Rata-Rata
					</th>
				</tr>
				<tr>
					@foreach($mapel as $m)
                    <th style="text-align: center">
						{{ $m->nama_mata_pelajaran }}
                    </th>
                    @endforeach
				</tr>
			</thead>
			<tbody>
			@foreach ($rekapNilai as $index => $rekap)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $rekap['siswa']->nama_siswa }}</td>
                    @foreach ($rekap['nilai'] as $nilai)
                    <td style="text-align: center;">{{ $nilai['nilai'] }}</td>
                    @endforeach
                    <td style="text-align: center;">{{-- Rata-rata --}}
                        @php
                            $totalNilai = 0;
                            foreach($rekap['nilai'] as $n){
                                $totalNilai += $n['nilai'];
                            }
                            $rataRata = count($rekap['nilai']) > 0 ? $totalNilai / count($rekap['nilai']) : 0;
                        @endphp
                        {{ number_format($rataRata, 2) }}
                    </td>
                </tr>
                @endforeach
			</tbody>
			<thead>
				<tr>
					<td colspan="{{ count($mapel) + 1 }}"></td>
					<th colspan="1">
						Rata-Rata Kelas
					</th>
					<td style="text-align: center">
						@php
							$totalRataRataKelas = 0;
							$totalSiswa = count($rekapNilai);
							foreach($rekapNilai as $rekap){
								foreach($rekap['nilai'] as $nilai){
									$totalRataRataKelas += $nilai['nilai'];
								}
							}
							$rataRataKelas = $totalSiswa > 0 ? $totalRataRataKelas / ($totalSiswa * count($mapel)) : 0;
						@endphp
						{{ number_format($rataRataKelas, 2) }}
                    </td>
                </tr> 
			</thead>
		</table>
    </div>
</body>
</html>