<nav class="flex-1">
    <div class="px-3 py-2">
        <p class="text-xs font-medium text-gray-400 px-3 mb-2">MAIN MENU</p>
        <ul class="space-y-1">
            @auth
                @if (auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('dashboard.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('dashboard*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-house text-[16px] w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('affectation.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('affectation*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-file text-[16px] w-6"></i>
                            <span>Affectations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ordinateurs.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('ordinateurs*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-laptop text-[16px] w-6"></i>
                            <span>Ordinateurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('imprimantes.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('imprimantes*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-print text-[16px] w-6"></i>
                            <span>Imprimantes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peripheriques.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('peripheriques*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-computer-mouse text-[16px] w-6"></i>
                            <span>Périphériques</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('telephones.index') }}"
                            class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('telephones*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                            <i class="fa-solid fa-mobile-screen text-[16px] w-6"></i>
                            <span>Téléphones</span>
                        </a>
                    </li>



                    <div class="mt-6">
                        <p class="text-xs font-medium text-gray-400 px-3 mb-2">SETTINGS</p>
                        <li>
                            <a href="{{ route('accounts.index') }}"
                                class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('accounts*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                                <i class="fa-solid fa-gear text-[16px] w-6"></i>
                                <span>Paramétres</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('notifications.index') }}"
                                class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('notifications*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                                <i class="fa-solid fa-bell text-[16px] w-6"></i>
                                <span class="flex items-center gap-3">Notifications
                                    <span id="notifications"></span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trash.index') }}"
                                class="flex items-center px-3 py-2 text-white rounded-md {{ request()->routeIs('trash*') ? 'bg-[#2a3955]' : 'hover:bg-[#1a2c4e]' }}">
                                <i class="fa-solid fa-trash text-[16px] w-6"></i>
                                <span>Corbeille</span>
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')"
                                    class="w-full flex cursor-pointer items-center px-3 py-2 text-white rounded-md hover:bg-[#1a2c4e]">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-[16px] w-6"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </li>
                    </div>
                @else
                    <!-- For any other user roles -->
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')"
                                class="w-full flex cursor-pointer items-center px-3 py-2 text-white rounded-md hover:bg-[#1a2c4e]">
                                <i class="fa-solid fa-arrow-right-from-bracket text-[16px] w-6"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>
<script>
    $(document).ready(function() {
        function getData() {
            $.ajax({
                url: '/not_read',
                method: 'GET',
                success: function(data) {
                    if (data.notifications > 0) {
                        $('#notifications').empty()
                        $('#notifications').append(
                            `<span class='flex items-center justify-center text-white max-w-5 min-w-5 max-h-5 min-h-5 text-lg bg-red-700 rounded-full'><p>${data.notifications}</p></span>`
                        )
                    }
                }
            })
        }
        setInterval(getData, 10000);
        getData()
    })
</script>
