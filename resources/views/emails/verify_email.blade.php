<!DOCTYPE html>
<html>
<head>
    <title>Vérification de l'e-mail</title>
</head>
<body>
    <h1>Bonjour {{ $user->name }},</h1>
    <p>Veuillez cliquer sur le lien suivant pour vérifier votre adresse e-mail :</p>
    <a href="{{ route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]) }}">Vérifier mon e-mail</a>
</body>
</html>