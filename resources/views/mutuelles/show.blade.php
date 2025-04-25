@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la mutuelle</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $mutuelle->nom }}</h5>
                <p class="card-text"><strong>Email de contact :</strong> {{ $mutuelle->email_contact ?? 'N/A' }}</p>
                <p class="card-text"><strong>Créée le :</strong> {{ $mutuelle->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('mutuelles') }}" class="btn btn-secondary">Retour</a>
        <a href="{{ route('mutuelles.edit', $mutuelle) }}" class="btn btn-warning">Modifier</a>

        <form action="{{ route('mutuelles.destroy', $mutuelle) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette mutuelle ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
@endsection
