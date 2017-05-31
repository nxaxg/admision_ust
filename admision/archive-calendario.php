<?php 

$filter_id = 0;
if( isset($_GET['filtro']) && $_GET['filtro'] ){
    $filter = get_term_by( 'slug', $_GET['filtro'], 'tipos_calendarios' );
    $filter_id = (int)$filter->term_id;
}

get_header();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <h1 class="single-page-title">
                    Calendario
                </h1>

                <?php
                    echo apply_filters('the_content', get_field('texto_de_introduccion_calendario', 'option'));
                ?>

                <?php
                    $current_month_name = date_i18n('F');
                    $current_month_num = date('n');
                    $current_year = date('Y');
                    $last_day_of_month = date('t', mktime(0,0,0, $current_month_num, 1, $current_year));

                    $prev_month = strtotime("-1 month", mktime(0,0,0, $current_month_num, 1, $current_year));
                    $prev_month = date_i18n('F - Y', $prev_month);

                    $next_month = strtotime("+1 month", mktime(0,0,0, $current_month_num, 1, $current_year));
                    $next_month = date_i18n('F - Y', $next_month);
                ?>

                <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <?php
                    /*
                    <div class="special-table-filters">
                        <form class="regular-form centered-text" data-validation="calendar-filters">
                            <label class="regular-label inline-label full-vertical-tablet-down">
                                <span class="hide-on-vertical-tablet-down" >Mostrar</span>
                                <select id="calendar-filter" class="regular-input select inline-input full-vertical-tablet-down" name="tipos_calendarios" >
                                    <option value="" >Todos los calendarios</option>
                                    <?php
                                        $cals = get_terms('tipos_calendarios');
                                        if( !empty($cals) ){
                                            foreach( $cals as $cal ){
                                                $selected = $filter_id == $cal->term_id ? 'selected' : '';
                                                echo '<option '. $selected .' value="'. $cal->term_id .'" >'. $cal->name .'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </label>
                            <input class="button secundario small full-vertical-tablet-down" type="submit" value="Filtrar">
                        </form>
                    </div>
                    */
                    ?>

                    <div class="events-date-nav-holder" data-role="calendar-data" data-month="<?php echo $current_month_num; ?>" data-year="<?php echo $current_year; ?>" >
                        <button class="events-date-button prev" data-func="calendarControl" data-direction="prev" ></button>
                        <h2 class="events-date-title" data-role="calendar-month" data-prev="<?php echo $prev_month; ?>" data-next="<?php echo $next_month; ?>">
                            <?php echo $current_month_name . ' - ' . $current_year; ?>
                        </h2>
                        <button class="events-date-button next" data-func="calendarControl" data-direction="next" ></button>
                    </div>
                    <div class="bg-blanco archive-holder regular-shadow" data-role="calendar-items-holder">
                        <?php
                            $period_start = date('Ymd', mktime(0,0,0, $current_month_num, 1, $current_year));
                            $period_end = date('Ymd', mktime(23,59,59, $current_month_num, $last_day_of_month, $current_year));

                            $tax_query = null;
                            if( !!$filter_id ){
                                $tax_query = array(
                                    array(
                                        'taxonomy' => 'tipos_calendarios',
                                        'field' => 'term_id',
                                        'terms' => $filter_id
                                    )
                                );
                            }

                            $items = generate_calendar_module_list(array(
                                'post_type' => 'calendario',
                                'post_status' => 'publish',
                                'posts_per_page' => 999,
                                'meta_key' => 'fecha_inicio',
                                'orderby' => 'meta_value_num',
                                'order' => 'ASC',

                                'tax_query' => $tax_query,
                                
                                /// todos los posts que sean dentro de este mes
                                /// desde el primer hasta el ultimo dia
                                'meta_query' => array(
                                    'relation' => 'OR',
                                    array(
                                        array(
                                            'key'     => 'fecha_inicio',
                                            'value'   => [$period_start, $period_end],
                                            'compare' => 'BETWEEN'
                                        )
                                    ),
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'key'     => 'fecha_inicio',
                                            'value'   => $period_start,
                                            'compare' => '>='
                                        ),
                                        array(
                                            'key'     => 'fecha_termino',
                                            'value'   => $period_start,
                                            'compare' => '<='
                                        )
                                    )
                                )
                            ));

                            echo $items;
                        ?>
                    </div>
                </div>
                <aside class="regular-sidebar grid-3 no-gutter-right hide-on-vertical-tablet-down">
                    <div class="sidebar-widget">
                        <?php
                            echo generate_events_calendar();
                        ?>
                    </div>
                    <section class="content-box">
                        <h2 class="content-box-title primario light">
                            <span class="tag full">Información de interés</span>
                        </h2>
                        <div class="content-box-body">
                            <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'interes_general',
                                    'menu_class' => 'regular-list',
                                    'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>'
                                ));
                            ?>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>