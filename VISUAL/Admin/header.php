<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <style>
            /* Tus estilos existentes */
            .sidebar {
                width: 60px;
                background-color: #000;
                color: white;
                overflow-x: hidden;
                transition: width 0.3s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .sidebar:hover {
                width: 150px;
                align-items: flex-start;
            }

            .sidebar .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                padding: 15px;
                text-decoration: none;
                font-size: 1.5em;
                cursor: pointer;
                width: 100%;
            }

            .sidebar .logo-container {
                padding: 15px;
                text-align: center;
                margin-bottom: 10px;
                width: 100%;
            }

            .sidebar:not(:hover) .logo-container {
                display: flex;
                justify-content: center;
            }

            .sidebar .logo-container img {
                max-width: 80%;
                height: auto;
                border-radius: 5px;
            }

            .sidebar .nav-title {
                color: #ffd700;
                text-align: center;
                margin-bottom: 10px;
                font-size: 1em;
                opacity: 0;
                transition: opacity 0.3s ease;
                width: 100%;
            }

            .sidebar:hover .nav-title {
                opacity: 1;
            }

            .sidebar .nav-pills {
                margin-top: 10px;
                width: 100%;
            }

            .sidebar .nav-pills li {
                margin-bottom: 5px;
            }

            .sidebar .nav-pills li a {
                color: white;
                padding: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 5px;
                text-decoration: none;
                transition: background-color 0.3s ease;
                opacity: 0;
                transform: translateX(-20px);
                transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s;
            }

            .sidebar:hover .nav-pills li a {
                opacity: 1;
                transform: translateX(0);
                justify-content: flex-start;
                padding-left: 15px;
            }

            .sidebar .nav-pills li a i {
                margin-right: 10px;
            }

            .sidebar .nav-pills li a:hover {
                background-color: #ff69b4;
            }

            /* Estilo solo al ícono del archivo activo */
            .i-<?php echo pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?> {
                font-weight: bold;
                color: #ffd166 !important;
                background-color:rgb(22, 25, 169) !important;
                border-left: 4px rgb(0, 0, 250) !important;
                padding-left: 5px;
                border-radius: 4px;
            }
    </style>

</body>
</html>