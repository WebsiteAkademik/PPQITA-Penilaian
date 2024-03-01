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