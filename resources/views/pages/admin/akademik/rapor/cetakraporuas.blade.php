<!DOCTYPE html>
<html>
<head>
	<title>RAPOR UAS</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php
    date_default_timezone_set('Asia/Jakarta'); //Sesuai zona waktu
    $tanggal_hari_ini = date('d F Y');
    $nomorurut = 1;
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

			<center><img src="assets/galeri/kop-rapor.png" width="100%"/></center> <br/><br/>
	@php setlocale(LC_TIME, 'id_ID'); @endphp
	@php $i=1 @endphp
	<center>
		<h6>LAPORAN PENILAIAN HASIL UAS SANTRI</h6>
		<h6>TAHUN PELAJARAN {{ $tahunajar->tahun_ajaran }}</h6>
	</center>
    <div class="content">
        <table class="noborder">
            <tbody>
                <tr>
                    <th style="width: 100px;">Nama</th>
                    <th style="width: 10px;">:</th>
                    <th style="width: 300px;">{{ $siswa->nama_siswa }}</th>
                    <th style="width: 100px;">Kelas</th>
                    <th style="width: 10px;">:</th>
                    <th>{{ $kelas->kelas}}</th>
                </tr>
                <tr>
                    <th>Nomor Induk</th>
                    <th>:</th>
                    <th>{{ $siswa->no_nisn}}</th>
                    <th>Semester</th>
                    <th>:</th>
                    <th>{{ $tahunajar->semester }}</th>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; width: 30px;">
                        No
                    </th>
                    <th style="text-align: center;">
                        Mata Pelajaran
                    </th>
                    <th style="text-align: center; width: 75px;">
                        KKM
                    </th>
                    <th style="text-align: center; width: 75px;">
                        Nilai
                    </th>
                    <th style="text-align: center; width: 75px;">
                        Rata-Rata Kelas
                    </th>
                    <th style="text-align: center; width: 85px;">
                        Deskripsi Kemajuan Belajar
                    </th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th colspan="6">A. Mata Pelajaran Umum</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaianumum as $key => $rowumum)
                <tr>
                    <td>
                        {{ $nomorurut++ }}
                    </td>
                    <td>
                        {{ $rowumum['mapel']->nama_mata_pelajaran }}
                    </td>
                    <td>
                        {{ number_format($rowumum['mapel']->kkm, 2) }}
                    </td>
                    <td>
                        {{ $rowumum['nilai'] }}
                    </td>
                    <td>
                        {{ number_format($nilaiumum_kelas[$rowumum['mapel']->id], 2) ?? '-' }}
                    </td>
                    <td>
                        {{ $rowumum['keterangan'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th colspan="6">B. Program Tahfidz</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaiantahfidz as $key => $rowtahfidz)
                <tr>
                    <td>
                        {{ $nomorurut++ }}
                    </td>
                    <td>
                        {{ $rowtahfidz['mapel']->nama_mata_pelajaran }}
                    </td>
                    <td>
                        {{ number_format($rowtahfidz['mapel']->kkm, 2) }}
                    </td>
                    <td>
                        {{ $rowtahfidz['nilai'] }}
                    </td>
                    <td>
                        {{ number_format($nilaitahfidz_kelas[$rowtahfidz['mapel']->id], 2) ?? '-' }}
                    </td>
                    <td>
                        {{ $rowtahfidz['keterangan'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th colspan="6">C. Mata Pelajaran Dinniyah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaiandinniyah as $key => $rowdinniyah)
                <tr>
                    <td>
                        {{ $nomorurut++ }}
                    </td>
                    <td>
                        {{ $rowdinniyah['mapel']->nama_mata_pelajaran }}
                    </td>
                    <td>
                        {{ number_format($rowdinniyah['mapel']->kkm, 2) }}
                    </td>
                    <td>
                        {{ $rowdinniyah['nilai'] }}
                    </td>
                    <td>
                        {{ number_format($nilaidinniyah_kelas[$rowdinniyah['mapel']->id], 2) ?? '-' }}
                    </td>
                    <td>
                        {{ $rowdinniyah['keterangan'] }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td>
                        
                    </td>
                    <td colspan="2">
                        Total Nilai
                    </td>
                    <td>
                        {{ number_format($nilaitotal_umum, 2) }}
                    </td>
                    <td colspan="2" rowspan="2">
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td colspan="2">
                        Total Nilai Rata-Rata
                    </td>
                    <td>
                        {{ number_format($nilai_rata_rata_total, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="page-break"></div>
    <center><img src="assets/galeri/kop-rapor.png" width="100%"/></center> <br/><br/>
    <div class="content">
        <h6>Pengembangan diri bla bla bla</h6>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center; width: 75px;">No</th>
                    <th style="text-align: center; width: 75px;">Nama</th>
                    <th style="text-align: center; width: 75px;">Nilai</th>
                    <th style="text-align: center; width: 75px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>asdf</td>
                    <td>asdf</td>
                    <td>asdf</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>asdf</td>
                    <td>asdf</td>
                    <td>asdf</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>asdf</td>
                    <td>asdf</td>
                    <td>asdf</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <div style="width: 45%; float: left;">
            <h6>Ketidakhadiran</h6>
            <table>
                <tbody>
                    <tr>
                        <th>Sakit</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Izin</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Tanpa Keterangan</th>
                        <td>1</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 10%; float: left;">
        </div>
        <div style="width: 45%; float: left;">
            <h6>Saran / Nasihat</h6>
            <table>
                <tbody>
                    <tr>
                        <th>
                            Alhamdulilah, nilai Ananda sangat baik. Semoga selalu semangat bersekolah.
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 100%; clear: both;"></div>
        <br/>
        <br/>
        <table class="noborder">
            <tbody>
                <tr>
                    <td colspan="5" style="text-align: right;">Karanganyar, {{ $tanggal_hari_ini }}</td>
                </tr>
                <tr>
                    <td style="text-align: center;">Orang Tua / Wali</td>
                    <td style="width: 10%;"></td>
                    <td style="text-align: center;">Mengetahui<br/>Kepala Sekolah</td>
                    <td style="width: 10%;"></td>
                    <td style="text-align: center;">Wali Kelas</td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: center;"><br/><br/><br/><br/><br/></td>
                </tr>
                <tr>
                    <td style="text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                    <td style="width: 10%;"></td>
                    <td style="text-align: center;">Dhanny Ardiansyah</td>
                    <td style="width: 10%;"></td>
                    <td style="text-align: center;">{{ $kelas->pengajarID()->nama_pengajar}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>