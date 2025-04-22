<!DOCTYPE html>
<html>
<head>
    <title>Créer un compte Mutuelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validatePasswordMatch() {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    
            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false; // bloque l'envoi
            }
    
            if (password.length < 8) {
                alert("Le mot de passe doit contenir au moins 8 caractères.");
                return false;
            }
    
            return true; // autorise le POST normal
        }
    </script>
</head>
<body class="container mt-5">
    <h2>Créer un compte Mutuelle</h2>
    <form method="POST" action="{{ route('mutuelle.register') }}" onsubmit="return validatePasswordMatch()">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="email_contact" class="form-label">Email de contact</label>
            <input type="email" class="form-control" name="email_contact" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" required minlength="8">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
            <input type="password" class="form-control" name="password_confirmation" required minlength="8">
        </div>
        <button type="submit" class="btn btn-primary">Créer le compte</button>
    </form>
</body>
</html>
