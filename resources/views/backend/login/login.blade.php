<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisans Takip - Giriş</title>
    <link rel="stylesheet" href="{{asset('backend/css/login.css')}}">
</head>
<body>
    <div class="login-container">
        <!--
        <h2>Giriş</h2>
        <a href="https://ikys.samsun.bel.tr/Auth/SbbLogin?redirectTo=lisansTakip">Giriş Yap</a>
        -->

        <form action="{{route('admin.login')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
