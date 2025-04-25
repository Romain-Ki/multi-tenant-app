<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client - Connexion & Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
    </style>
</head>
<body class="bg-light" style="overflow-y: auto;">

<header class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4">Accédez à votre espace Client</h1>
    </div>
</header>

<main class="d-flex justify-content-center">
    <div class="card shadow-lg rounded-4 w-50 p-5" id="auth-card">
        <h2 class="text-center mb-4" id="form-title">Se connecter</h2>

        @if(session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulaire Connexion -->
        <form method="POST" action="{{ route('client.login') }}" id="login-form">
            @csrf
            <div class="mb-3">
                <label for="email_contact" class="form-label">Email</label>
                <input type="email" id="email_contact" name="email_contact" value="{{ old('email_contact') }}" required class="form-control @error('email_contact') is-invalid @enderror">
                @error('email_contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-primary w-100 py-2 btn-lg shadow-sm">Se connecter</button>
            </div>

            <div class="text-center">
                <p class="small">Pas encore de compte ? <a href="javascript:void(0);" class="text-decoration-none" onclick="toggleForm()">Créer un compte</a></p>
            </div>
        </form>

        <!-- Formulaire Inscription -->
        <form method="POST" action="{{ route('clients.register') }}" id="register-form" class="d-none mt-4">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="mutuelle_id" class="form-label">Mutuelle</label>
                <select id="mutuelle_id" name="mutuelle_id" class="form-control @error('mutuelle_id') is-invalid @enderror" required>
                    <option value="">-- Choisissez votre mutuelle --</option>
                    @foreach($mutuelles as $mutuelle)
                    <option value="{{ $mutuelle->id }}">{{ $mutuelle->nom }}</option>
                    @endforeach
                </select>
            @error('mutuelle_id')
             <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            <div class="mb-3">
                <label for="numero_securite_sociale_encrypted" class="form-label">Numéro de Sécurité Sociale</label>
                <input type="text" id="numero_securite_sociale_encrypted" name="numero_securite_sociale_encrypted" class="form-control @error('numero_securite_sociale_encrypted') is-invalid @enderror" value="{{ old('numero_securite_sociale_encrypted') }}" required>
                @error('numero_securite_sociale_encrypted') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" required>
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}" required>
                @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="rib_encrypted" class="form-label">RIB</label>
                <input type="text" id="rib_encrypted" name="rib_encrypted" class="form-control @error('rib_encrypted') is-invalid @enderror" value="{{ old('rib_encrypted') }}" required>
                @error('rib_encrypted') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="historique_medical_encrypted" class="form-label">Historique Médical</label>
                <textarea id="historique_medical_encrypted" name="historique_medical_encrypted" rows="3" class="form-control @error('historique_medical_encrypted') is-invalid @enderror">{{ old('historique_medical_encrypted') }}</textarea>
                @error('historique_medical_encrypted') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success w-100 py-2 btn-lg shadow-sm">Créer un compte client</button>
            </div>

            <div class="text-center mt-3">
                <p class="small">Vous avez déjà un compte ? <a href="javascript:void(0);" class="text-decoration-none" onclick="toggleForm()">Se connecter</a></p>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleForm() {
        let loginForm = document.getElementById('login-form');
        let registerForm = document.getElementById('register-form');
        let formTitle = document.getElementById('form-title');

        if (loginForm.classList.contains('d-none')) {
            loginForm.classList.remove('d-none');
            registerForm.classList.add('d-none');
            formTitle.textContent = 'Se connecter';
        } else {
            loginForm.classList.add('d-none');
            registerForm.classList.remove('d-none');
            formTitle.textContent = 'Créer un compte';
        }
    }
</script>

</body>
</html>
