@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Modifier votre mutuelle</h1>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Formulaire de mise à jour -->
        <form action="{{ route('mutuelles.update', $mutuelle) }}" method="POST" class="mb-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la mutuelle</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $mutuelle->nom) }}" required>
                @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email_contact" class="form-label">Email de contact</label>
                <input type="email" class="form-control @error('email_contact') is-invalid @enderror" id="email_contact" name="email_contact" value="{{ old('email_contact', $mutuelle->email_contact) }}">
                @error('email_contact')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('mutuelle.home') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>

        <!-- Formulaire de suppression -->
        <form action="{{ route('mutuelles.destroy', $mutuelle) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre mutuelle ? Cette action est irréversible.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer la mutuelle</button>
        </form>
    </div>
@endsection
