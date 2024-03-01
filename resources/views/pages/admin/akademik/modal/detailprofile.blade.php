<div class="modal fade" id="detailprofile{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Profil Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="table-setup">
                        <tbody>
                            <tr>
                                <th>NISN :</th>
                                <td>{{ $row->no_nisn }}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa :</th>
                                <td>{{ $row->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir :</th>
                                <td>{{ $row->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir :</th>
                                <td>{{ $row->tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin :</th>
                                <td>{{ $row->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>No Kartu Keluarga :</th>
                                <td>{{ $row->no_kartu_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>No Induk Keluarga :</th>
                                <td>{{ $row->no_induk_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>Agama :</th>
                                <td>{{ $row->agama }}</td>
                            </tr>
                            <tr>
                                <th>Tinggi Badan :</th>
                                <td>{{ $row->tinggi_badan }}</td>
                            </tr>
                            <tr>
                                <th>Berat Badan :</th>
                                <td>{{ $row->berat_badan }}</td>
                            </tr>
                            <tr>
                                <th>Nomor WA Anak :</th>
                                <td>{{ $row->no_wa_anak }}</td>
                            </tr>
                            <tr>
                                <th>Penyakit Kronis :</th>
                                <td>{{ $row->penyakit_kronis }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Rumah :</th>
                                <td>{{ $row->alamat_rumah }}</td>
                            </tr>
                            <tr>
                                <th>Dukuh :</th>
                                <td>{{ $row->dukuh }}</td>
                            </tr>
                            <tr>
                                <th>Kelurahan :</th>
                                <td>{{ $row->kelurahan }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan :</th>
                                <td>{{ $row->kecamatan }}</td>
                            </tr>
                            <tr>
                                <th>Kabupaten :</th>
                                <td>{{ $row->kabupaten }}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos :</th>
                                <td>{{ $row->kodepos }}</td>
                            </tr>
                            <tr>
                                <th>Asal Sekolah :</th>
                                <td>{{ $row->asal_sekolah }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ayah :</th>
                                <td>{{ $row->nama_ayah }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ayah :</th>
                                <td>{{ $row->pekerjaan_ayah }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu :</th>
                                <td>{{ $row->nama_ibu }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ibu :</th>
                                <td>{{ $row->pekerjaan_ibu }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon Ortu :</th>
                                <td>{{ $row->no_telepon_ortu }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href ="{{ route('siswa.edit', $row->id) }}" class="btn text-white" id="editProfil" style="background-color: #00569C;">Edit</a>
                </div>
            </div>
        </div>
    </div>