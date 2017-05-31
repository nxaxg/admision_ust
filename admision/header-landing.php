<?php require_once( "meta-header.php" ); ?>
<header class="landing-header" >
    <section class="landing-header-logo">
        <div class="container">
            <a class="landing-logo" href="<?php echo home_url(); ?>" title="Volver al inicio" rel="index">
                <?php
                    $logo_landing = '<img class="hide-on-vertical-tablet-down" src="'. get_bloginfo('template_directory') .'/images/logos/logo-landing-vertical.svg">';

                    $logos = get_field('logotipos_admision', 'options');
                    if( !empty($logos) && !empty($logos[0]['logotipo_landing']) ){
                        $logo_landing = wp_get_attachment_image($logos[0]['logotipo_landing'], 'full', false, ['class' => 'hide-on-vertical-tablet-down editorial']);
                    }

                    echo $logo_landing;
                ?>
                <img class="only-on-vertical-tablet-down" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-ust-horizontal.svg">
            </a>
        </div>
    </section>

    <?php
        the_post_thumbnail('full-header', array('class' => 'full-header-img'));
    ?>

    <section class="landing-header-info">
        <div class="container full-container">
            <div class="landing-intro">
                <?php the_field('texto_principal'); ?>
            </div>

            <div class="landing-buttons-holder">
                <a class="button complementario inline info after-icon scrolldown hide-on-vertical-tablet-down" href="#formulario" data-func="scrollToTarget">Postula</a> 

                <?php
                    $button_active = get_field('activar_boton');

                    if( $button_active ){
                        $button_text = get_field('texto_boton');
                        $button_class = get_field('tipo_boton');
                        $button_target = get_field( get_field('tipo_objetivo') );
                        $button_link = '#';
                        $button_rel = '';

                        // se decide como sacar url desde la opcion del user
                        if( is_array($button_target) && is_numeric($button_target[0]) ){
                            $button_link = get_permalink( $button_target[0] );
                        }
                        else {
                            $button_link = ensure_url( $button_target );
                            $button_rel = 'rel="external nofollow"';
                        }

                        echo '<a href="'. $button_link .'" '. $button_rel .' class="button '. $button_class .' inline after-icon external full-phablet-down">'. $button_text .'</a>';
                    }
                ?>
            </div>
        </div>
    </section>
</header>