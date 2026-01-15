<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>

<!-- TAMBAHKAN CLASS DI SINI -->
<body class="login-page">

<div class="container">
    <h2>Login Sistem</h2>

    <form action="login_process.php" method="post">
        <label>NIM</label>
        <input type="text" name="nim" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
