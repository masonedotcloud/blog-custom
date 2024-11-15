<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
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
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/froala_editor.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/froala_style.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/code_view.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/draggable.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/colors.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/emoticons.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/image_manager.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/image.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/line_breaker.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/table.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/char_counter.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/video.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/fullscreen.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/file.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/quick_insert.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/help.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/third_party/spell_checker.css', false) ?>">
    <link rel="stylesheet" href="<?php echo InternetFile('public/statics/froala/css/plugins/special_characters.css', false) ?>">
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

        .tooltip-arrow {
            display: none !important;
        }

        #add-button {
            position: fixed;
            bottom: 10px;
            right: 20px;
        }

        @media only screen and (max-width: 575px) {
            #sidebar {
                width: 100% !important;
            }

            .navbar-ico {
                font-size: 1.7rem !important;
            }

            #content {
                margin-left: 0px !important;
            }

            #info {
                margin-top: 60px;
            }
        }

        #sidebar {
            width: 80px;
        }

        .navbar-ico {
            font-size: 2.0rem;
        }

        .clip {
            position: relative;
            display: grid;
            place-items: center;
            width: 90px;
            height: 90px;
        }

        .clip img {
            width: 90%;
            height: 90%;
        }

        .clip:before,
        .clip:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 110%;
            height: 110%;
            margin: -5%;
            box-shadow: inset 0 0 0 2px #f7df1c;
            animation: clipMe 3s linear infinite;
        }

        .clip:before {
            animation-delay: -1.5s;
        }

        @keyframes clipMe {

            0%,
            100% {
                clip: rect(0, 100px, 2px, 0);
            }

            25% {
                clip: rect(0, 2px, 100px, 0);
            }

            60% {
                clip: rect(98px, 100px, 100px, 0);
            }

            75% {
                clip: rect(0, 100px, 100px, 98px);
            }
        }
    </style>
    <script type="text/javascript" src="statics/js/header.js"></script>
</head>

<body>