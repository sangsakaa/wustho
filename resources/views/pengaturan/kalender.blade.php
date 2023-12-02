<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Live' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Kalender Pendidikan Diniyah Wustha') }}
    </h2>
  </x-slot>
  <style>
    .page-break {
      page-break-after: always;
    }
  </style>
  <script>
    function printContent(el) {
      var fullbody = document.body.innerHTML;
      var printContent = document.getElementById(el).innerHTML;
      document.body.innerHTML = printContent;
      window.print();
      document.body.innerHTML = fullbody;
    }
  </script>
  <div class=" p-4 bg-white ">
    @foreach ($calendar as $month)
    <h2>{{ $month['month'] }}</h2>
    <div class="grid grid-cols-7 gap-2">
      @foreach ($month['days'] as $day)
      <div class="{{ \Carbon\Carbon::parse($day)->isoFormat('dddd') === 'Kamis' ? 'bg-red-200' : (\Carbon\Carbon::parse($day)->isToday() ? 'bg-red-700' : '') }} px-4 py-4">
        {{ $day->format('d') }} <br>
        {{ \Carbon\Carbon::parse($day)->isoFormat('dddd') }}
      </div>


      @endforeach
    </div>
    @endforeach
  </div>
</x-app-layout>