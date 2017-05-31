<?php get_header(); ?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container"> 
            <section class="page-header">
                <?php
                    echo wp_get_attachment_image( get_field('imagen_principal_sedes', 'option'), 'regular-biggest',false, array('class' => 'elastic-img cover'));
                ?>

                <div class="page-header-caption">
                    <h1><?php the_field('titulo_sedes', 'option'); ?></h1>
                    <p><?php the_field('texto_intro_sedes', 'option'); ?></p>
                </div>
            </section>
        </div>

        <div class="container">
            <section class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                <?php
                    // se sacan los grupos desde el option
                    $zn = get_field('sedes_zona_norte', 'options');
                    $zc = get_field('sedes_zona_centro', 'options');
                    $zs = get_field('sedes_zona_sur', 'options');
                ?>

                <div class="special-info-holder always-visible">
                    <div class="special-info">
                        <h3 class="special-info-title">Zona norte</h3>
                        <div class="special-info-body">
                            <?php echo generate_sedes_list( $zn ); ?>
                        </div>
                    </div>
                    <div class="special-info">
                        <h3 class="special-info-title">Zona centro</h3>
                        <div class="special-info-body">
                            <?php echo generate_sedes_list( $zc ); ?>
                        </div>
                    </div>
                    <div class="special-info">
                        <h3 class="special-info-title">Zona sur</h3>
                        <div class="special-info-body">
                            <?php echo generate_sedes_list( $zs ); ?>
                        </div>
                    </div>
                </div>
            </section>
            <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                <?php get_sidebar('interes'); ?>
            </aside>
        </div>
    </section>
</main>

<?php get_footer(); ?>