<x-app-layout>
    @php
        $isStaff = in_array(auth()->user()->role, ['admin', 'doctor', 'nurse']);
        $isAdmin = auth()->user()->role === 'admin';
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-4 border-l-4 border-teal-700 pl-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">👥 Data Pasien</h2>
                    <p class="text-gray-500">Daftar pasien yang sudah terdaftar.</p>
                </div>

                @if ($isStaff)
                    <a href="{{ route('pasien.index', ['tambah' => 1]) }}"
                       class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-md shadow">
                        + Tambah Pasien
                    </a>
                @endif
            </div>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-md shadow-sm border-t-4 border-teal-700 p-5">
                    <div class="text-sm text-gray-500">Total Pasien</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pasiens->count() }}</div>
                </div>
                <div class="bg-white rounded-md shadow-sm border-t-4 border-teal-700 p-5">
                    <div class="text-sm text-gray-500">Laki-laki</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pasiens->where('jenis_kelamin', 'Laki-laki')->count() }}</div>
                </div>
                <div class="bg-white rounded-md shadow-sm border-t-4 border-teal-700 p-5">
                    <div class="text-sm text-gray-500">Perempuan</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pasiens->where('jenis_kelamin', 'Perempuan')->count() }}</div>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="bg-white rounded-md shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-teal-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                            <th class="px-4 py-3 text-left font-semibold">L/P</th>
                            <th class="px-4 py-3 text-left font-semibold">Umur</th>
                            <th class="px-4 py-3 text-left font-semibold">Gol. Darah</th>
                            <th class="px-4 py-3 text-left font-semibold">No. HP</th>
                            <th class="px-4 py-3 text-left font-semibold">Domisili</th>
                            <th class="px-4 py-3 text-left font-semibold">Kontak Darurat</th>
                            @if ($isStaff)
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pasiens as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded bg-teal-100 text-teal-800 text-xs font-semibold">{{ $p->no_rm }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900">{{ $p->nama }}</div>
                                    <div class="text-xs text-gray-500">NIK: {{ $p->nik ?: '-' }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $p->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($p->tgl_lahir)->age }} th</td>
                                <td class="px-4 py-3">{{ $p->gol_darah }}</td>
                                <td class="px-4 py-3">{{ $p->no_hp }}</td>
                                <td class="px-4 py-3">
                                    <div>{{ $p->alamat }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->kota }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>{{ $p->darurat_nama }} <span class="text-xs text-gray-500">({{ $p->darurat_hubungan }})</span></div>
                                    <div class="text-xs text-gray-500">{{ $p->darurat_hp }}</div>
                                </td>

                                @if ($isStaff)
                                    <td class="px-4 py-3 whitespace-nowrap space-x-3">
                                        <a href="{{ route('pasien.edit', $p) }}"
                                           class="px-3 py-1 rounded border border-blue-500 text-blue-600 hover:bg-blue-50">Edit</a>

                                        @if ($isAdmin)
                                            <form action="{{ route('pasien.destroy', $p) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Yakin hapus data pasien ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1 rounded border border-red-500 text-red-600 hover:bg-red-50">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-6 text-center text-gray-500">Belum ada data pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center text-xs text-gray-500">
                Sistem Informasi Klinik Rawat Jalan
            </div>
        </div>
    </div>
</x-app-layout>