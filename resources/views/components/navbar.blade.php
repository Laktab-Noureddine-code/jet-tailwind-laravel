<nav class="flex-1">
    <div class="px-3 py-2">
        <p class="text-xs font-medium text-gray-400 px-3 mb-2">MAIN MENU</p>

        <ul class="space-y-1">
            @auth
                @if (auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('dashboard.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('dashboard*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-house text-[16px] w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('affectation.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('affectation*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-file text-[16px] w-6"></i>
                            <span>Affectations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ordinateurs.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('ordinateurs*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-laptop text-[16px] w-6"></i>
                            <span>Ordinateurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('telephones.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('telephones*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-mobile-screen text-[16px] w-6"></i>
                            <span>Télephones</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('imprimantes.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('imprimantes*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-print text-[16px] w-6"></i>
                            <span>Imprimantes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peripheriques.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('peripheriques*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-computer-mouse text-[16px] w-6"></i>
                            <span>Périphériques</span>
                        </a>
                    </li>

                    <div class="mt-6">
                        <p class="text-xs font-medium text-gray-400 px-3 mb-2">SETTINGS</p>
                        <li>
                            <a href="{{ route('accounts.index') }}"
                                class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('accounts*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                                <i class="fa-solid fa-gear text-[16px] w-6"></i>
                                <span>Paramétres</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('notifications.index') }}"
                                class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('notifications*') ? 'bg-[#FFD700]' : 'hover:bg-[#1a2c4e]' }}">
                                <i class="fa-solid fa-bell text-[16px] w-6"></i>
                                <span>Notifications</span>
                            </a>
                        </li>
                    </div>

                    <div class="mt-6">
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="w-full flex items-center px-3 py-2 text-white rounded-md hover:bg-[#1a2c4e]">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-[16px] w-6"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </div>
                @else
                    <li>
                        <a class="flex items-center px-3 py-2 text-white rounded-md hover:bg-[#1a2c4e]">
                            <i class="fa-solid fa-user-plus text-[16px] w-6"></i>
                            <span>Recrutement</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>
