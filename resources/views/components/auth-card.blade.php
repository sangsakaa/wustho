<main class="flex flex-col  items-center flex-1 px-4 pt-6 text-center  capitalize sm:justify-center">
    <div>
        <a href="#3">
            <!-- <img {{ $attributes }} src="{{asset('asset/images/logo.png')}}" width="100" alt=""> -->
        </a>
    </div>
    <div class="w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-md sm:max-w-md dark:bg-dark-eval-1">
        {{ $slot }}
        <div class=" text-xs font-semibold">Bacalah selalu dalam hati "Yaa Sayyidii Yaa Rosulallah"</div>
    </div>
</main>