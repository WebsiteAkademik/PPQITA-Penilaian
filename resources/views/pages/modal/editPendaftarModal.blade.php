<form action="{{ route('pendaftar.update', $pendaftar->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editPendaftarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pendaftar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" aria-label="Status Select">
                            <option value="{{ $pendaftar->status }}" selected>Status Sekarang : <span
                                    class="text-capitalize">
                                    {{ ucwords($pendaftar->status) }}
                                </span>
                            </option>
                            <option value="open">Open</option>
                            <option value="testing">Testing</option>
                            <option value="wawancara">Wawancara</option>
                            <option value="diterima">Diterima</option>
                            <option value="tidak diterima">Tidak Diterima</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background-color: #00569C;">Edit</button>
                </div>
            </div>
        </div>
    </div>

</form>
