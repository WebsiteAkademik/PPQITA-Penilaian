<!DOCTYPE html>
<html>
<head>
	<title>REGISTRASI PPDB ONLINE</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
        table{
            margin: 0 auto;
            width: auto;
            table-layout: auto;
        }
		table tr td,
		table tr th{
			font-size: 10px;
            word-wrap: break-word;
		}
	</style>
			<center><img src="assets/kop-smk.jpg" width="95%"/></center> <br/>
	<center>
		<h6><strong>LAPORAN PENDAFTARAN SISWA TAHUN AJARAN BARU</strong></h6>
		<h6>TAHUN PELAJARAN 2024/2025</h6><br/>
	</center>
    <center>
        <table class="table table-bordered border-dark">
            <thead class="text-center">
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Nama Pendaftar</th>
                    <th>Kota</th>
                    <th>Sekolah Asal</th>
                    <th>No. Whatsapp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftars as $key => $pendaftar)
                <tr>
                    <td>{{ $pendaftar->no_pendaftaran }}</td>
                    <td>{{ $pendaftar->nama_calon_siswa }}</td>
                    <td>{{ $pendaftar->kabupaten }}</td>
                    <td>{{ $pendaftar->asal_sekolah }}</td>
                    <td>{{ $pendaftar->no_wa_anak }}</td>
                    <td>
                        @php
                            switch ($pendaftar->status) {
                                case 'BARU':
                                    echo "<div class='text-capitalize text-bold'>$pendaftar->status</div>";
                                    break;
                                case 'TEST':
                                    echo "<div class='text-capitalize text-bold'>$pendaftar->status</div>";
                                    break;
                                case 'MENUNGGU':
                                    echo "<div class='text-capitalize text-bold'>$pendaftar->status</div>";
                                    break;
                                case 'DITERIMA':
                                    echo "<div class='text-capitalize text-bold'>$pendaftar->status</div>";
                                    break;
                                case 'DITOLAK':
                                    echo "<div class='text-capitalize text-bold'>TIDAK DITERIMA</div>";
                                    break;
                            }
                        @endphp
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </center>
</body>
</html>