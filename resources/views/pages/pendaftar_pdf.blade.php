<!DOCTYPE html>
<html>
<head>
	<title>REGISTRASI PPDB ONLINE</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 14px;
		}
	</style>
			<center><img src="assets/kop-smk.jpg" width="95%"/></center> <br/><br/>
	@php setlocale(LC_TIME, 'id_ID'); @endphp
	@php $i=1 @endphp
	@foreach($pendaftar as $p)
	<center>
		<h6><strong>FORMULIR PENDAFTARAN PESERTA DIDIK BARU</strong></h6>
		<h6>TAHUN PELAJARAN 2024/2025</h6>
	</center>
	<table class='table' style="width:90%;margin-left: auto;
	margin-right: auto;">
		<tbody>

			<tr>
				<td style="width: 48%">
					No NISN<br> 
					Nama Calon Siswa<br>
					Tempat dan Tanggal lahir<br>
					Nomor Kartu Keluarga<br>
					Tinggi Badan<br> 
					Berat Badan<br> 
					Penyakit Kronis<br> 
					Sekolah Asal<br> 
					Nama Ayah<br> 
					Pekerjaan Ayah<br> 
					Nama Ibu<br> 
					Pekerjaan Ibu<br> 
					Penghasilan Perbulan<br> 
					Nomor Whatsapp Ortu<br> 
					Nomor Whatsapp Anak<br> 
					Alamat<br> 
					Kode Pos<br>
					Asal Sekolah<br>
				</td>
				<td style="width: 4%">
					:<br>
					:<br>
					:<br>
					:<br>
					:<br>
					:<br>
					:<br>
					:<br>
					@if($p->nama_ayah)
						:<br>
						:<br>
					@else
						:<br>
						:<br>
					@endif
					@if($p->nama_ibu)
						:<br>
						:<br>
					@else
						:<br>
						:<br>
					@endif
					:<br>
					:<br>
				
				</td>
				<td style="width: 48%">
					{{$p->no_nisn}}<br>
					{{$p->nama_calon_siswa}}<br>
					{{$p->tempat_lahir}}, {{date('d-m-Y', strtotime($p->tanggal_lahir))}}<br>
					{{$p->no_kartu_keluarga}}<br>
					{{$p->tinggi_badan}} cm<br>
					{{$p->berat_badan}} kg<br>
					{{$p->penyakit_kronis}}<br>
					{{$p->asal_sekolah}}<br>
					{{$p->nama_ayah ? $p->nama_ayah : '-'}}<br>
					{{$p->pekerjaan_ayah ? $p->pekerjaan_ayah : '-'}}<br>
					{{$p->nama_ibu ? $p->nama_ibu : '-'}}<br>
					{{$p->pekerjaan_ibu ? $p->pekerjaan_ibu : '-'}}<br>
					{{$p->penghasilan_per_bulan}}<br>
					{{$p->no_telepon_ortu}}<br>
					{{$p->no_wa_anak}}<br>
					{{$p->alamat_rumah 
					. ', ' . $p->dukuh 
					. ', ' . $p->kelurahan 
					. ', ' . $p->kecamatan
					. ', ' . $p->kabupaten
					}}
					{{$p->kodepos}}<br>
					{{$p->asal_sekolah}}<br>
				</td>
			</tr>
			
		</tbody>
	</table>
	<table style="width:100%;margin-left: auto;
	margin-right: auto;">
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 25%; border:solid 1px;text-align:
			 center;vertical-align:center;padding:30px;">
			<center>
				<h6>Pas Photo<br>3 x 4</h6>
			</center>
			</td>
			<td style="width: 40%"></td>
			<td style="width: 35%; text-align:
			 center;vertical-align:center;padding:30px;">
			<center>
				{{ "Surakarta, ".date('d-m-Y') }} <br>
				Calon Siswa <br><br><br><br>
				{{$p->nama_calon_siswa}}
			</center>
			</td>
		</tr>
	</table>
	@endforeach
</body>
</html>