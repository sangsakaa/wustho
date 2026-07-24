<x-app-layout>

  <x-slot name="header">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

      <div>

        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">

          Hosting Storage Analyzer

        </h2>

        <p class="text-sm text-slate-500">

          Analisis penggunaan storage hosting secara realtime.

        </p>

      </div>

      <div class="flex gap-2">

        <a href="{{ route('maintenance.hosting') }}"
          class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition">

          <i class="fas fa-rotate"></i>

          Scan Ulang

        </a>

        <button
          id="autoClean"
          class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">

          <i class="fas fa-broom"></i>

          Auto Clean

        </button>

      </div>

    </div>

  </x-slot>


  <div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

      {{-- ALERT --}}

      @if(session('success'))

      <div class="mb-5 rounded-xl bg-green-100 border border-green-300 p-4 text-green-700">

        {{ session('success') }}

      </div>

      @endif

      {{-- DASHBOARD --}}

      <div class="grid lg:grid-cols-4 gap-5 mb-6">

        <div class="rounded-2xl bg-white dark:bg-slate-800 shadow p-6">

          <div class="text-slate-500 text-sm">

            Total Folder

          </div>

          <div class="text-4xl font-bold mt-3">

            {{ count($result) }}

          </div>

        </div>

        <div class="rounded-2xl bg-white dark:bg-slate-800 shadow p-6">

          <div class="text-slate-500 text-sm">

            Total Size

          </div>

          <div class="text-4xl font-bold mt-3 text-indigo-600">

            {{ collect($result)->sum('bytes') > 0 ? number_format(collect($result)->sum('bytes')/1073741824,2) : 0 }}

            GB

          </div>

        </div>

        <div class="rounded-2xl bg-white dark:bg-slate-800 shadow p-6">

          <div class="text-slate-500 text-sm">

            Status

          </div>

          <div class="mt-3">

            @if(collect($result)->sum('bytes') > (5*1024*1024*1024))

            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">

              Storage Tinggi

            </span>

            @else

            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">

              Normal

            </span>

            @endif

          </div>

        </div>

        <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow p-6">

          <div class="text-sm opacity-90">

            Potensi Dibersihkan

          </div>

          <div class="text-4xl font-bold mt-3">

            {{ number_format(collect($result)->where('cleanable',true)->sum('bytes')/1073741824,2) }}

            GB

          </div>

        </div>

      </div>

      {{-- STORAGE BAR --}}

      @php

      $totalHosting = 7*1024*1024*1024;

      $used = collect($result)->sum('bytes');

      $percent = min(($used/$totalHosting)*100,100);

      @endphp

      <div class="rounded-2xl bg-white dark:bg-slate-800 shadow p-6 mb-6">

        <div class="flex justify-between mb-3">

          <div class="font-semibold">

            Hosting Usage

          </div>

          <div>

            {{ number_format($percent,1) }} %

          </div>

        </div>

        <div class="w-full bg-slate-200 rounded-full h-5 overflow-hidden">

          <div

            class="h-5 rounded-full

@if($percent>90)

bg-red-600

@elseif($percent>70)

bg-yellow-500

@else

bg-green-500

@endif"

            style="width:{{$percent}}%">

          </div>

        </div>

        <div class="mt-3 text-sm text-slate-500">

          {{ number_format($used/1073741824,2) }}

          GB

          /

          7 GB

        </div>

      </div>

      {{-- SEARCH --}}

      <div class="mb-5">

        <input

          id="search"

          class="w-full rounded-xl border-slate-300 shadow-sm"

          placeholder="Cari folder...">

      </div>
      {{-- ========================= --}}
      {{-- FOLDER ANALYZER --}}
      {{-- ========================= --}}

      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow overflow-hidden">

        <div class="px-6 py-4 border-b dark:border-slate-700 flex items-center justify-between">

          <div>

            <h3 class="text-lg font-bold text-slate-800 dark:text-white">

              📁 Folder Storage Analyzer

            </h3>

            <p class="text-sm text-slate-500">

              Folder terbesar pada hosting Anda.

            </p>

          </div>

          <div>

            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs">

              {{ count($result) }} Folder

            </span>

          </div>

        </div>

        <div class="overflow-x-auto">

          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">

            <thead class="bg-slate-50 dark:bg-slate-900">

              <tr>

                <th class="px-6 py-3 text-left">

                  Folder

                </th>

                <th class="px-6 py-3 text-left">

                  Path

                </th>

                <th class="px-6 py-3 text-center">

                  Size

                </th>

                <th class="px-6 py-3 text-center">

                  Status

                </th>

                <th class="px-6 py-3 text-center">

                  Recommendation

                </th>

                <th class="px-6 py-3 text-center">

                  Action

                </th>

              </tr>

            </thead>

            <tbody id="folderTable" class="divide-y divide-slate-100 dark:divide-slate-700">

              @foreach($result as $row)

              @php

              $recommend = 'Normal';

              $recommendColor = 'green';

              $icon = '📁';

              $delete = false;

              $name = strtolower($row['name']);

              if(str_contains($name,'log')){

              $recommend='Boleh dibersihkan';

              $recommendColor='yellow';

              $delete=true;

              $icon='📜';

              }

              elseif(str_contains($name,'cache')){

              $recommend='Cache dapat dihapus';

              $recommendColor='yellow';

              $delete=true;

              $icon='⚡';

              }

              elseif(str_contains($name,'session')){

              $recommend='Session lama';

              $recommendColor='yellow';

              $delete=true;

              $icon='🧹';

              }

              elseif(str_contains($name,'backup')){

              $recommend='Backup lama dapat dihapus';

              $recommendColor='red';

              $delete=true;

              $icon='💾';

              }

              elseif(str_contains($name,'vendor')){

              $recommend='Jangan dihapus';

              $recommendColor='gray';

              $icon='🔒';

              }

              elseif(str_contains($name,'mail')){

              $recommend='Periksa Email Hosting';

              $recommendColor='red';

              $icon='📧';

              }

              @endphp

              <tr class="hover:bg-slate-50 dark:hover:bg-slate-700">

                <td class="px-6 py-4">

                  <div class="font-semibold">

                    {{ $icon }}

                    {{ $row['name'] }}

                  </div>

                </td>

                <td class="px-6 py-4">

                  <div class="text-xs text-slate-500 break-all">

                    {{ $row['path'] }}

                  </div>

                </td>

                <td class="px-6 py-4 text-center">

                  <span class="font-bold">

                    {{ $row['size'] }}

                  </span>

                </td>

                <td class="px-6 py-4 text-center">

                  @if($row['status']=="danger")

                  <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">

                    Danger

                  </span>

                  @elseif($row['status']=="warning")

                  <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">

                    Warning

                  </span>

                  @else

                  <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">

                    Normal

                  </span>

                  @endif

                </td>

                <td class="px-6 py-4">

                  <span class="px-3 py-1 rounded-full

                                @if($recommendColor=='red')

                                    bg-red-100 text-red-700

                                @elseif($recommendColor=='yellow')

                                    bg-yellow-100 text-yellow-700

                                @elseif($recommendColor=='gray')

                                    bg-slate-200 text-slate-700

                                @else

                                    bg-green-100 text-green-700

                                @endif">

                    {{ $recommend }}

                  </span>

                </td>

                <td class="px-6 py-4 text-center">

                  <div class="flex justify-center gap-2">

                    <button

                      class="detailBtn px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700"

                      data-path="{{ $row['path'] }}">

                      Detail

                    </button>

                    @if($delete)

                    <form

                      method="POST"

                      action="{{ route('maintenance.delete.folder') }}">

                      @csrf

                      <input

                        type="hidden"

                        name="path"

                        value="{{ $row['path'] }}">

                      <button

                        onclick="return confirm('Hapus folder ini?')"

                        class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">

                        Delete

                      </button>

                    </form>

                    @endif

                  </div>

                </td>

              </tr>

              @endforeach

            </tbody>

          </table>

        </div>

      </div>
    </div>
  </div>
</x-app-layout>