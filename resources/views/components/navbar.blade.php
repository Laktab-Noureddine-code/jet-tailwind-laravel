<nav class="h-full">
    <ul class="flex flex-col h-full justify-between">
        @auth
            @if (auth()->user()->role === 'admin')
                <div>
                    <li>
                        <a href="{{ route('dashboard.index') }}"
                            class="{{ request()->routeIs('dashboard*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] fa-solid fa-house mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('affectation.index') }}"
                            class="{{ request()->routeIs('affectation*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] fa-solid fa-file mr-2"></i>Affectations
                        </a>
                    </li>
                    <li>
                    <li class="">
                        <a href="{{ route('ordinateurs.index') }}"
                            class="{{ request()->routeIs('ordinateurs*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] mr-2 fa-solid fa-laptop"></i>Ordinateurs
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('telephones.index') }}"
                            class="{{ request()->routeIs('telephones*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="fa-solid fa-mobile-screen text-[16px] mr-2 "></i>Télephones
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('imprimantes.index') }}"
                            class="{{ request()->routeIs('imprimantes*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] mr-2 fa-solid fa-print"></i>Imprimantes
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('peripheriques.index') }}"
                            class="{{ request()->routeIs('peripheriques*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] mr-2 fa-solid fa-computer-mouse"></i>Périphériques
                        </a>
                    </li>
                    </li>
                    <li class="">
                        <a href="{{ route('accounts.index') }}"
                            class="{{ request()->routeIs('accounts*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] fa-solid fa-gear mr-2"></i>Paramétres
                        </a>
                    </li>
                </div>
                <div>
                    <li class="">
                        <a href="{{ route('notifications.index') }}"
                            class="{{ request()->routeIs('notifications*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] fa-solid fa-bell mr-2"></i>Notifications 
                        </a>
                    </li>
                    {{-- <li class="">
                        <a href="{{ route('trash') }}"
                            class="{{ request()->routeIs('trash*') ? 'links underline text-[#f4d103]' : 'links' }}">
                            <i class="text-[16px] fa-solid fa-trash-can-arrow-up mr-2"></i>trash
                        </a>
                    </li> --}}

                    <li class="">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="cursor-pointer links">
                                <i class="text-[16px] fa-solid fa-arrow-right-from-bracket"></i>
                                logout
                            </button>
                        </form>
                    </li>
                </div>
            @else
                <li class="">
                    <a class="cursor-pointer">recrutement</a>
                </li>
            @endif
        @endauth
    </ul>
</nav>
