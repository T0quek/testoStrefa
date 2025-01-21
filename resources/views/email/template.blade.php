<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testoStrefa.pl Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF6DF;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #1f2937;
            text-align: center;
            padding: 20px 0 20px 0;
        }
        .header img {
            max-width: 250px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            color: #1f2937;
        }
        .content p {
            color: #333;
            line-height: 1.6;
        }
        .footer {
            background-color: #1f2937;
            color: #FFF6DF;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #FFF6DF;
            text-decoration: none;
        }
        .fw-bold {
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline !important;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <img src="https://testostrefa.pl/images/logo.png" alt="testoStrefa Logo">
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
        <p>Pozdrawiamy,<br>Zespół testoStrefa.pl</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>testoStrefa.pl &copy; <?=date("Y");?></p>
        <p><a class="link" href="https://testostrefa.pl">Odwiedź naszą stronę</a></p>
        <p style="display: block;">Napisz do nas: <a class="link" href="mailto:kontakt@testostrefa.pl">kontakt@testostrefa.pl</a></p>
    </div>
</div>

</body>
</html>
