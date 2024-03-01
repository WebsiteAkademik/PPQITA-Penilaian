<form action="{{ route('siswa.updatekelas', $row->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="modal fade" id="updatekelas{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Kelas Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-select" required>
                            <option value="" disabled selected>Kelas</option>
                            @foreach ($kelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ $row->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
                            @endforeach
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
