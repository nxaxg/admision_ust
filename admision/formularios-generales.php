<?php
    /*
    Template Name: Formularios
    */

    //// acciones para recibir el POST del formulario
    $sending_form_valid = false;
    if( isset( $_POST['st_nonce'] ) && strpos( $_SERVER['REQUEST_URI'] ,'exito') ){
        $sending_form_valid = send_crm_form();
    }
    elseif( strpos( $_SERVER['REQUEST_URI'] ,'exito') !== false ){
        wp_redirect( get_permalink( $post->ID ), 301 );
        exit;
    }
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">
            <section class="page-body parent">
                <h1 class="single-page-title">
                    <?php the_title(); ?>
                </h1>

                <?php the_content(); ?>

                <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <div class="page-content">
                        <?php
                            if( !$sending_form_valid ){
                                $form_type = get_field('formulario');
                                get_template_part('partials/formulario', $form_type);
                            }
                            else { ?>
                                <div class="feedback">
                                    <h2 class="feedback-title">¡Gracias!</h2>
                                    <?php
                                        if( $_POST['ws-form-name'] != 'tellamamos') {
                                            echo '<p class="feedback-intro">El formulario se ha enviado con éxito, los datos enviados son:</p>';
                                        }
                                        else {
                                            echo '<p class="feedback-intro">Te llamaremos a la brevedad.</p>
                                                  <p class="feedback-intro">El formulario se ha enviado con éxito, los datos enviados son:</p>
                                                  ';
                                        }

                                        // se sacan los datos desde el POST
                                        $rut = $_POST['contacto-rut'];
                                        $nombre = $_POST['contacto-nombre'];
                                        $apellido_paterno = $_POST['contacto-apellido-paterno'];
                                        $apellido_materno = isset($_POST['contacto-apellido-materno']) ? $_POST['contacto-apellido-materno'] : '';
                                        $nombre_completo = "$nombre $apellido_paterno $apellido_materno";
                                        $mail = $_POST['contacto-email'];
                                        $celular = $_POST['contacto-celular-codigo'] . '-' . $_POST['contacto-celular-numero'];


                                        $telefono = '';
                                        if( isset($_POST['contacto-telefono-codigo']) && $_POST['contacto-telefono-codigo'] && isset($_POST['contacto-telefono-numero']) && $_POST['contacto-telefono-numero'] ){
                                            $telefono = $_POST['contacto-telefono-codigo'] . '-' . $_POST['contacto-telefono-numero'];
                                        }


                                        $mensaje = isset($_POST['contacto-mensaje']) ? $_POST['contacto-mensaje'] : false;
                                    ?>

                                    <div class="feedback-body">
                                        <div class="personales">
                                            <p class="nombre"><?php echo $nombre_completo; ?></p>
                                            <p>RUT: <?php echo $rut; ?></p>
                                            <p>Mail: <?php echo $mail; ?></p>
                                            <p>Celular: <?php echo $celular; ?></p>
                                            <?php
                                                // campo opcional
                                                if( $telefono ){
                                                    echo '<p>Teléfono: '. $telefono .'</p>';
                                                }
                                            ?>
                                        </div>

                                        <?php if( $mensaje ): ?>
                                            <div class="mensaje">
                                                <p><strong>Comentario:</strong></p>
                                                <?php echo apply_filters('the_content', $mensaje); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <p>En caso de que tus datos se encuentren incorrectos puedes volver a enviar el formulario</p>

                                    <a class="button secundario small wide full-vertical-tablet-down" href="<?php the_permalink(); ?>" title="Volver al formulario" >Volver</a>
                                </div>
                            <?php }
                        ?>
                    </div>
                </div>
                <aside class="regular-sidebar grid-3 no-gutter-right hide-on-vertical-tablet-down">
                    <section class="content-box">
                        <h2 class="content-box-title corporativo dark">
                            <span class="tag full">¿Necesitas Ayuda?</span>
                        </h2>
                        <div class="content-box-body expanded-help">
                            <?php echo get_help_links('ayuda'); ?>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>
