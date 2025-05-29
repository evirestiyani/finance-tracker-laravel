<!DOCTYPE html>
<html>
<head>
    <title>Register - Manajemen Keuangan</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Register</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>
