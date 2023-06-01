<?php

/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

// Fetching modules settings like ID, Padding, Background Color etc.
list($customID, $customClass) = modules_settings();

?>

<section class="error-block standard-text <?= $customClass; ?>" <?= ($customID) ? 'id="' . $customID . '"' : ''; ?>>
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-column align-items-center">
                <?php the_field('404_page_text', 'option'); ?>
            </div>
        </div>
    </div>
</section>