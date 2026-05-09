<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-bold">Scan QR Presensi</h2>
  </x-slot>

  <div id="toast"
    class="hidden fixed top-5 right-5 z-50 px-4 py-3 rounded-lg shadow-lg text-white"></div>

  <div class="p-4 md:p-6">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-5">

      <h3 class="text-center text-lg font-semibold mb-4">
        Arahkan kamera ke QR Code
      </h3>

      <div id="reader" class="w-full border rounded-xl overflow-hidden"></div>

      <div id="result" class="mt-4 text-center text-lg font-semibold">
        Menunggu scan...
      </div>

      <button id="scanAgain"
        onclick="startScanner()"
        class="hidden mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-lg">
        Scan Lagi
      </button>

      <div class="mt-6">
        <h3 class="text-sm font-semibold mb-2">Riwayat Hari Ini</h3>
        <div id="logAbsensi" class="space-y-2 max-h-72 overflow-y-auto"></div>
      </div>

    </div>
  </div>

  <script src="https://unpkg.com/html5-qrcode"></script>

  <script>
    let html5QrCode;
    let lock = false;

    function showToast(msg, type = 'success') {
      const t = document.getElementById('toast');
      t.className = `fixed top-5 right-5 px-4 py-3 text-white rounded-lg ${type==='success'?'bg-green-600':'bg-red-600'}`;
      t.innerHTML = msg;
      t.classList.remove('hidden');

      setTimeout(() => t.classList.add('hidden'), 2000);
    }

    function setResult(msg, ok = null) {
      const r = document.getElementById('result');
      r.innerHTML = msg;
      r.className = "mt-4 text-center font-semibold " +
        (ok === true ? 'text-green-600' : ok === false ? 'text-red-600' : 'text-gray-700');
    }

    function addLog(data) {
      const log = document.getElementById('logAbsensi');

      const div = document.createElement('div');
      div.className = "p-3 border rounded bg-gray-50 text-sm";

      div.innerHTML = `
        <b>${data.data?.nama ?? '-'}</b><br>
        NIS: ${data.data?.nis ?? '-'} | ${new Date().toLocaleTimeString()}
      `;

      log.prepend(div);
    }

    async function startScanner() {
      document.getElementById('scanAgain').classList.add('hidden');
      setResult('Menunggu scan...');

      html5QrCode = new Html5Qrcode("reader");

      await html5QrCode.start({
          facingMode: "environment"
        }, {
          fps: 10,
          qrbox: 250
        },
        onScan
      );
    }

    async function stopScanner() {
      if (html5QrCode) {
        await html5QrCode.stop();
        await html5QrCode.clear();
      }
    }

    function onScan(decodedText) {
      if (lock) return;
      lock = true;

      setResult("Memproses...");

      fetch("{{ route('qr.scan.store') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
          },
          body: JSON.stringify({
            nis: decodedText
          })
        })
        .then(r => r.json())
        .then(async res => {
          setResult(res.message, res.success);
          addLog(res);
          showToast(res.message, res.success ? 'success' : 'error');

          await stopScanner();

          setTimeout(() => lock = false, 5000);
        })
        .catch(async () => {
          setResult("Error sistem", false);
          showToast("Error sistem", "error");

          await stopScanner();
          lock = false;
        });
    }

    startScanner();
  </script>
</x-app-layout>