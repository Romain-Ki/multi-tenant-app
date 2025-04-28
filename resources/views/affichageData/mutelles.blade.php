
<head>

</head>
<div class="container">
    <h1 class="mb-4">Liste des Mutuelles</h1>

    @if($mutuelles->isEmpty())
        <p>Aucune mutuelle enregistrée.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Mutuelle id</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mutuelles as $mutuelle)
                    <tr>
                        <td>{{ $mutuelle->nom }}</td>
                        <td>{{ $mutuelle->id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
