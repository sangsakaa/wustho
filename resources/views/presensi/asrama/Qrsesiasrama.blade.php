<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Scan QR Presensi')

    <div class="flex justify-between items-center">
      <h2 class="text-xl font-bold">Scan QR Presensi</h2>
      <span class="text-sm text-gray-500">
        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
      </span>
    </div>
  </x-slot>

  {{-- TOAST --}}
  <div id="toast"
    class="hidden fixed top-5 right-5 z-50 px-4 py-3 text-white rounded-lg shadow-lg transition-all duration-300">
  </div>

  <div class="p-4 md:p-6">
    <div class="max-w-7xl mx-auto">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- CAMERA --}}
        <div class="bg-white shadow-xl rounded-2xl p-5">
          <h3 class="text-center text-lg font-semibold mb-4">
            Arahkan kamera ke QR Code
          </h3>

          <div id="reader"
            class="w-full aspect-square lg:aspect-[4/3] border rounded-xl overflow-hidden">
          </div>

          <div id="result"
            class="mt-4 text-center text-lg font-semibold text-gray-700">
            Menunggu scan...
          </div>
        </div>

        {{-- LOG --}}
        <div class="bg-white shadow-xl rounded-2xl p-5">
          <h3 class="text-lg font-semibold mb-3">
            Riwayat Absensi Hari Ini
          </h3>

          <div id="logAbsensi"
            class="space-y-2 overflow-y-auto h-[500px] pr-2 border rounded-lg p-3 bg-gray-50">
            <div class="text-gray-400 text-sm">
              Belum ada data...
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://unpkg.com/html5-qrcode"></script>

  <script>
    let html5QrCode;
    let lockScan = false;

    // ================= TOAST =================
    function showToast(message, type = 'success') {
      const toast = document.getElementById('toast');

      toast.className =
        `fixed top-5 right-5 z-50 px-4 py-3 text-white rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            }`;

      toast.innerHTML = message;
      toast.classList.remove('hidden');

      setTimeout(() => {
        toast.classList.add('hidden');
      }, 2500);
    }

    // ================= RESULT =================
    function setResult(message, success = null) {
      const result = document.getElementById('result');

      result.innerHTML = message;
      result.className =
        "mt-4 text-center text-lg font-semibold " +
        (success === true ?
          "text-green-600" :
          success === false ?
          "text-red-600" :
          "text-gray-700");
    }

    // ================= SOUND =================
    function playBeep() {
      const audio = new Audio(
        "https://actions.google.com/sounds/v1/alarms/beep_short.ogg"
      );
      audio.play();
    }

    function speak(text) {
      const msg = new SpeechSynthesisUtterance(text);
      msg.lang = 'id-ID';
      msg.rate = 1;
      window.speechSynthesis.speak(msg);
    }

    function notifySuccess(text) {
      playBeep();
      speak(text);
    }

    // ================= LOAD LOG =================
    async function loadTodayLog() {
      try {
        const res = await fetch("{{ url('/qr/today-log') }}?t=" + Date.now(), {
          cache: 'no-store'
        });

        const data = await res.json();
        const container = document.getElementById('logAbsensi');

        container.innerHTML = '';

        if (!Array.isArray(data) || data.length === 0) {
          container.innerHTML = `
                        <div class="text-gray-400 text-sm">
                            Belum ada data...
                        </div>
                    `;
          return;
        }

        data.forEach(item => {
          const div = document.createElement('div');
          div.className =
            "p-3 border rounded bg-white shadow-sm text-sm";

          div.innerHTML = `
                        <div class="font-semibold text-gray-800">
                            ${item.nama ?? '-'}
                        </div>

                        <div class="text-xs text-gray-500 mt-1">
                            NIS: ${item.nis ?? '-'}
                        </div>

                        <div class="text-xs text-blue-600">
                            Kelas: ${item.kelas ?? '-'}
                        </div>

                        <div class="text-xs text-gray-400">
                            ${item.waktu ?? '-'}
                        </div>
                    `;

          container.appendChild(div);
        });

      } catch (error) {
        console.error(error);
      }
    }

    // ================= SCAN =================
    async function onScanSuccess(decodedText) {
      if (lockScan) return;
      lockScan = true;

      setResult('Memproses...', null);

      try {
        const response = await fetch("{{ route('qr.scan.store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
              'meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            nis: decodedText
          })
        });

        const res = await response.json();

        setResult(res.message, res.success);
        showToast(res.message, res.success ? 'success' : 'error');

        if (res.success) {
          notifySuccess('Presensi berhasil');
        }

        await loadTodayLog();

      } catch (error) {
        console.error(error);
        setResult('Terjadi kesalahan sistem', false);
        showToast('Terjadi kesalahan sistem', 'error');
      }

      setTimeout(() => {
        lockScan = false;
      }, 1500);
    }

    // ================= START CAMERA =================
    async function startScanner() {
      try {
        html5QrCode = new Html5Qrcode("reader");

        await html5QrCode.start({
            facingMode: "environment"
          }, {
            fps: 10,
            qrbox: 250
          },
          onScanSuccess
        );

        setResult('Kamera siap, silakan scan QR');
      } catch (error) {
        console.error(error);
        setResult('Gagal membuka kamera', false);
        showToast('Gagal membuka kamera', 'error');
      }
    }

    // ================= INIT =================
    document.addEventListener('DOMContentLoaded', function() {
      startScanner();
      loadTodayLog();

      // auto refresh log tiap 5 detik
      setInterval(loadTodayLog, 5000);
    });
  </script>
</x-app-layout>