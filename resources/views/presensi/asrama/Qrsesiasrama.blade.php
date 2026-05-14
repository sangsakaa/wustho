<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Scan QR Presensi')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Scan QR Presensi</h2>
        <p class="text-sm text-gray-500">Sistem absensi real-time berbasis QR Code</p>
      </div>

      <div class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-600">
        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
      </div>
    </div>
  </x-slot>

  {{-- TOAST --}}
  <div id="toast"
    class="hidden fixed top-4 right-4 z-50 px-4 py-2 text-white rounded-lg shadow-lg"></div>

  <div class="   h-full overflow-hidden bg-gray-50 p-4">

    <div class="max-w-7xl mx-auto h-full">

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 h-full">

        {{-- LEFT --}}
        <div class="lg:col-span-2 flex flex-col gap-5   h-fit">

          {{-- SCANNER CARD --}}
          <div class="bg-white rounded-2xl shadow-lg border flex-1 flex flex-col overflow-hidden">

            {{-- HEADER SCANNER (FULL MODERN) --}}
            <div class="flex items-center justify-between px-5 py-4 border-b bg-gradient-to-r from-gray-50 to-white">

              <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <h3 class="text-sm font-semibold tracking-wide text-gray-800">
                  SCANNER QR PRESENSI
                </h3>
              </div>

              <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[11px] font-semibold text-green-600 tracking-wider">
                  LIVE
                </span>
              </div>

            </div>

            {{-- CAMERA AREA --}}
            <div class="flex-1 flex items-center justify-center p-3 md:p-6 bg-gray-50">

              <div class="relative w-full max-w-[329px] aspect-square rounded-3xl bg-black shadow-2xl overflow-hidden">

                {{-- INNER CAMERA FRAME --}}
                <div class="absolute inset-2 rounded-2xl overflow-hidden">
                  <div id="reader" class="w-full h-full"></div>
                </div>

                {{-- overlay --}}
                <div class="absolute inset-0 border-2 border-dashed border-white/40 pointer-events-none rounded-3xl"></div>

                {{-- glow --}}
                <div class="absolute inset-0 ring-2 ring-green-400/10 rounded-3xl"></div>

              </div>
            </div>

            {{-- RESULT --}}
            <div id="result"
              class="py-4 text-center text-base font-semibold text-gray-600">
              Menunggu scan...
            </div>

          </div>

          {{-- STATUS --}}
          <div class="grid grid-cols-3 gap-3 h-[80px]">

            <div class="bg-white rounded-xl shadow-sm border flex flex-col justify-center items-center">
              <p class="text-[11px] text-gray-500">Kamera</p>
              <p class="text-sm font-semibold text-green-600">Aktif</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border flex flex-col justify-center items-center">
              <p class="text-[11px] text-gray-500">Mode</p>
              <p class="text-sm font-semibold text-blue-600">Realtime</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border flex flex-col justify-center items-center">
              <p class="text-[11px] text-gray-500">Update</p>
              <p class="text-sm font-semibold text-gray-700">5s</p>
            </div>

          </div>

        </div>

        {{-- RIGHT --}}
        <div class="bg-white rounded-2xl shadow-lg border flex flex-col h-full overflow-hidden">

          {{-- HEADER STICKY --}}
          <div class="px-4 py-3 border-b bg-gray-50 sticky top-0 z-10">
            <h3 class="text-sm font-semibold text-gray-800">🧾 Riwayat Absensi</h3>
            <p class="text-xs text-gray-500">Realtime update</p>
          </div>

          {{-- LIST (FIX HEIGHT + SCROLL) --}}
          <div id="logAbsensi"
            class="flex-1 overflow-y-auto bg-gray-50 p-2 space-y-2 max-h-[520px]">

            <div class="text-center text-gray-400 text-sm py-6">
              Belum ada data presensi
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>

  <script src="https://unpkg.com/html5-qrcode"></script>

  <script>
    const audioCtx = new(window.AudioContext || window.webkitAudioContext)();

    function playBeep(type = "success") {
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();

      osc.connect(gain);
      gain.connect(audioCtx.destination);

      osc.type = "sine";
      osc.frequency.value = type === "success" ? 900 : 300;
      gain.gain.value = 0.08;

      osc.start();
      setTimeout(() => osc.stop(), 150);
    }

    let html5QrCode;
    let lockScan = false;

    function showToast(message, type = 'success') {
      const toast = document.getElementById('toast');

      toast.className =
        `fixed top-4 right-4 z-50 px-4 py-2 text-white rounded-lg shadow-lg ${
          type === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;

      toast.innerHTML = message;
      toast.classList.remove('hidden');

      setTimeout(() => toast.classList.add('hidden'), 1800);
    }

    function setResult(message, success = null) {
      const el = document.getElementById('result');

      el.innerHTML = message;

      el.className =
        "py-4 text-center text-base font-semibold " +
        (success === true ? "text-green-600" :
          success === false ? "text-red-600" :
          "text-gray-600");
    }

    async function onScanSuccess(decodedText) {
      if (lockScan) return;
      lockScan = true;

      setResult("Memproses...", null);

      try {
        const response = await fetch("{{ route('qr.scan.store') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            nis: decodedText
          })
        });

        const res = await response.json();

        setResult(res.message, res.success);
        showToast(res.message, res.success ? "success" : "error");

        playBeep(res.success ? "success" : "error");

        await loadTodayLog();

      } catch (e) {
        setResult("Error sistem", false);
        showToast("Error sistem", "error");
        playBeep("error");
      }

      setTimeout(() => lockScan = false, 900);
    }

    async function loadTodayLog() {
      try {
        const res = await fetch("{{ url('/qr/today-log') }}?t=" + Date.now());
        let data = await res.json();

        const container = document.getElementById('logAbsensi');
        container.innerHTML = '';

        if (!data?.length) {
          container.innerHTML = `
        <div class="text-center text-gray-400 text-sm py-6">
          Belum ada data
        </div>`;
          return;
        }

        // 🔥 LIMIT 8 DATA TERBARU
        data = data.slice(0, 8);

        data.forEach(item => {
          const div = document.createElement('div');

          div.className = "bg-white border rounded-lg p-2 shadow-sm";

          div.innerHTML = `
        <div class="flex justify-between items-start gap-2">

          <div class="min-w-0">
            <div class="font-semibold text-sm truncate">
              ${item.nama ?? '-'}
            </div>

            <div class="text-[11px] text-gray-500">
              NIS: ${item.nis ?? '-'}
            </div>

            <div class="text-[11px] text-blue-500 font-medium">
              Kelas: ${item.kelas ?? '-'}
            </div>
          </div>

          <div class="text-[10px] text-gray-500 whitespace-nowrap">
            ${item.waktu ?? '-'}
          </div>

        </div>
      `;

          container.appendChild(div);
        });

      } catch (e) {
        console.error(e);
      }
    }

    async function startScanner() {
      try {
        html5QrCode = new Html5Qrcode("reader");

        await html5QrCode.start({
            facingMode: "environment"
          }, {
            fps: 10,
            qrbox: {
              width: 220,
              height: 220
            }
          },
          onScanSuccess
        );

        setResult("Kamera aktif", true);

      } catch (e) {
        setResult("Gagal kamera", false);
        showToast("Gagal kamera", "error");
        playBeep("error");
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      startScanner();
      loadTodayLog();
      setInterval(loadTodayLog, 5000);
    });
  </script>

  <style>
    #reader {
      width: 100% !important;
      height: 100% !important;
    }

    #reader video {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover !important;
    }

    #reader__dashboard {
      display: none !important;
    }
  </style>

</x-app-layout>