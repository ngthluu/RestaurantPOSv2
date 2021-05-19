<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= PROJECT_NAME ?></title>
    <meta content="" name="description">

    <meta content="" name="keywords">

    <link href="<?= base_url("resources/logo.jpg") ?>" rel="icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="<?= base_url("assets/homepage/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/homepage/bootstrap-icons/bootstrap-icons.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/homepage/css/general.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/homepage/css/header.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/homepage/css/footer.css") ?>" rel="stylesheet">

    <link href="<?= base_url("assets/homepage/css/contact-us.css") ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="<?= site_url() ?>" class="logo d-flex align-items-center">
                <img src="<?= base_url("resources/logo.jpg") ?>" alt="">
                <span><?= PROJECT_SHORTCUT ?></span>
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="<?= site_url() ?>">Home</a></li>
                    <li><a class="nav-link scrollto" href="<?= site_url("contact-us") ?>">Contact</a></li>
                    <li><a class="getstarted scrollto" href="#">Sign up</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->