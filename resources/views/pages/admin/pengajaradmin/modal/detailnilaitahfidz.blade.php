<div class="modal fade" id="detailnilaiTahfidz{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Nilai Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="table-setup">
                        <tbody>
                            <tr>
                                <th>Tanggal Penilaian :</th>
                                <td>{{ $row->tanggal_penilaian }}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa :</th>
                                <td>{{ $row->siswaId()->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Kelas :</th>
                                <td>{{ $row->kelasId()->kelas }}</td>
                            </tr>
                            <tr>
                                <th>Mata Pelajaran :</th>
                                <td>{{ $row->mapelId()->nama_mata_pelajaran }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Penilaian :</th>
                                <td>{{ $row->jenis_penilaian }}</td>
                            </tr>
                            <tr>
                                <th>Surat Awal :</th>
                                <td>{{ $row->surat_awal }}</td>
                            </tr>
                            <tr>
                                <th>Surat Akhir :</th>
                                <td>{{ $row->surat_akhir }}</td>
                            </tr>
                            <tr>
                                <th>Ayat Awal :</th>
                                <td>{{ $row->ayat_awal }}</td>
                            </tr>
                            <tr>
                                <th>Ayat Akhir :</th>
                                <td>{{ $row->ayat_akhir }}</td>
                            </tr>
                            <tr>
                                <th>Nilai :</th>
                                <td>{{ $row->nilai }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan :</th>
                                <td>{{ $row->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran:</th>
                                <td>{{ $row->tahunID()->tahun_ajaran }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href ="{{ route('penilaiantahfidz.edit', $row->id) }}" class="btn text-white" id="editSetup" style="background-color: #00569C;">Edit</a>
                </div>
            </div>
        </div>
    </div>