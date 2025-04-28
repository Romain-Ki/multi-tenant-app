<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="/css/app.css"> <!-- à adapter selon ton setup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="mb-4">Liste des Clients</h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Numéro Sécurité Sociale</th>
                    <th>RIB</th>
                    <th>Historique Médical</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars($client->nom) ?></td>
                            <td><?= htmlspecialchars($client->prenom) ?></td>
                            <td><?= htmlspecialchars($client->email) ?></td>
                            <td><?= htmlspecialchars($client->telephone) ?></td>
                            <td><?= htmlspecialchars($client->adresse) ?></td>
                            <td><?= htmlspecialchars($client->numero_securite_sociale) ?></td>
                            <td><?= htmlspecialchars($client->rib) ?></td>
                            <td><?= htmlspecialchars($client->historique_medical) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Aucun client trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
