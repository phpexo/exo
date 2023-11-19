<?php
session_start();
// Datenbankverbindungsdaten laden
require_once(dirname(__FILE__).'/config/autoload.config.php');

// Datenbankverbindungsklasse erstellen
$db = new Database();
// Login-Klasse erstellen
$login = new Login($db);

// CSRF-Token generieren
$csrf_token = $login->generateCSRFToken();

?>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>PHP My Inventory ?V0.1 Pre Alpha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <meta name="theme-color" content="#712cf9">

</head>

<body>
    <main>
        <style>
        a {
            text-decoration: none;
        }

        .login-page {
            width: 100%;
            height: 100vh;
            display: inline-block;
            display: flex;
            align-items: center;
        }

        .form-right i {
            font-size: 100px;
        }
        </style>
        <div class="login-page bg-light">
            <div class="container">
                <?php if (isset($_GET["login"])){if($_GET["login"] == "error"){echo '<div class="alert alert-warning" role="alert">Login Error!</div>';}}?>
                <?php if (isset($_GET["csrf_token"])){if($_GET["csrf_token"] == "error"){echo '<div class="alert alert-warning" role="alert">csrf token Error!</div>';}}?>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <h3 class="mb-3">Login Now</h3>
                        <div class="bg-white shadow rounded">
                            <div class="row">
                                <div class="col-md-7 pe-0">
                                    <div class="form-left h-100 py-5 px-5">
                                        <form action="app/login.php" method="post" class="row g-4">
                                            <div class="col-12">
                                                <label>Username<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-person-fill"></i>
                                                    </div>
                                                    <input type="text" name="username" class="form-control"
                                                        placeholder="Enter Username">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter Password">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                </div>
                                            </div>


                                            <div class="col-12">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <button type="submit"
                                                    class="btn btn-primary px-4 float-end mt-4">login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5 ps-0 d-none d-md-block">
                                    <div class="form-right h-100 bg-primary text-white text-center pt-5">
                                        <i class="bi bi-book-half"></i>
                                        <h2 class="fs-1">PHP My Inventory</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-end text-secondary mt-3">PHP My Inventory Login</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

</body>

</html>