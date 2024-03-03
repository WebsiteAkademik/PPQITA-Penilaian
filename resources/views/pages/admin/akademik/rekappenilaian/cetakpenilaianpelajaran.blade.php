<!DOCTYPE html>
<html>
<head>
	<title>Penilaian Pelajaran</title>
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

			<center><img src="assets/galeri/kop-rapor.png" width="100%"/></center> <br/><br/>
	@php setlocale(LC_TIME, 'id_ID'); @endphp
	@php $i=1 @endphp
	<center>
		<h6>REKAP PENILAIAN PELAJARAN SANTRI</h6>
		<h6>TAHUN PELAJARAN 2023/2024</h6>
	</center>
    <div class="content">
		<table>
			<thead>
				<tr>
					<th>
						No.
					</th>
					<th>
						Nama
					</th>
					<th>
						UI/UX
					</th>
					<th>
						Web Development
					</th>
					<th>
						Mobile Development
					</th>
					<th>
						Rata-Rata
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						asdf
					</td>
					<td>
						asdf           
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
				</tr>
				<tr>
					<td>
						asdf
					</td>
					<td>
						asdf           
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
					<td>
						asdf
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<td colspan="4"></td>
					<th>
						Rata-Rata Kelas
					</th>
					<td>
						asdf
					</td>
				</tr>
			</thead>
		</table>
    </div>
</body>
</html>