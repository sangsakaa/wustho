<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Sesi Pesensi' )
    <h2 class="font-semibold text-xl  leading-tight">
      {{ __('Sesi Pesensi Asrama') }}
    </h2>
  </x-slot>


  <div class="px-4 mt-4 ">
    <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-2 ">
        <div class=" w-full sm:w-1/2">

          <h1 class="text-center">QR Code Reader</h1>
          <video id="video" style="width: 100%; height: auto;"></video>
          <canvas id="canvas" style="display: none;"></canvas>
          <div id="result"></div>

          <script src="https://cdn.jsdelivr.net/npm/qr-scanner"></script>
          <script>
            window.onload = function() {
              const video = document.getElementById("video");
              const canvas = document.getElementById("canvas");
              const resultDiv = document.getElementById("result");

              // Menginisialisasi scanner QR
              const scanner = new QrScanner(video, result => {
                resultDiv.innerText = result;
                scanner.stop();
              });

              // Mengaktifkan kamera saat halaman selesai dimuat
              scanner.start();

              // Mengatur proporsi video di perangkat seluler
              if (window.innerWidth <= 600) { // Ubah angka 600 sesuai dengan batas ukuran layar yang diinginkan
                video.style.height = "50%";
              }
            };
          </script>

        </div>
      </div>
    </div>

</x-app-layout>