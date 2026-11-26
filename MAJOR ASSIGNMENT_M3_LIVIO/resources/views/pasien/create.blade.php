<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="border-l-4 border-teal-700 pl-4">
                <h2 class="text-2xl font-bold text-gray-900">🪪 Form Pendaftaran Pasien</h2>
                <p class="text-gray-500">Isi data profil pasien, nomor rekam medis, domisili, dan kontak darurat.</p>
            </div>

            <form action="{{ route('pasien.store') }}" method="POST" class="bg-white rounded-md shadow-sm overflow-hidden">
                @csrf

                @include('pasien._form')

                <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t">
                    <button type="reset" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">Reset</button>
                    <button type="submit" class="px-4 py-2 rounded-md bg-teal-700 hover:bg-teal-800 text-white shadow">Simpan Pasien</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>