<?php
    /*
    Template Name: Landing formulario
    */
    
    the_post();
    get_header('landing');
?>


<main id="main-content" class="landing-main-content" role="main">
    <section id="formulario" class="landing-section">
        <div class="container full-container expanded-form" data-gtm-tag="formulario-de-cotizacion" data-adwords-type="<?php the_field('adwords_type'); ?>">
            <?php get_template_part('partials/formulario-cotizacion'); ?>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <h2 class="double-line-title">
                <span>¿Necesitas Ayuda?</span>
            </h2>
            
            <div class="expanded-help-holder">
                <?php echo get_help_links('ayuda'); ?>
            </div>
        </div>
    </section>
</main>


<?php
    get_footer('landing');
?>