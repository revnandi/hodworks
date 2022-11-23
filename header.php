<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hodworks</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <?php wp_head() ?>
</head>
<body <?php body_class('flex flex-col h-screen') ?>>
    <?php wp_body_open();  ?>
    
    <header id="hw_header" class="c-header">
        <div class="c-header__inner">
            <?php require get_template_directory() . '/partials/header/logo.php'; ?>
            <div class="c-header__menu-container">
                <?php require get_template_directory() . '/partials/header/nav.php'; ?>
                <div id="hw_canvas_container" class="c-header__canvas-container">
                    <canvas id="hw_canvas" class="c-header__canvas" resize></canvas>  
                </div>
                <?php require get_template_directory() . '/partials/header/language_selector.php'; ?>
                <button id="hodworks_menu_button" class="hamburger hamburger--squeeze" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <main id="hw_main" class="c-page">
    <!-- <?php pretty_dump(the_title());?> -->
