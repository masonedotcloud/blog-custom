<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
Access();
$Cake->Load()
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="icon" type="image/x-icon" href="">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo InternetFile('public/statics/css/bootstrap.min.css', false) ?>" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="<?php echo InternetFile('public/statics/js/jquery.min.js', false) ?>"></script>
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/css/bootstrap-icons.css', false) ?>">
    <title><?php echo $name_page ?></title>
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        body {
            background: #F0F2F5;
        }

        .white {
            background-color: #ffffff;
        }

        main {
            min-height: 100%;
            position: relative;
        }

        .bi {
            line-height: 0 !important;
        }

        html,
        body {
            height: 100%
        }

        #footer {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 60px;
        }

        .bg-green-fb {
            background-color: #00a400 !important;
        }
    </style>
    <script type="text/javascript" src="statics/js/header.js"></script>
</head>

<body>