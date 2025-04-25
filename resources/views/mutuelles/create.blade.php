@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter une nouvelle mutuelle</h1>

        <form action="{{ route('mutuelles.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la mutuelle</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="mb-3">
                <label for="email_contact" class="form-label">Email de contact</label>
                <input type="email" class="form-control" id="email_contact" name="email_contact">
            </div>

            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="{{ route('mutuelles') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
