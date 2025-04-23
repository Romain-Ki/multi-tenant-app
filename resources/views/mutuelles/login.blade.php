<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutuelle - Connexion & Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <header class="bg-primary text-white py-5 mb-5">
        <div class="container text-center">
            <h1 class="display-4">Accédez à votre espace Mutuelle</h1>
        </div>
    </header>

    <main class="d-flex justify-content-center align-items-center">
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
            
            <form method="POST" action="{{ route('client.login') }}" id="login-form">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email_contact" class="form-label">Email</label>
                    <input type="email" id="email_contact" name="email_contact" value="{{ old('email_contact') }}" required class="form-control @error('email_contact') is-invalid @enderror">
                    @error('email_contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton de connexion -->
                <div class="mb-4 text-center">
                    <button type="submit" class="btn btn-primary w-100 py-2 btn-lg shadow-sm">Se connecter</button>
                </div>

                <div class="text-center">
                    <p class="small">Pas encore de compte ? <a href="javascript:void(0);" class="text-decoration-none" onclick="toggleForm()">Créer un compte</a></p>
                </div>
            </form>

            <!-- Formulaire d'inscription -->
            <form method="POST" action="{{ route('mutuelle.register') }}" id="register-form" class="d-none mt-4">
                @csrf

                <!-- Nom de la mutuelle -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la Mutuelle</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required class="form-control @error('nom') is-invalid @enderror">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email_contact" class="form-label">Email</label>
                    <input type="email" id="email_contact" name="email_contact" value="{{ old('email_contact') }}" required class="form-control @error('email_contact') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                </div>

                <!-- Bouton d'inscription -->
                <div class="mb-4 text-center">
                    <button type="submit" class="btn btn-success w-100 py-2 btn-lg shadow-sm">Créer un compte</button>
                </div>

                <div class="text-center">
                    <p class="small">Vous avez déjà un compte ? <a href="javascript:void(0);" class="text-decoration-none" onclick="toggleForm()">Se connecter</a></p>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-primary text-white py-3">
        <div class="container text-center">
            <p>&copy; 2025 Mutuelle Santé</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonction pour basculer entre les formulaires
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
