<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body { font-family: Arial; background: #f5f6fa; display:flex; justify-content:center; align-items:center; height:100vh; }
        .login-box { width: 350px; background:white; padding:25px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.2); }
        input { width:100%; padding:10px; margin-top:10px; border:1px solid #ccc; border-radius:5px; }
        button { width:100%; padding:10px; margin-top:15px; background:#2c3e50; color:white; border:none; border-radius:5px; cursor:pointer; }
    </style>
</head>
<body>

<div class="login-box">
    <h3 style="text-align:center;">Login Admin</h3>

    @if($errors->any())
        <div style="color:red; margin-bottom:10px;">{{ $errors->first('login') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
