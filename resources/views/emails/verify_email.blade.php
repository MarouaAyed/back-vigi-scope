<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de l'e-mail</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #031e36;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #031e36;
            margin: 0;
        }
        .content {
            text-align: center;
            color: #031e36;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0;
            background-color: #84bdc5;
            color: #ffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #6daab3;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
        }
        .footer a {
            color: #84bdc5;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue {{ $user->name }} !</h1>
        </div>
        <div class="content">
            <p>Merci de vous être inscrit. Pour finaliser votre inscription, veuillez vérifier votre adresse e-mail en cliquant sur le bouton ci-dessous :</p>
            <a href="http://localhost:4200/login?returnUrl=%2Fregister" class="button">Vérifier mon e-mail</a>
           
            <p>Si vous n'avez pas créé de compte, vous pouvez ignorer ce message.</p>
        </div>
        <div class="footer">
            <p>Besoin d'aide ? <a href="mailto:support@bridge.com">Contactez-nous</a>.</p>
        </div>
    </div>
</body>
</html>
