<div class="card-body p-4">
    <h5 class="section-title">1. Identitas Pasien</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="no_rm" class="form-label">No. Rekam Medis <span class="text-danger">*</span></label>
            <input type="text" id="no_rm" name="no_rm" placeholder="RM-000123"
                   class="form-control @error('no_rm') is-invalid @enderror"
                   value="{{ old('no_rm', $pasien->no_rm ?? '') }}">
            @error('no_rm') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-8">
            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" id="nama" name="nama" placeholder="Nama sesuai KTP"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama', $pasien->nama ?? '') }}">
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" id="nik" name="nik" maxlength="16" placeholder="16 digit NIK"
                   class="form-control @error('nik') is-invalid @enderror"
                   value="{{ old('nik', $pasien->nik ?? '') }}">
            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
            <input type="date" id="tgl_lahir" name="tgl_lahir"
                   class="form-control @error('tgl_lahir') is-invalid @enderror"
                   value="{{ old('tgl_lahir', $pasien->tgl_lahir ?? '') }}">
            @error('tgl_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
            @php $jk = old('jenis_kelamin', $pasien->jenis_kelamin ?? ''); @endphp
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" {{ $jk === 'Laki-laki' ? 'checked' : '' }}>
                <label class="form-check-label" for="jk_l">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" {{ $jk === 'Perempuan' ? 'checked' : '' }}>
                <label class="form-check-label" for="jk_p">Perempuan</label>
            </div>
            @error('jenis_kelamin') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label for="gol_darah" class="form-label">Golongan Darah</label>
            @php $gd = old('gol_darah', $pasien->gol_darah ?? '-'); @endphp
            <select id="gol_darah" name="gol_darah" class="form-select">
                <option value="-">-- Pilih --</option>
                @foreach (['A', 'B', 'AB', 'O'] as $g)
                    <option value="{{ $g }}" {{ $gd === $g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
            <input type="tel" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx"
                   class="form-control @error('no_hp') is-invalid @enderror"
                   value="{{ old('no_hp', $pasien->no_hp ?? '') }}">
            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <h5 class="section-title">2. Domisili</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea id="alamat" name="alamat" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
            <input type="text" id="kota" name="kota" placeholder="Bandung"
                   class="form-control @error('kota') is-invalid @enderror"
                   value="{{ old('kota', $pasien->kota ?? '') }}">
            @error('kota') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <h5 class="section-title">3. Kontak Darurat</h5>
    <div class="row g-3">
        <div class="col-md-5">
            <label for="darurat_nama" class="form-label">Nama Kontak <span class="text-danger">*</span></label>
            <input type="text" id="darurat_nama" name="darurat_nama"
                   class="form-control @error('darurat_nama') is-invalid @enderror"
                   value="{{ old('darurat_nama', $pasien->darurat_nama ?? '') }}">
            @error('darurat_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-3">
            <label for="darurat_hubungan" class="form-label">Hubungan</label>
            @php $hb = old('darurat_hubungan', $pasien->darurat_hubungan ?? 'Orang Tua'); @endphp
            <select id="darurat_hubungan" name="darurat_hubungan" class="form-select">
                @foreach (['Orang Tua', 'Suami/Istri', 'Saudara', 'Anak', 'Lainnya'] as $h)
                    <option value="{{ $h }}" {{ $hb === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="darurat_hp" class="form-label">No. HP Kontak <span class="text-danger">*</span></label>
            <input type="tel" id="darurat_hp" name="darurat_hp" placeholder="08xxxxxxxxxx"
                   class="form-control @error('darurat_hp') is-invalid @enderror"
                   value="{{ old('darurat_hp', $pasien->darurat_hp ?? '') }}">
            @error('darurat_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>