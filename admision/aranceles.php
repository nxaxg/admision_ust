<?php
    /*
    Template Name: Aranceles
    */

    needs_script('dataTables');
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

                        $tabla = get_field('tabla');
                        $tabla = $wpdb->get_results("SELECT institucion, zonaDeAdmision, name, jornada, matricula, arancel FROM santotomas_carreras ORDER BY institucion DESC, name ASC, jornada ASC");

                        if( !empty($tabla) ):

                            $rows_html = '';

                            foreach( $tabla as $row ){

                                $rows_html .= '<tr class="visible" >';

                                $rows_html .= '<td data-col-label="Institución" data-col="institucion" data-value="'. $row->institucion .'">'. $row->institucion .'</td>';
                                $rows_html .= '<td data-col-label="Sede" data-col="sede" data-value="'. $row->zonaDeAdmision .'">'. $row->zonaDeAdmision .'</td>';

                                $rows_html .= '<td data-col-label="Carrera" data-col="carrera" data-value="'. $row->name .'">'.$row->name .'</td>';

                                $rows_html .= '<td data-col-label="Jornada" data-col="jornada" data-value="'. $row->jornada .'">'. $row->jornada .'</td>';
                                $rows_html .= '<td data-col-label="Matrícula" data-col="matricula" data-value="'. $row->matricula .'">$'. number_format($row->matricula, 0, ',', '.')  .'</td>';
                                $rows_html .= '<td data-col-label="Arancel Anual" data-col="arancel_anual" data-value="'.  $row->arancel .'">$'.  number_format($row->arancel, 0, ',', '.') .'</td>';

                                $rows_html .= '</tr>';
                            }

                            // se eliminan los vlaores duplicados y se ordenan alfabeticamente
                            $sedes = $wpdb->get_results("SELECT name FROM santotomas_zonasadmision ORDER BY region ASC");
                            $sedes_options = array();

                            foreach( $sedes as $sede ) :
                                $sedes_options[] = $sede->name;
                            endforeach;

                            $sedes_options = array_unique( $sedes_options );

                    ?>
                    <h2 class="standalone-heading" >Búsqueda de aranceles</h2>

                    <div class="special-table-filters">
                        <form class="regular-form centered-text" >
                            <label class="regular-label inline-label full-vertical-tablet-down">
                                <span class="hide-on-vertical-tablet-down" >Mostrar</span>
                                <select class="regular-input select inline-input full-vertical-tablet-down" name="sede" data-func="specialFormFilter" data-events="change.ST">
                                    <option value="">Todas las sedes</option>
                                    <?php
                                        foreach( $sedes_options as $s ){
                                            echo '<option value="'. $s .'" >'. $s .'</option>';
                                        }
                                    ?>
                                </select>
                            </label>
                            <!-- <input class="button secundario small full-vertical-tablet-down" type="submit" value="Filtrar"> -->
                        </form>
                    </div>
                    <em class="warning-message"><?php echo get_field('texto_legal', 'options'); ?></em>
                    <table class="special-table" data-sticky-dad  data-role="filtered-table" data-tabletype="sortable" data-order='[[ 0, "desc" ]]'>
                        <thead data-fixed="fixed" data-stickybox="[data-sticky-dad]">
                            <tr>
                                <th>Institución</th>
                                <th>Sede</th>
                                <th>Carrera</th>
                                <th>Jornada</th>
                                <th>Matrícula <small>*</small></th>
                                <th>Arancel Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $rows_html; ?>
                        </tbody>
                    </table>

                    <?php endif; ?>
                    <em class="warning-message"><?php echo get_field('texto_legal', 'options'); ?></em>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>
