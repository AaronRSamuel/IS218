<html>
    <head>
        <title> Logout</title>
        <button onclick="location.href = 'https://web.njit.edu/~as3655/IS218/Final/Login.php';" name="login">Login</button>
    </head>
    <body>
      <text> <font size="6"> <center> You are logged out! <center> <font> </text>
    </body>
</html>
<?php
    session_start();
    session_unset();
    session_destroy();
    echo var_export($_SESSION, true);
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
?>