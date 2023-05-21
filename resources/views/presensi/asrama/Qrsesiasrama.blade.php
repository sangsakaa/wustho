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
        <div class="w-full sm:w-1/2 h-96">
          <h1 class="text-center">QR Code Reader</h1>
          <div id="video-container">
            <video id="video" width="450px"></video>
            <canvas id="canvas" width="450px" style="display:none;"></canvas>
            <div id="result"></div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/qr-scanner"></script>
          <script>
            window.onload = function() {
              const video = document.getElementById("video");
              const canvas = document.getElementById("canvas");
              const resultDiv = document.getElementById("result");
              const videoContainer = document.getElementById("video-container");

              // Menginisialisasi scanner QR
              const scanner = new QrScanner(video, result => {
                resultDiv.innerText = result;
                scanner.stop();
                videoContainer.classList.add("qr-detected");
              });

              // Mengaktifkan kamera saat halaman selesai dimuat
              scanner.start();
            };
          </script>
          <style>
            .qr-detected {
              border: 2px solid green;
            }
          </style>
        </div>


      </div>
    </div>
  </div>

</x-app-layout>