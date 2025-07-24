<?php

/**
 * Template part for displaying Language Changer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package haffmeister
 */

?>

 <?php if (class_exists('SitePress')): ?>
    <div class="nav-lang-changer">
        <?php $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc'); ?>

        <?php foreach ($languages as $language): ?>
            <?php if (($language['active'])) {
                echo $language['language_code'];
            } ?>
        <?php endforeach; ?>
        <ul class="nav-lang-changer__menu">
        <?php foreach ($languages as $language) : ?>
            <li><a href="<?php echo $language['url']; ?>" class="<?= (ICL_LANGUAGE_CODE == $language['code']) ? 'active' : ''; ?>"><?php echo strtoupper($language['code']); ?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>