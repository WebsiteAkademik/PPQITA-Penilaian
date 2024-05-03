<div class="modal fade" id="detailnilaiPelajaran{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <th>Jenis Ujian :</th>
                                <td>{{ $row->jenis_ujian }}</td>
                            <tr>
                                <th>Nilai :</th>
                                <td>{{ $row->nilai }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan :</th>
                                <td>{{ $row->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Semester :</th>
                                <td>{{ $row->semester }}</td>
                            <tr>
                                <th>Tahun Ajaran:</th>
                                <td>{{ $row->tahunID()->tahun_ajaran }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href ="{{ route('penilaianpelajaran.edit', $row->id) }}" class="btn text-white" id="editSetup" style="background-color: #00569C;">Edit</a>
                </div>
            </div>
        </div>
    </div>