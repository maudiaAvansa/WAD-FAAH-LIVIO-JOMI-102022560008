@php
    $pasien = $pasien ?? null;
    $v = fn ($name) => old($name, $pasien?->{$name});
    $inp = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-600 focus:ring-teal-600';
    $lbl = 'block text-sm font-medium text-gray-700';
@endphp

<div class="p-6 space-y-6">

    {{-- 1. Identitas --}}
    <div>
        <h3 class="text-lg font-semibold text-teal-800 border-b-2 border-teal-100 pb-2 mb-4">1. Identitas Pasien</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1">
                <label for="no_rm" class="{{ $lbl }}">No. Rekam Medis <span class="text-red-500">*</span></label>
                <input id="no_rm" name="no_rm" type="text" value="{{ $v('no_rm') }}" placeholder="RM-000123" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('no_rm')" class="mt-1" />
            </div>

            <div class="md:col-span-2">
                <label for="nama" class="{{ $lbl }}">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="nama" name="nama" type="text" value="{{ $v('nama') }}" placeholder="Nama sesuai KTP" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('nama')" class="mt-1" />
            </div>

            <div>
                <label for="nik" class="{{ $lbl }}">NIK</label>
                <input id="nik" name="nik" type="text" value="{{ $v('nik') }}" placeholder="16 digit NIK" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('nik')" class="mt-1" />
            </div>

            <div>
                <label for="tgl_lahir" class="{{ $lbl }}">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input id="tgl_lahir" name="tgl_lahir" type="date" value="{{ $v('tgl_lahir') }}" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('tgl_lahir')" class="mt-1" />
            </div>

            <div>
                <span class="{{ $lbl }}">Jenis Kelamin <span class="text-red-500">*</span></span>
                <div class="mt-2 flex gap-5 text-gray-700">
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="text-teal-700 focus:ring-teal-600" @checked($v('jenis_kelamin') === 'Laki-laki')>
                        Laki-laki
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="text-teal-700 focus:ring-teal-600" @checked($v('jenis_kelamin') === 'Perempuan')>
                        Perempuan
                    </label>
                </div>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-1" />
            </div>

            <div>
                <label for="gol_darah" class="{{ $lbl }}">Golongan Darah <span class="text-red-500">*</span></label>
                <select id="gol_darah" name="gol_darah" class="{{ $inp }}">
                    <option value="">-- Pilih --</option>
                    @foreach (['-', 'A', 'B', 'AB', 'O'] as $gd)
                        <option value="{{ $gd }}" @selected($v('gol_darah') === $gd)>{{ $gd }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gol_darah')" class="mt-1" />
            </div>

            <div>
                <label for="no_hp" class="{{ $lbl }}">No. HP <span class="text-red-500">*</span></label>
                <input id="no_hp" name="no_hp" type="text" value="{{ $v('no_hp') }}" placeholder="08xxxxxxxxxx" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
            </div>
        </div>
    </div>

    {{-- 2. Domisili --}}
    <div>
        <h3 class="text-lg font-semibold text-teal-800 border-b-2 border-teal-100 pb-2 mb-4">2. Domisili</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label for="alamat" class="{{ $lbl }}">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" class="{{ $inp }}">{{ $v('alamat') }}</textarea>
                <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
            </div>

            <div>
                <label for="kota" class="{{ $lbl }}">Kota/Kabupaten <span class="text-red-500">*</span></label>
                <input id="kota" name="kota" type="text" value="{{ $v('kota') }}" placeholder="Bandung" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('kota')" class="mt-1" />
            </div>
        </div>
    </div>

    {{-- 3. Kontak Darurat --}}
    <div>
        <h3 class="text-lg font-semibold text-teal-800 border-b-2 border-teal-100 pb-2 mb-4">3. Kontak Darurat</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="darurat_nama" class="{{ $lbl }}">Nama Kontak <span class="text-red-500">*</span></label>
                <input id="darurat_nama" name="darurat_nama" type="text" value="{{ $v('darurat_nama') }}" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('darurat_nama')" class="mt-1" />
            </div>

            <div>
                <label for="darurat_hubungan" class="{{ $lbl }}">Hubungan</label>
                <select id="darurat_hubungan" name="darurat_hubungan" class="{{ $inp }}">
                    @foreach (['Orang Tua', 'Suami/Istri', 'Saudara', 'Anak', 'Lainnya'] as $h)
                        <option value="{{ $h }}" @selected($v('darurat_hubungan') === $h)>{{ $h }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('darurat_hubungan')" class="mt-1" />
            </div>

            <div>
                <label for="darurat_hp" class="{{ $lbl }}">No. HP Kontak <span class="text-red-500">*</span></label>
                <input id="darurat_hp" name="darurat_hp" type="text" value="{{ $v('darurat_hp') }}" placeholder="08xxxxxxxxxx" class="{{ $inp }}">
                <x-input-error :messages="$errors->get('darurat_hp')" class="mt-1" />
            </div>
        </div>
    </div>

</div>