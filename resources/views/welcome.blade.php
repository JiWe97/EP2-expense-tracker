<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Expense Tracker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .header {
            margin-bottom: 10px;
        }

        .header img {
            width: 250px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.2rem;
            color: #666;
        }

        .features {
            margin-top: 30px;
        }

        .features h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .features p {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #555;
        }

        .features ul {
            list-style-type: none;
            padding: 0;
        }

        .features li {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #555;
        }

        .cta {
            margin-top: 40px;
        }

        .cta a {
            display: inline-block;
            padding: 8px 16px;
            font-size: 1.2rem;
            color: white;
            background-color: #A3BE84;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }


        .cta a:hover {
            background-color: #ffffff;
        color: #A3BE84;
        }

    
        footer {
            margin-top: 50px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Expense Tracker Logo" class="logo">
        <h1>
            <img src="{{asset('./images/JustSprout.png')}}" alt="JustSprout" style="width: 50px; transform:  rotate(-20deg) scaleX(-1);">
            Welcome to Expense Tracker
            <img src="{{asset('./images/JustSprout.png')}}" alt="JustSprout" style="width: 50px; transform:  rotate(20deg) ;">
            </h1>
        <p>Manage your finances effectively and effortlessly.</p>
    </header>

    <main class="features">
        <h2>Why Choose Expense Tracker?</h2>
        <p>Our app helps you manage your personal finances with ease. Whether you're tracking expenses, setting budgets, or planning savings goals, Expense Tracker provides all the tools you need.</p>
        <p>Key features include:</p>
        <ul>
            <li>Easy expense tracking</li>
            <li>Detailed financial reports</li>
            <li>Customizable categories</li>
            <li>Secure and user-friendly interface</li>
        </ul>
    </main>

    <div class="cta custom-btn">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Join Now</a>
        @endauth
    </div>


    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
</div>
</body>
</html>
