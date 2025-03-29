@extends('layouts.app')

@section('content')
    <h3>Ordinateurs supprimés</h3>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($ordinateurs->isEmpty())
        <p>Aucun ordinateur supprimé trouvé.</p>
    @else
        <table class="table">
            <tr class="tr">
                <th>Fabricant</th>
                <th>Type</th>
                <th>Numéro Série</th>
                <th>État</th>
                <th>RAM</th>
                <th>Stockage</th>
                <th>Processeur</th>
                <th>Actions</th>
            </tr>
            @foreach($ordinateurs as $materiel)
                <tr>
                    <td>{{ $materiel->fabricant }}</td>
                    <td>{{ $materiel->type }}</td>
                    <td>{{ $materiel->num_serie }}</td>
                    <td>{{ $materiel->etat }}</td>
                    <td>{{ optional($materiel->ordinateur)->ram ?? 'N/A' }}</td>
                    <td>{{ optional($materiel->ordinateur)->stockage ?? 'N/A' }}</td>
                    <td>{{ optional($materiel->ordinateur)->processeur ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('trash.restore', $materiel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background: green; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                                Restaurer
                            </button>
                        </form>

                        <!-- Bouton Supprimer définitivement -->
                        <form action="{{ route('trash.forceDelete', $materiel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ?')" 
                                style="background: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                                Supprimer définitivement
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
