@extends('layouts.app')
@section('title', 'Tableau de Bord')
@section('content')
    <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ auth()->user()->name }}</h1>
    <div class="p-4 grid gap-4">
        <div class="grid gap-4 grid-cols-2 ">
            <div class="bg-white  rounded-lg shadow-lg p-4">
                <a class="over-view">
                    <div class="px-4 py-2 rounded-xl border border-gray-200 bg-gray-100"><i
                            class="fa-solid fa-computer text-3xl text-gray-700"></i></div>
                    <div>
                        <h1 class="text-3xl font-bold">{{ $totalMateriels }}</h1>
                        <h1 class="text-lg font-semibold">Total Matériels</h1>
                    </div>
                </a>
                <a class="over-view mt-4">
                    <div class="px-4 py-2 rounded-xl border border-gray-200 bg-gray-100"><i
                            class="fa-solid fa-user text-3xl text-gray-700"></i></div>
                    <div>
                        <h1 class="text-3xl font-bold">{{ $totalUtilisateurs }}</h1>
                        <h1 class="text-lg font-semibold">Total des bénéficiaires </h1>
                    </div>
                </a>
            </div>
            <div class="p-3 bg-white rounded-lg shadow-lg relative grid grid-rows-[1fr_3fr_1fr]">
                <h1 class="font-semibold text-lg ">Types de Matériels</h1>
                <div>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach ($types as $type)
                            <div class="flex items-center">
                                <p class="mr-3 underline">{{ $type }}</p>
                                <form action="{{ route('type.destroy', $type) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 cursor-pointer">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <!-- Bouton "+" pour afficher le formulaire -->
                    <form action="{{ route('type.store') }}" method="POST" class="hidden flex" id="storeForm">
                        @csrf
                        <input type="text" name="type" id="inputField" class="border border-gray-400 flex-1 p-1"
                            required>
                        <button type="submit" class=" bg-green-500 text-white px-2 rounded-lg cursor-pointer ml-1"><i
                                class="fa-solid fa-floppy-disk"></i></button>
                        <button type="button" id="cancelBtn"
                            class=" bg-gray-500 text-white px-2 rounded-lg cursor-pointer ml-1"><i
                                class="fa-solid fa-xmark"></i></button>
                    </form>
                    <button id="showFormBtn" type="button"
                        class="text-xl bg-blue-500 text-white px-2 rounded-lg cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full flex gap-4 justify-center items-center">
            <canvas id="myChart"
                class="max-h-100 min-h-100 max-w-[64%] min-w-[64%] shadow-xl border border-gray-300 bg-white p-4 rounded-lg"></canvas>
            <canvas id="affectationChart"
                class="min-w-[35%] max-w-[35%] shadow-xl border border-gray-300 bg-white p-4 rounded-lg max-h-100 min-h-100"></canvas>
        </div>
        <div
            class="w-full flex items-center p-3 relative bg-white rounded-lg shadow-xl border border-gray-300 max-h-[400px] min-h-[400px]">
            <select id="yearSelect" class="border border-gray-400 bg-white w-20 rounded absolute right-5 top-5 z-10">
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <canvas id="affectationLineChart" class="max-h-[90%]"></canvas>
        </div>
        <div class="flex justify-end">
            <a href="https://github.com/Laktab-Noureddine-code/jet-tailwind-laravel.git" target="_blank" class="flex justify-center items-center gap-3">
                <button href="#"
                    class="flex overflow-hidden items-center text-sm font-medium focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-black text-white shadow hover:bg-black/90 h-9 px-4 py-2 max-w-52 whitespace-pre md:flex group relative w-full justify-center gap-2 rounded-md transition-all duration-300 ease-out hover:ring-2 hover:ring-black hover:ring-offset-2">
                    <span
                        class="absolute right-0 -mt-12 h-32 w-8 translate-x-12 rotate-12 bg-white opacity-10 transition-all duration-1000 ease-out group-hover:-translate-x-40"></span>
                    <div class="flex items-center gap-3">
                        <span class="ml-1 text-white">Made By</span>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 438.549 438.549">
                            <path
                                d="M409.132 114.573c-19.608-33.596-46.205-60.194-79.798-79.8-33.598-19.607-70.277-29.408-110.063-29.408-39.781 0-76.472 9.804-110.063 29.408-33.596 19.605-60.192 46.204-79.8 79.8C9.803 148.168 0 184.854 0 224.63c0 47.78 13.94 90.745 41.827 128.906 27.884 38.164 63.906 64.572 108.063 79.227 5.14.954 8.945.283 11.419-1.996 2.475-2.282 3.711-5.14 3.711-8.562 0-.571-.049-5.708-.144-15.417a2549.81 2549.81 0 01-.144-25.406l-6.567 1.136c-4.187.767-9.469 1.092-15.846 1-6.374-.089-12.991-.757-19.842-1.999-6.854-1.231-13.229-4.086-19.13-8.559-5.898-4.473-10.085-10.328-12.56-17.556l-2.855-6.57c-1.903-4.374-4.899-9.233-8.992-14.559-4.093-5.331-8.232-8.945-12.419-10.848l-1.999-1.431c-1.332-.951-2.568-2.098-3.711-3.429-1.142-1.331-1.997-2.663-2.568-3.997-.572-1.335-.098-2.43 1.427-3.289 1.525-.859 4.281-1.276 8.28-1.276l5.708.853c3.807.763 8.516 3.042 14.133 6.851 5.614 3.806 10.229 8.754 13.846 14.842 4.38 7.806 9.657 13.754 15.846 17.847 6.184 4.093 12.419 6.136 18.699 6.136 6.28 0 11.704-.476 16.274-1.423 4.565-.952 8.848-2.383 12.847-4.285 1.713-12.758 6.377-22.559 13.988-29.41-10.848-1.14-20.601-2.857-29.264-5.14-8.658-2.286-17.605-5.996-26.835-11.14-9.235-5.137-16.896-11.516-22.985-19.126-6.09-7.614-11.088-17.61-14.987-29.979-3.901-12.374-5.852-26.648-5.852-42.826 0-23.035 7.52-42.637 22.557-58.817-7.044-17.318-6.379-36.732 1.997-58.24 5.52-1.715 13.706-.428 24.554 3.853 10.85 4.283 18.794 7.952 23.84 10.994 5.046 3.041 9.089 5.618 12.135 7.708 17.705-4.947 35.976-7.421 54.818-7.421s37.117 2.474 54.823 7.421l10.849-6.849c7.419-4.57 16.18-8.758 26.262-12.565 10.088-3.805 17.802-4.853 23.134-3.138 8.562 21.509 9.325 40.922 2.279 58.24 15.036 16.18 22.559 35.787 22.559 58.817 0 16.178-1.958 30.497-5.853 42.966-3.9 12.471-8.941 22.457-15.125 29.979-6.191 7.521-13.901 13.85-23.131 18.986-9.232 5.14-18.182 8.85-26.84 11.136-8.662 2.286-18.415 4.004-29.263 5.146 9.894 8.562 14.842 22.077 14.842 40.539v60.237c0 3.422 1.19 6.279 3.572 8.562 2.379 2.279 6.136 2.95 11.276 1.995 44.163-14.653 80.185-41.062 108.068-79.226 27.88-38.161 41.825-81.126 41.825-128.906-.01-39.771-9.818-76.454-29.414-110.049z">
                            </path>
                        </svg>
                    </div>
                </button>

            </a>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Fonction pour récupérer les données JSON via AJAX
            function fetchChartData() {
                $.ajax({
                    url: '/getChartData', // URL de la route
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Initialiser le graphique avec les données reçues
                        initChart(data);
                        // console.log(data)
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des données:', error);
                    }
                });
            }

            // Initialiser le graphique
            function initChart(chartData) {
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar', // Type de graphique (bar, line, pie, etc.)
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1, // Force les ticks à être des entiers

                                }
                            }
                        }
                    }
                });
            }

            // Appeler la fonction pour récupérer les données
            fetchChartData();

            function fetchAffectationStats() {
                $.ajax({
                    url: '/getAffectationStats', // URL de la route Laravel
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        initPieChart(data);
                        console.log(data)
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des données:', error);
                    }
                });
            }

            // Initialiser le Pie Chart
            function initPieChart(chartData) {
                const ctx = document.getElementById('affectationChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: chartData
                });
            }

            // Appeler la fonction pour récupérer les données
            fetchAffectationStats();


            // ! line chart
            function fetchAffectationByMonth(year) {
                $.ajax({
                    url: '/getAffectationByMonth',
                    method: 'GET',
                    data: {
                        year: year
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        initLineChart(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des données:', error);
                    }
                });
            }

            function initLineChart(chartData) {
                const ctx = document.getElementById('affectationLineChart').getContext('2d');

                if (window.affectationChartInstance) {
                    window.affectationChartInstance.destroy();
                }

                window.affectationChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Charger les données par défaut pour l'année actuelle
            let currentYear = $('#yearSelect').val();
            fetchAffectationByMonth(currentYear);

            // Mettre à jour le graphique quand l'utilisateur change l'année
            $('#yearSelect').change(function() {
                let selectedYear = $(this).val();
                fetchAffectationByMonth(selectedYear);
            });



            // ! add type
            // Afficher le formulaire quand on clique sur "+"
            $("#showFormBtn").click(function() {
                $("#storeForm").removeClass("hidden");
                $("#showFormBtn").addClass('hidden');
            });

            // Cacher le formulaire quand on clique sur "Cancel"
            $("#cancelBtn").click(function() {
                $("#showFormBtn").removeClass('hidden');
                $("#storeForm").addClass("hidden");
                $("#inputField").val(""); // Vider le champ
            });
        });
    </script>
@endsection
