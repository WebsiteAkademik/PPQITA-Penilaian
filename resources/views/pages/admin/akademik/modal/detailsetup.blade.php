<div class="modal fade" id="detail{{ $setup->id, $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Setup Mata Pelajaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="table-setup">
                        <tbody>
                            <tr>
                                <th>Mata Pelajaran :</th>
                                <td>{{ $row->mapelID()->nama_mata_pelajaran }}</td>
                            </tr>
                            <tr>
                                <th>KKM :</th>
                                <td>{{ $row->kkm }}</td>
                            </tr>
                            <tr>
                                <th>Jam Pelajaran yang harus diperoleh :</th>
                                <td>{{ $row->jam_pelajaran }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href ="{{ route('detail.edit', ['id' => $setup->id, 'id2' => $row->id]) }}" class="btn text-white" id="editSetup" style="background-color: #00569C;">Edit</a>
                </div>
            </div>
        </div>
    </div>