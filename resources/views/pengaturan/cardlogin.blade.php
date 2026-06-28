<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Card Login')
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Dashboard Card User Account') }}
        </h2>
    </x-slot>

    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    <style>
        @media print {

            @page {
                size: F4 portrait;
                /* bisa diganti A4 */
                margin: 8mm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            #div1 {
                width: 100%;
            }

            .card-print {
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-column-break-inside: avoid;
            }

            .cards-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    {{-- TOOLBAR --}}
    <div class="p-2">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 p-3">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">

                    {{-- BUTTON --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <a href="/semester"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                            Kembali
                        </a>

                        <button
                            type="button"
                            onclick="printContent('div1')"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-md hover:bg-green-800 transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>

                            <span>Cetak Kartu</span>
                        </button>

                    </div>

                    {{-- FILTER KELAS --}}
                    <div class="flex justify-start md:justify-end">

                        <form action="/cardlogin" method="get" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">

                            <select
                                name="cari"
                                class="min-w-[220px] px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                <option value="" disabled {{ request('cari') ? '' : 'selected' }}>
                                    Pilih Kelas...
                                </option>

                                @foreach($kelasmi as $item)
                                <option
                                    value="{{ $item->nama_kelas }}"
                                    {{ request('cari') == $item->nama_kelas ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                                @endforeach

                            </select>

                            <button
                                type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 transition">
                                Cari
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- AREA CETAK --}}
    <div id="div1">

        <style>
            .page-break {
                page-break-after: always;
            }
        </style>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

            <div class="p-3">

                <div class="cards-container grid grid-cols-2 gap-2">

                    @foreach($peserta as $user)

                    <div class="card-print border border-green-600 rounded-md p-2 min-h-[170px]">

                        {{-- HEADER KARTU --}}
                        <div class="flex items-center">

                            <div class="pr-2">
                                <img src="{{ asset('asset/images/logo.png') }}"
                                    alt="Logo"
                                    width="50">
                            </div>

                            <div class="flex-1 text-center">

                                <p class="text-xs font-semibold uppercase">
                                    Madrasah Diniyah Wahidiyah
                                </p>

                                <p class="text-xs font-semibold uppercase">
                                    Madrasah Diniyah Wustho Wahidiyah
                                </p>

                            </div>

                        </div>

                        <hr class="my-1">

                        {{-- JUDUL --}}
                        <div class="text-center">
                            <p class="text-sm font-semibold uppercase">
                                Kartu Akun Siswa
                            </p>
                        </div>

                        {{-- DATA LOGIN --}}
                        <div class="grid grid-cols-2 mt-2 text-sm">

                            <div class="px-2">
                                Username
                            </div>

                            <div class="px-2">
                                : {{ $user->nis }}
                            </div>

                            <div class="px-2">
                                Password
                            </div>

                            <div class="px-2">
                                : {{ $user->nis }}
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="mt-3 text-right text-sm">

                            Nama pengguna :
                            <br>

                            <p class="font-semibold">
                                {{ $user->nama_siswa }}
                            </p>

                            <p class="text-xs">
                                Masa berlaku : aktif |
                                <b>Link : https://wustho.smedi.my.id/</b>
                            </p>

                        </div>

                    </div>

                    @endforeach

                </div>

                <div class="break-after-page"></div>

            </div>

        </div>

    </div>

</x-app-layout>