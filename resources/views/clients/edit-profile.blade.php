<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil | {{ auth()->user()->nom }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-900">

<header class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Modifier mon profil - {{ auth()->user()->nom }}</h1>
    <nav>
        <a href="{{ route('client.logout') }}" class="text-white hover:underline">Déconnexion</a>
    </nav>
</header>

<main class="p-6 flex flex-col items-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
        <h2 class="text-xl font-semibold mb-6">Éditer mes informations</h2>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('client.updateProfile') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $client->prenom) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </div>

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $client->nom) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </div>

            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $client->telephone) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </div>

            <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $client->adresse) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
            </div>

            <div>
                <label for="mutuelle_id" class="block text-sm font-medium text-gray-700">Mutuelle</label>
                <select id="mutuelle_id" name="mutuelle_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('mutuelle_id') border-red-500 @enderror">
                    <option value="">-- Choisissez votre mutuelle --</option>
                    @foreach($mutuelles as $mutuelle)
                        <option value="{{ $mutuelle->id }}" {{ old('mutuelle_id', $client->mutuelle_id) == $mutuelle->id ? 'selected' : '' }}>
                            {{ $mutuelle->nom }}
                        </option>
                    @endforeach
                </select>
                @error('mutuelle_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" id="password" name="password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('password') border-red-500 @enderror">
                @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('client.home') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Sauvegarder
                </button>
            </div>

        </form>
    </div>
</main>

</body>
</html>

