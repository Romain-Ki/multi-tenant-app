<head>
    <!-- Ajoute Bootstrap si ce n’est pas déjà fait -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
    <h1 class="mb-4">Liste des Mutuelles</h1>

    <a href="{{ route('mutuelles.create') }}" class="btn btn-primary mb-3">Ajouter une mutuelle</a>

    @if($mutuelles->isEmpty())
        <p>Aucune mutuelle enregistrée.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email de contact</th>
                <th>Créée le</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mutuelles as $mutuelle)
                <tr>
                    <td>{{ $mutuelle->nom }}</td>
                    <td>{{ $mutuelle->email_contact ?? 'N/A' }}</td>
                    <td>{{ $mutuelle->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('mutuelles.show', $mutuelle) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('mutuelles.edit', $mutuelle) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('mutuelles.destroy', $mutuelle) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
