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
