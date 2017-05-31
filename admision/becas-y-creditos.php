<?php
    /*
    Template Name: Becas y Creditos
    */
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <aside class="regular-sidebar grid-3 no-gutter-left hide-on-vertical-tablet-down">
                    <?php get_sidebar(); ?>
                </aside>
                <div class="grid-9 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                    <h1 class="single-page-title">
                        <?php the_title(); ?>
                    </h1>

                    <?php
                        the_post_thumbnail('regular-big', array(
                            'class' => 'elastic-img cover'
                        ));

                        if( !!$post->post_content ){
                            echo '<div class="page-content">';
                            the_content();
                            echo '</div>';
                        }
                    ?>

                    <div class="tabs-holder bg-blanco">
                        <div class="tabs-controls becas">
                            <button class="active" title="Ver pestaña" data-func="tabControl" data-target="becas">Becas Santo Tomás</button>
                            <button title="Ver pestaña" data-func="tabControl" data-target="convenios">Convenios</button>
                            <button title="Ver pestaña" data-func="tabControl" data-target="descuentos">Descuentos</button>
                            <button title="Ver pestaña" data-func="tabControl" data-target="mineduc">Becas Mineduc</button>
                            <button title="Ver pestaña" data-func="tabControl" data-target="cae">CAE</button>
                            <?php
                                if( get_field('activar_becas_creditos') ) {
                                    echo '<button title="Ver pestaña" data-func="tabControl" data-target="porcentajes">Porcentajes Beca PSU</button>';
                                }
                            ?>
                            
                        </div>
                        <div class="tabs-box">
                            <div class="tab-item active" data-tab-name="becas" >
                                <div class="faq-holder">
                                    <h2>Becas Santo Tomás</h2>
                                    <?php echo generate_expandables( get_field('contenidos_becas') ); ?>
                                </div>
                            </div>
                            <div class="tab-item" data-tab-name="convenios" >
                                <div class="faq-holder">
                                    <h2>Convenios</h2>
                                    <?php echo generate_expandables( get_field('contenidos_convenios') ); ?>
                                </div>
                            </div>
                            <div class="tab-item" data-tab-name="descuentos" >
                                <div class="faq-holder">
                                    <h2>Decuentos</h2>
                                    <?php echo generate_expandables( get_field('contenidos_descuentos') ); ?>
                                </div>
                            </div>
                            <div class="tab-item" data-tab-name="mineduc" >
                                <div class="faq-holder">
                                    <h2>Becas Mineduc</h2>
                                    <?php echo generate_expandables( get_field('contenidos_mineduc') ); ?>
                                </div>
                            </div>
                            <div class="tab-item" data-tab-name="cae" >
                                <div class="faq-holder">
                                    <h2>CAE</h2>
                                    <?php echo generate_expandables( get_field('contenidos_cae') ); ?>
                                </div>
                            </div>
                            
                            <?php
                                if( get_field('activar_becas_creditos') ) :
                            ?>

                            <div class="tab-item" data-tab-name="porcentajes" >
                                <div class="faq-holder">
                                    <h2>Porcentajes Beca PSU</h2>

                                    <?php
                                        if( get_field('contenido_becas_creditos') === 'tabla' ) :
                                    ?>

                                    <?php $table_data = generate_porcentajes_table(); ?>

                                    <div class="special-table-filters">
                                        <form class="regular-form parent">
                                            <div class="grid-3 grid-tablet-4 grid-smalltablet-12 no-gutter-smalltablet">
                                                <label for="porcentajes-institucion" class="regular-label">Institución</label>
                                                <select class="regular-input select" id="porcentajes-institucion" name="institucion" data-col-filter="0">
                                                    <option value="" >Todas</option>
                                                    <?php 
                                                        echo implode('', $table_data['institucion_options']);
                                                    ?>
                                                </select>
                                            </div> 
                                            <div class="grid-3 grid-tablet-4 grid-smalltablet-12 no-gutter-smalltablet">
                                                <label for="porcentajes-sede" class="regular-label">Sedes</label>
                                                <select class="regular-input select" id="porcentajes-sede" name="sede" data-col-filter="1">
                                                    <option value="" >Todas</option>
                                                    <?php 
                                                       echo implode('', $table_data['sedes_options']); 
                                                    ?>
                                                </select>
                                            </div> 
                                            <div class="grid-3 grid-tablet-4 grid-smalltablet-12 no-gutter-smalltablet">
                                                <label for="porcentajes-carrera" class="regular-label">Carrera</label>
                                                <select class="regular-input select" id="porcentajes-carrera" name="carrera" data-col-filter="2">
                                                    <option value="" >Todas</option>
                                                    <?php 
                                                        echo implode('', $table_data['carreras_options']);
                                                    ?>
                                                </select>
                                            </div> 
                                            <div class="grid-3 grid-tablet-12 no-gutter-tablet">
                                                <label for="porcentajes-jornada" class="regular-label">Jornada</label>
                                                <select class="regular-input select" id="porcentajes-jornada" name="jornada" data-col-filter="3">
                                                    <option value="" >Todas</option>
                                                    <?php 
                                                       echo implode('', $table_data['jornadas_options']);
                                                    ?>
                                                </select>
                                            </div> 
                                        </form>
                                    </div>
                                    
                                    <table class="special-table" data-role="filtered-table" data-tabletype="paginated">
                                        <thead>
                                            <tr>
                                                <th>Institucion</th>
                                                <th>Sede</th>
                                                <th>Carrera</th>
                                                <th>Jornada</th>
                                                <th style="min-width: 70px;">Puntaje</th>
                                                <th style="min-width: 100px;">% Descuento</th>
                                                <!--th style="min-width: 70px;">15%</th>
                                                <th style="min-width: 70px;">20%</th>
                                                <th style="min-width: 70px;">25%</th>
                                                <th style="min-width: 70px;">30%</th>
                                                <th style="min-width: 70px;">35%</th>
                                                <th style="min-width: 70px;">45%</th>
                                                <th style="min-width: 70px;">50%</th>
                                                <th style="min-width: 70px;">60%</th>
                                                <th style="min-width: 70px;">75%</th>
                                                <th style="min-width: 70px;">80%</th>
                                                <th style="min-width: 70px;">100%</th-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $table_data['table_rows']; ?>
                                        </tbody>
                                    </table>

                                    <?php
                                        else :
                                    ?>

                                    <?php
                                        the_field('contenido_becas_creditos');
                                    ?>

                                    <?php
                                        endif;
                                    ?>
                                </div>
                            </div>

                            <?php
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>