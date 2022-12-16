<footer class="flex-shrink-0 px-6 py-4   ">
    @role('super admin')
    <p class="flex items-center justify-center gap-1 text-sm text-gray-600 dark:text-gray-400">
        <span>Made with</span>
        <span>
            <x-heroicon-s-heart class="w-6 h-6 text-red-500" />
        </span>
        <span>by</span>
        <a href="https://wustho.smedi.my.id/" target="_blank" class="text-blue-600 hover:underline">
            MADIN WUSTHO WAHIDIYAH &copy 2022 | <span class=" uppercase">User Login : {{Auth::user()->name}}</span>
        </a>
    </p>
    @endrole
    @role('pengurus')
    <p class="flex items-center justify-center gap-1 text-sm text-gray-600 dark:text-gray-400">
        <span>Made with</span>
        <span>
            <x-heroicon-s-heart class="w-6 h-6 text-red-500" />
        </span>
        <span>by</span>
        <a href="https://wustho.smedi.my.id/" target="_blank" class="text-blue-600 hover:underline">
            PONDOK PESANTREN KEDUNGLO WAHIDIYAH &copy 2022 | <span class=" uppercase">User Login : {{Auth::user()->name}}</span>
        </a>
    </p>
    @endrole
    @role('siswa')
    <p class="flex items-center justify-center gap-1 text-sm text-gray-600 dark:text-gray-400">
        <span>Made with</span>
        <span>
            <x-heroicon-s-heart class="w-6 h-6 text-red-500" />
        </span>
        <span>by</span>
        <a href="https://wustho.smedi.my.id/" target="_blank" class="text-blue-600 hover:underline">
            MADIN WUSTHO WAHIDIYAH &copy 2022 | <span class=" uppercase">User Login : {{Auth::user()->name}}</span>
        </a>
    </p>
    @endrole
</footer>