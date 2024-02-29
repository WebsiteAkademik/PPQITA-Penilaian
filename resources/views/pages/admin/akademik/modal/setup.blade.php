<div class="modal fade" id="detailSetup{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Setup Mata Pelajaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="table-setup">
                        <tbody>
                            <tr>
                                <th>Tahun Ajaran:</th>
                                <td>{{ $row->tahunajaranID()->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <th>Kelas:</th>
                                <td>{{ $row->kelasID()->kelas }}</td>
                            </tr>
                            <tr>
                                <th>Pengajar:</th>
                                <td>{{ $row->pengajarID()->nama_pengajar }}</td>
                            </tr>
                            <tr>
                                <th>Detail:</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <!-- <a href="" class="btn btn-primary m-3" id="editSetup">Edit</a> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href ="" class="btn text-white" style="background-color: #00569C;">Edit</button>
                </div>
            </div>
        </div>
    </div>