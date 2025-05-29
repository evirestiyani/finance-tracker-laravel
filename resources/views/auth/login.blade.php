<!DOCTYPE html>
<html>
<head>
    <title>Login - Manajemen Keuangan</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Login</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

      
        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Register di sini</a></p>
</body>
</html>
