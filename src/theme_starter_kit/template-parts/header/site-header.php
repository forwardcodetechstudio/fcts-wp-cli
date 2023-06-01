<?php

/**
 * Displays the site header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

?>

<header class="header__module position-fixed header__sticky">
    <div class="header__nav__module">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-2 col-md-3 header__logo">
                    <?php get_template_part('template-parts/header/site-branding'); ?>
                </div>
                <!--Logo-->
                <div class="col-lg-8 col-md-9 header__right__module">
                    <div class="header__menu__block">
                        <div class="navbar__toggler" onclick="myFunction(this)">
                            <span class="top"></span>
                            <span class="middle"></span>
                        </div>
                        <div class="header__menu">
                            <nav class="navbar">
                                <?php get_template_part('template-parts/header/site-nav'); ?>
                            </nav>
                        </div>
                    </div>
                </div>
                <!--Menu-->
            </div>
        </div>
    </div>
</header>