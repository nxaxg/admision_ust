<?php

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Filtros y actions
////////////////////////////////////////////////////////////////////////////////

add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5');
add_theme_support('menus');

if( function_exists('acf_set_options_page_title') ){
    acf_set_options_page_title('Opciones del sitio');
}

if( function_exists('acf_set_options_page_menu') ){
    acf_set_options_page_menu('Opciones del sitio');
}

if( function_exists('acf_add_options_sub_page') ){
    // configuracion de portada
    acf_add_options_sub_page(array(
        'title' => 'Portada',
        'capability' => 'list_users'
    ));

    // configuracion de generales
    acf_add_options_sub_page(array(
        'title' => 'Generales',
        'capability' => 'list_users'
    ));

    acf_add_options_sub_page(array(
        'title' => 'Portadillas especiales',
        'capability' => 'list_users'
    ));
}


////// tamanos de imagen
add_image_size( 'regular-tiny', 120, 68, true );
add_image_size( 'regular-small', 280, 157, true );
add_image_size( 'regular-ensayo-medium', 205, 116, true );
add_image_size( 'regular', 382, 256, true );
add_image_size( 'regular-medium', 591, 354, true );
add_image_size( 'regular-big', 716, 400, true );
add_image_size( 'regular-bigger', 894, 500, true );
add_image_size( 'regular-biggest', 1200, 350, true );
add_image_size( 'full-header', 1300, 600, true );
add_image_size( 'full-header-small', 1300, 490, true );
add_image_size( 'square', 300, 300, true );

//Custom mime
//Archivos SVG
add_filter( 'upload_mimes', 'custom_upload_mimes' );
function custom_upload_mimes( $existing_mimes = array() ) {
    // Add the file extension to the array
    $existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
}

function add_async_attribute($tag, $handle) {
    if ( 'modernizr' !== $handle )
        return $tag;
    return str_replace( ' src', ' defer="defer" async="async" src', $tag );
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

/////////////////////// Incrusta Estilos y Javascript en el <head>
///
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
add_action("wp_enqueue_scripts", "incrustar_scripts", 20);
function incrustar_scripts(){
    if( !is_admin() ){
        /// scrips que dependen de cada pagina

        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array('modernizr'), '2.1.3', true );

        // modernizr
        wp_register_script('modernizr', get_bloginfo('template_directory') . '/scripts/libs/modernizr.js', array(), '2.6.2',false );

        // google maps API
        wp_register_script('google_maps_api', 'http://maps.googleapis.com/maps/api/js?key=AIzaSyBpJo3_GYICeNkcNurkaMn0UkakPs6mYw8', array(), '1', true );

        // google maps handler
        wp_register_script('mapsHandler', get_bloginfo('template_directory'). '/scripts/libs/ninjaMap.js', array('jquery', 'google_maps_api'), '1', true );

        // jquery-rut
        wp_register_script('jquery-rut', get_bloginfo('template_directory'). '/scripts/libs/jquery.Rut.js', array('jquery'), '1', true );

        // validizr
        wp_register_script('validizr', get_bloginfo('template_directory'). '/scripts/libs/validizr.js', array('jquery', 'jquery-rut'), '1', true );

        // Owl Carousel
        wp_register_script('owlCarousel', get_bloginfo('template_directory'). '/scripts/libs/owl.carousel.min.js', array('jquery'), '1', true );

        // ninjaSlider
        wp_register_script('ninjaSlider', get_bloginfo('template_directory'). '/scripts/libs/ninjaSlider.js', array('jquery', 'owlCarousel'), '1', true );

        // ninjaSlider sin dependencia
        wp_register_script('ninjaSlider_solo', get_bloginfo('template_directory'). '/scripts/libs/ninjaSlider.js', array('jquery'), '1', true );

        // enquire
        wp_register_script('enquireJS', get_bloginfo('template_directory'). '/scripts/libs/enquire.js', array('jquery'), '1', true );

        // enquire
        wp_register_script('fitVids', get_bloginfo('template_directory'). '/scripts/libs/fitvids.js', array('jquery'), '1', true );

        // stickybox
        wp_register_script('ninjaStickyBox', get_bloginfo('template_directory'). '/scripts/libs/ninja-sticky.js', array('jquery'), '1', true );

        // Jquery data tables
        wp_register_script('dataTables', get_bloginfo('template_directory'). '/scripts/libs/jquery.dataTables.js', array('jquery'), '1', true );

        // Masonry
        wp_register_script('masonry', get_bloginfo('template_directory'). '/scripts/libs/masonry.min.js', array('jquery'), '1', true );

        // mainScript
        wp_register_script('mainScript', get_bloginfo('template_directory'). '/scripts/main.js', array('enquireJS', 'modernizr', 'jquery', 'validizr', 'masonry', 'fitVids', 'dataTables', 'ninjaStickyBox' ), '1.1', true );

        wp_register_script('funciones_cotizacion', get_bloginfo('template_directory'). '/scripts/funciones-cotizacion.js', array('mainScript'), '1.1', true );

        wp_enqueue_script('mainScript');

        // se saca el script de jetpack en el front
        wp_dequeue_script('devicepx');
    }
}

///// imprime las etiquetas de app-icons
add_action("wp_head", "app_icons_metas");
function app_icons_metas(){
    $template = get_bloginfo('template_directory');
    echo '<link rel="icon" href="'. $template .'/images/app-icons/favicon.ico" type="image/x-icon">';
    echo '<link rel="shortcut icon" href="'. $template .'/images/app-icons/favicon.ico" type="image/x-icon">';
    echo '<meta name="msapplication-square70x70logo" content="'. $template .'/images/app-icons/ms-icno-70x70.png">';
    echo '<meta name="msapplication-square150x150logo" content="'. $template .'/images/app-icons/ms-icon-150x150.png">';
    echo '<meta name="msapplication-square310x310logo" content="'. $template .'/images/app-icons/ms-icon-310x310.png">';
    echo '<link rel="apple-touch-icon" href="'. $template .'/images/app-icons/apple-icon.png">';
    echo '<link rel="apple-touch-icon" sizes="76x76" href="'. $template .'/images/app-icons/apple-icon-76x76.png">';
    echo '<link rel="apple-touch-icon" sizes="120x120" href="'. $template .'/images/app-icons/apple-icon-120x120.png">';
    echo '<link rel="apple-touch-icon" sizes="152x152" href="'. $template .'/images/app-icons/apple-icon-152x152.png">';
}

// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );
add_action('wp_print_styles', 'sacar_estilos_extra');
function sacar_estilos_extra(){
    if( !is_admin() ){
        // Saco los estilos de jetpack en el front
        wp_deregister_style( 'AtD_style' ); // After the Deadline
        wp_deregister_style( 'jetpack_likes' ); // Likes
        wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
        wp_deregister_style( 'jetpack-carousel' ); // Carousel
        wp_deregister_style( 'grunion.css' ); // Grunion contact form
        wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
        wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
        wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
        wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
        wp_deregister_style( 'noticons' ); // Notes
        wp_deregister_style( 'post-by-email' ); // Post by Email
        wp_deregister_style( 'publicize' ); // Publicize
        wp_deregister_style( 'sharedaddy' ); // Sharedaddy
        wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
        wp_deregister_style( 'stats_reports_css' ); // Stats
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
        wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
        wp_deregister_style( 'presentations' ); // Presentation shortcode
        wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
        wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
        wp_deregister_style( 'widget-conditions' ); // Widget Visibility
        wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
        wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
        wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
    }
}

//// metemos el estilo principal en el footer para dejar feliz a pagespeed insights
add_action('wp_print_styles', 'incrustar_estilos');
function incrustar_estilos(){
    wp_register_style('main_style', get_bloginfo('template_directory') . '/css/main.min.css' );
    wp_enqueue_style( 'main_style' );
}

/////////////////////// Saca los query strings de los css y js, ayuda al page speed
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) ) { $src = remove_query_arg( 'ver', $src ); }
    return $src;
}

/////////////////////// Saca la version de wordpress del head para seguridad
add_filter('the_generator', 'remove_wp_version');
function remove_wp_version() { return ''; }

/////////////////////// Saca los widgets inecesarios del dashboard
add_action('wp_dashboard_setup', 'sacar_dashboard_widgets' );
function sacar_dashboard_widgets(){
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
}

////////////////////// Le quita el contenedor a la funcion we_nav_menu
function change_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}
add_filter( 'wp_nav_menu_args', 'change_wp_nav_menu_args' );

////////////////////// Quita del admin la interfaz de los posts comunes y otras cosas por defecto porque no se van a usar
add_action('admin_menu', 'remove_default_menus');
function remove_default_menus(){
    if( function_exists('remove_menu_page') ){
    //    remove_menu_page('edit.php'); // post comunes
        remove_menu_page('edit-comments.php'); // comentarios
        remove_menu_page('link-manager.php'); // Links
    }
}

////////////////////// desactiva la seleccion de multiples categorias en los posts

////////////////////////////////////////////////////////////////////////////////
//////////////////// Busqueda avanzada
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//////////////////// Adicion de permastruct de las carreras
////////////////////////////////////////////////////////////////////////////////
add_filter('post_type_link', 'careers_permalink_structure', 10, 4);
function careers_permalink_structure($post_link, $post, $leavename, $sample){
    if( $post->post_type === 'carrera' && strpos( $post_link, '%institucion%' ) ){
        $tipos = get_the_terms( $post->ID, 'institucion' );
        if( !empty($tipos) ){
            $tipo = array_shift($tipos);
            $post_link = str_replace( '%institucion%', $tipo->slug, $post_link );
        }
    }
    return $post_link;
}


////////////////////////////////////////////////////////////////////////////////
//////////////////// Adicion de permastruct del archivo de sedes
////////////////////////////////////////////////////////////////////////////////
/// anade la relga de escritura para /sedes/
/// y otras URLs personalizadas
add_action('init', 'sedes_rules');
function sedes_rules(){
    add_rewrite_rule('sedes$', 'index.php?archivo=sedes', 'top');
}

/// anade los query vars customizados a la wp_query
add_filter('query_vars', 'sedes_query_vars');
function sedes_query_vars( $vars ){
    $vars[] = 'archivo';
    return $vars;
}

// setea el redirect al template de el archivo de sedes
add_filter('template_redirect', 'sedes_template_redirect');
function sedes_template_redirect(){
    if( get_query_var('archivo') === 'sedes' ){
        add_filter( 'wpseo_title', 'sedes_template_title_tag' );
        get_template_part('archivo-sedes');
        exit;
    }
}

// filtro para el title tag de wordpress seo
function sedes_template_title_tag( $title ){
    $title .= ' Sedes';
    return $title;
}


////////////////////////////////////////////////////////////////////////////////
//////////////////// Adicion de permastruct para los selectores del formulario
////////////////////////////////////////////////////////////////////////////////
add_action('init', 'selectores_rules');
function selectores_rules(){
    add_rewrite_rule('ajax-selector$', 'index.php?selectores=ajax', 'top');
}

/// anade los query vars customizados a la wp_query
add_filter('query_vars', 'selectores_query_vars');
function selectores_query_vars( $vars ){
    $vars[] = 'selectores';
    return $vars;
}

// setea el redirect al template de el archivo de sedes
add_filter('template_redirect', 'selectores_template_redirect');
function selectores_template_redirect(){
    if( get_query_var('selectores') === 'ajax' ){
        get_template_part('partials/ajax-selectores');
        exit;
    }
}


////////////////////////////////////////////////////////////////////////////////
//////////////////// Nav Menus
////////////////////////////////////////////////////////////////////////////////
add_action( 'after_setup_theme', 'resgistrar_menus' );
function resgistrar_menus() {
    register_nav_menu( 'secundario', __( 'Menu Secundario' ) );
    register_nav_menu( 'principal_general', __( 'Menu Principal General' ) );
    register_nav_menu( 'principal_admision', __( 'Menu Principal Admisión' ) );
    register_nav_menu( 'footer_principal', __( 'Menu Footer Principal' ) );
    register_nav_menu( 'footer_secundario', __( 'Menu Footer Secundario' ) );
    register_nav_menu( 'conoce_mas', __( 'Menú Conoce más' ) );
    register_nav_menu( 'interes_general', __( 'Informacion de interés general' ) );
    register_nav_menu( 'mapasitio', __( 'Mapa del Sitio' ) );
}

////////////////////////////////////////////////////////////////////////////////
//////////////////// Filtros para ACF
////////////////////////////////////////////////////////////////////////////////

// filtro para las paginas de indice
add_filter('acf/fields/relationship/query/name=pagina', 'alter_indices_field_query', 10, 3);
function alter_indices_field_query($args, $field, $post){
    $args['post_parent'] = $post->ID;
    return $args;
}

add_filter( 'embed_oembed_html', 'filtrar_youtube_embed', 10, 4 ) ;
function filtrar_youtube_embed($html, $url, $attr, $post_id) {
    return str_replace( '?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&rel=0', $html );
}


////////////////////////////////////////////////////////////////////////////////
//////////////////// Filtros en Admin para usuarios con sede asociada
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Rewrites personalizados
////////////////////////////////////////////////////////////////////////////////
add_action('init', 'rewrites_personalizados');
function rewrites_personalizados(){
    // solucion para conflicto de URL entre la seccion carreras
    // y el post type carreras
    add_rewrite_rule('carreras/([^/]*)$', 'index.php?pagename=$matches[1]', 'top');
    add_rewrite_rule('carreras/([^/]*)/([^/]*)$', 'index.php?name=$matches[2]&post_type=carrera', 'top');


    // url de exito en el formulario de contacto
    add_rewrite_rule('contacto/exito$', 'index.php?page_id='. get_post_by_slug('contacto', 'ID') .'&pagename=contacto', 'top');

    // url de exito en el formulario te llamamos
    add_rewrite_rule('te-llamamos/exito$', 'index.php?page_id='. get_post_by_slug('te-llamamos', 'ID') .'&pagename=te-llamamos', 'top');


    // url de exito en el formulario de contacto
    // add_rewrite_rule('como-postular/contactanos/exito$', 'index.php?page_id='. get_post_by_slug('contactanos', 'ID') .'&pagename=contactanos', 'top');
}

add_filter( 'redirect_canonical','custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url ){
    global $post;
    if ( $post->post_parent == 449 ){ $redirect_url = false; }
    return $redirect_url;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Funciones Generales
////////////////////////////////////////////////////////////////////////////////
/**
 * rescata y separa las sedes asociadas a las carreras
 * Se usa para la caja "sedes y jornadas" en single carrera
 * @param  [int] $post_id  - ID de la carrera
 * @return array           - Array con las sedes ordenadas por zona
 */
function separar_sedes_carrera( $post_id ){
    // se sacan los grupos desde el option
    $zn = get_field('sedes_zona_norte', 'options');
    $zc = get_field('sedes_zona_centro', 'options');
    $zs = get_field('sedes_zona_sur', 'options');

    $ordenadas = array(
        'zona_norte' => array(),
        'zona_centro' => array(),
        'zona_sur' => array()
    );

    $sedes_asociadas = get_field('sedes_jornadas', $post_id);

    foreach ( $sedes_asociadas as $sede ) {
        // busca zona norte
        if( in_array( (int)$sede['sede'], $zn ) ){
            $ordenadas['zona_norte'][] = $sede;
            continue;
        }

        // busca zona centro
        if( in_array( $sede['sede'], $zc ) ){
            $ordenadas['zona_centro'][] = $sede;
            continue;
        }

        // busca zona sur
        if( in_array( $sede['sede'], $zs ) ){
            $ordenadas['zona_sur'][] = $sede;
            continue;
        }
    }

    return $ordenadas;
}

/**
 * Genera los links del modulo de ayuda
 * La idea es que cambien por contexto y no por estructura.
 * @return string - HTML
 */
function get_help_links( $type = 'accesos' ){
    $out = '<a class="help-link icon chat" href="'. get_link_by_slug('te-llamamos') .'" title="¿Tienes dudas? Te llamamos" rel="help" data-track data-gtm-event="te-llamamos" data-gtm-eventcategory="te-llamamos" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-tellamamos" >¿Tienes dudas? Te llamamos</a>';
    $out .= '<a class="help-link icon clock" href="'. get_link_by_slug('sedes') .'" title="Horarios de atención" rel="help" data-track data-gtm-event="horarios-de-atencion" data-gtm-eventcategory="horarios" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-horarios" >Horarios de atención</a>';
    $out .= '<a class="help-link icon mail" href="'. get_link_by_slug('contacto') .'" title="Contáctanos" rel="help" data-track data-gtm-event="clic-to-call" data-gtm-eventcategory="clic-to-call" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-clictocall">Contáctanos</a>';

    if( $type !== 'accesos' ){
        $perfiles = get_social_links();

        $out .= '<a class="help-link icon facebook" href="'. ensure_url( $perfiles['facebook'] ) .'" title="Conversemos en Facebook" rel="help external nofollow" target="_blank" data-track data-gtm-event="facebook" data-gtm-eventcategory="conversemos-fb" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-facebook" >Conversemos en Facebook</a>';
        $out .= '<a class="help-link icon twitter" href="'. ensure_url( $perfiles['twitter'] ) .'" title="Conversemos en Twitter" rel="help external nofollow" target="_blank" data-track data-gtm-event="twitter" data-gtm-eventcategory="conversemos-tw" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-twitter">Conversemos en Twitter</a>';
    }

    $out .= '<a class="help-link icon phone" href="tel:6004444444" title="Llámanos" rel="help">600 444 4444</a>';

    if( $type === 'accesos' ){
        $out .= '<a class="help-link icon question" href="'. get_link_by_slug('preguntas-frecuentes') .'" title="Preguntas frecuentes" rel="help">Preguntas frecuentes</a>';
    }

    return $out;
}

/**
 * Genera la navegación interna de las paginas, para el sidebar
 * @param  int $parent_id - post_id de donde sacar los hijos
 * @param  int $current_id - post_id para forzar un estado activo, debe corresponderse con algun hijo de $parent_id
 * @return string - HTML de la navegacion
 */
function get_page_navigation( $parent_id, $current_id = 0 ){
    global $post;

    $children = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'page',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));

    $html = '';

    foreach( $children as $child ){
        $current = is_page( $child->ID ) || $post->ID === $child->ID || $current_id === $child->ID ? 'current' : '';
        $title = get_the_title( $child->ID );

        $html .= '<a class="'. $current .'" href="'. get_permalink($child->ID) .'" title="Ir a '. $title .'" rel="section">'. $title .'</a>';
    }

    wp_reset_query();

    // revisa si es que el $parent tiene configurados
    // links adicionales
    $links = get_field('links_adicionales', $parent_id);
    if( !empty($links) ){
        foreach( $links as $link ){
            $html .= '<a href="'. $link['url'] .'" title="Ir a '. $link['texto'] .'" rel="section">'. $link['texto'] .'</a>';
        }
    }

    return $html;
}

/**
 * Genera el modulo HTML del buscador de carreras
 * @return string - HTML del modulo
 */
function get_career_search_fields(){
    ?>

    <section class="career-search-section" >
        <form class="career-search-form" data-validation="career-search" data-filter-type="institucion"  autocomplete="off">
            <label>Conoce nuestras carreras</label>
            <select name="institucion" required data-custom-validation="careerSelect" autocomplete="off">
                <option value="" >Selecciona una institución</option>
                <?php
                    $terms = get_terms('institucion');
                    usort( $terms, 'order_institucion_by_posicion' );

                    foreach( $terms as $t ){
                        echo '<option value="'. $t->term_id .'" >'. $t->name .'</option>';
                    }
                ?>
            </select>
        </form>
    </section>
    <section class="career-search-section" >
        <form class="career-search-form" data-validation="career-search" data-filter-type="areas_general" autocomplete="off">
            <label>Nuestras carreras por área</label>
            <select name="areas_general" required data-custom-validation="careerSelect" autocomplete="off">
                <option value="" >Selecciona un área</option>
                <?php
                    $terms = get_terms('areas_general');
                    foreach( $terms as $t ){
                        echo '<option value="'. $t->term_id .'" >'. $t->name .'</option>';
                    }
                ?>
            </select>
        </form>
    </section>
    <section class="career-search-section" >
        <form class="career-search-form" data-validation="career-search" data-filter-type="sede" autocomplete="off">
            <label>Nuestras carreras por sede</label>
            <select name="sede" required data-custom-validation="careerSelect" autocomplete="off">
                <option value="" >Selecciona una sede</option>
                <?php
                    echo generate_ordering_option_sedes( get_terms('sede') );
                ?>
            </select>
        </form>
    </section>

    <?php
}

/**
 * Genera las listas de modulos de calendarios, se usa en el archivo de calendario
 * @param  array $query_args - Array de opciones para WP_Query
 * @return string - HTML de la lista
 */
function generate_calendar_module_list( $query_args ){
    $q = new WP_Query( $query_args );

    $out = '';
    if( $q->have_posts() ){
        while( $q->have_posts() ){
            $q->the_post();
            $out .= generate_calendar_module( $q->post );
        }
    }
    else {
        $out = alerta(array(
            'titulo' => 'Lo sentimos',
            'mensaje' => 'No se encontraron eventos en esta fecha.'
        ));
    }

    wp_reset_query();
    return $out;
}

/**
 * [list_careers_by_sede description]
 * @param  string $sede        - Slug de la Sede
 * @param  string $institucion - Slug de la institucion
 * @return string              - Lista HTML formateada
 */
function list_careers_by_sede( $sede, $institucion ){
    $q = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'carrera',
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'sede',
                'field' => 'slug',
                'terms' => $sede
            ),
            array(
                'taxonomy' => 'institucion',
                'field' => 'slug',
                'terms' => $institucion
            )
        )
    ));

    $queried_sede = get_term_by('slug', $sede, 'sede');

    $list = '';

    if( $q->have_posts() ){
        $list .= '<ul class="regular-list" >';

        while( $q->have_posts() ){
            $q->the_post();

            $sedes_asociadas = get_field('sedes_jornadas', $post->ID);
            foreach( $sedes_asociadas as $row ){
                if( $row['sede'] == $queried_sede->term_id ){
                    $jornadas = $row['tipo_jornada'];
                    break;
                }
            }

            $jornadas = strtolower(implode(' ', $jornadas));

            $list .= '<li><a class="sede-link '. $jornadas .'" href="'. get_permalink() .'" title="Ver carrera" >'. get_the_title() .'</a></li>';
        }

        $list .= '</ul>';
    }

    return $list;
}

/**
 * Compara el ID de la sede con los campos personalizados
 * para deducir cual es la zona de dicha sede
 * @param  int $sede_id     - ID del term de la sede
 * @return string
 */
function get_sede_zone( $sede_id ){
    // se sacan los grupos desde el option
    $zona = get_field('sedes_zona_norte', 'options');
    if( in_array($sede_id, $zona) ){ return 'Zona Norte'; }

    $zona = get_field('sedes_zona_centro', 'options');
    if( in_array($sede_id, $zona) ){ return 'Zona Centro'; }

    $zona = get_field('sedes_zona_sur', 'options');
    if( in_array($sede_id, $zona) ){ return 'Zona Sur'; }
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Generadores
////////////////////////////////////////////////////////////////////////////////
/**
 * Genera el HTML de los breadcrumbs
 * @return string - HTML de los breadcrumbs
 */
function generate_breadcrumbs(){
    global $post, $wp_query;

    $items = '';

    // link al inicio siempre presente
    $items .= '<a href="'. home_url() .'" title="Ir a la página de inicio" rel="index">Inicio</a>';

    // en lso singles y singulars siempre va el titulo al final
    if( is_singular() ) {
        if( is_page() ){
            $ancestors = get_post_ancestors( $post );
            $ancestors = array_reverse($ancestors);

            if( !empty($ancestors) ){
                foreach( $ancestors as $parent_id ){
                    $items .= '<a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a>';
                }
            }
        }
        elseif( is_singular('carrera') ){
            $parent_id = get_post_by_slug('carreras', 'ID');
            $items .= '<a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a>';
        }

        $items .= '<span>'. get_the_title() .'</span>';
    }
    elseif( is_post_type_archive('calendario') ){
        $items .= '<span>Calendario</span>';
    }
    elseif( is_tax( 'sede') ){
        $sede = get_queried_object();

        $items .= '<a href="/sedes/" title="Ir a Sedes" rel="section">Sedes</a>';
        $items .= '<span>'. $sede->name .'</span>';
    }
    elseif( get_query_var('archivo') === 'sedes' ){
        $items .= '<span>Sedes</span>';
    }


    $out = '<section class="breadcrumbs" >';
    $out .= '<div class="container">';
    $out .= $items;
    $out .= '</div>';
    $out .= '</section>';
    return $out;
}

/**
 * Genera la lista HTML correspondiente a la jornadas y sedes
 * @param  [array] $list    - Array de sedes/jornadas
 * @return [string]         - HTML de la lista
 */
function generate_sedes_list( $list ){
    if( empty($list) || !is_array($list) ){ return false; }

    usort( $list, 'order_by_posicion' );

    $out = '<ul class="regular-list" >';

    foreach( $list as $sede ){
        $types = '';
        $address = '';
        $address_2 = '';

        if( is_array($sede) ) {
            $term = get_term_by('id', $sede['sede'], 'sede');
            $types = strtolower( implode(' ', $sede['tipo_jornada']) );
        }
        else {
            $term = get_term_by('id', $sede, 'sede');
            $dire = get_field('direccion_exacta', 'sede_'. $sede);
            $dire_2 = get_field('direccion_exacta_2', 'sede_'. $sede);

            $address = !empty($dire) ? '<p class="tiny-text text-gris" >'. $dire .'</p>' : '';
            $address_2 = !empty($dire_2) ? '<p class="tiny-text text-gris" >'. $dire_2 .'</p>' : '';
        }

        $out .= '<li>';
        $out .= '<a class="sede-link '. $types .'" href="'. get_term_link($term) .'" title="Ver sede '. $term->name .'" >'. $term->name .'</a>';
        $out .= $address;
        $out .= $address_2;
        $out .= '</li>';
    }

    $out .= '<ul>';

    return $out;
}

/**
 * Genera la caja de acciones dentro de un single de un post
 * compartir, shortlink, enviar por email e imprimir
 * Todas las acciones se hacen a traves del $post
 * @param  object $p - $post_object
 * @param  string $custom_message - Mensaje personalizado para forzar al compartir
 * @return string - HTML de la caja
 */
function generate_actions_box( $p, $custom_message = false, $target = false, $content_field = false){
    $share_links = generate_share_urls( $p, $custom_message, $target, $content_field );

    $out = '<div class="actions-holder">';

    $out .= '<a class="content-share-link facebook" href="'. $share_links['facebook'] .'" title="Compartir en facebook" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-fb" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-facebook" ></a>';

    $out .= '<a class="content-share-link twitter" href="'. $share_links['twitter'] .'" title="Compartir en twitter" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-tw" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-twitter" ></a>';

    $out .= '<a class="content-share-link google" href="'. $share_links['google'] .'" title="Compartir en google" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-googleplus" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-googleplus" ></a>';

    $out .= '<a class="content-share-link linkedin" href="'. $share_links['linkedin'] .'" title="Compartir en LinkedIn" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-lkdn" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-linkedin" ></a>';

    $out .= '<a class="content-share-link shortlink" href="#" title="Obtener enlace corto" rel="nofollow" data-link="'. $share_links['shortlink'] .'" data-func="showShortUrl" data-gtm-event="enlace-corto" data-gtm-eventcategory="obtener-enlace" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-enlace-corto" ></a>';

    $out .= '<a class="content-share-link email" href="mailto:?subject=Revisa este programa" title="Compartir por email" rel="nofollow" data-track data-gtm-event="share" data-gtm-eventcategory="compartir-email" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-compartir-email" ></a>';

    // $out .= '<a class="content-share-link print has-label hide-on-device" href="" data-func="printPage" title="Imprimir" rel="external nofollow" target="_blank">Imprimir</a>';

    $out .= '</div>';

    return $out;
}

function generate_actions_box_holder( $p, $custom_message = false, $target = false, $content_field = false){
    $share_links = generate_share_urls( $p, $custom_message, $target, $content_field );

    $out = '<div class="actions-holder actions-holder--content">';

    $out .= '<span class="content-share-link__title">Compartir</span>';

    $out .= '<a class="content-share-link facebook" href="'. $share_links['facebook'] .'" title="Compartir en facebook" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-fb" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-facebook" ></a>';

    $out .= '<a class="content-share-link twitter" href="'. $share_links['twitter'] .'" title="Compartir en twitter" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-tw" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-twitter" ></a>';

    $out .= '<a class="content-share-link google" href="'. $share_links['google'] .'" title="Compartir en google" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-googleplus" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-googleplus" ></a>';

    $out .= '<a class="content-share-link linkedin" href="'. $share_links['linkedin'] .'" title="Compartir en LinkedIn" rel="external nofollow" target="_blank"data-track data-gtm-event="share" data-gtm-eventcategory="compartir-lkdn" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-share-linkedin" ></a>';

    $out .= '<a class="content-share-link shortlink" href="#" title="Obtener enlace corto" rel="nofollow" data-link="'. $share_links['shortlink'] .'" data-func="showShortUrl" data-gtm-event="enlace-corto" data-gtm-eventcategory="obtener-enlace" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-enlace-corto" ></a>';

    $out .= '<a class="content-share-link email" href="mailto:?subject=Revisa este programa" title="Compartir por email" rel="nofollow" data-track data-gtm-event="share" data-gtm-eventcategory="compartir-email" data-gtm-eventaction="clic" data-gtm-eventlabel="btn-compartir-email" ></a>';

    // $out .= '<a class="content-share-link print has-label hide-on-device" href="" data-func="printPage" title="Imprimir" rel="external nofollow" target="_blank">Imprimir</a>';

    $out .= '</div>';

    return $out;
}

/**
 * Genera el HTML correspondiente a los tabs de las paginas interiores genericas
 * @param  [array] $tab        - Array de informacion del tab
 * @param  [bool] $is_active   - Si el tab esta activo o no
 * @return [string]            - HTML del tab
 */
function generate_tab_content( $tab, $is_active ){
    $active_class = $is_active ? 'active' : '';

    $module = '<div class="tab-item '. $active_class .'" data-tab-name="'. sanitize_title($tab['titulo']) .'" >';


    $tab_content = $tab['cuerpo'][0];
    if( $tab_content['acf_fc_layout'] === 'contenido_expandible' ){
        $module .= '<div class="faq-holder">';
        $module .= generate_expandables( $tab_content['items'] );
        $module .= '</div>';
    }
    else {
        $module .= '<div class="page-content">';
        $module .= apply_filters('the_content', $tab_content['contenido']);
        $module .= '</div>';
    }


    $module .= '</div>';

    return $module;
}

/**
 * genera el modulo regualr de contenido expandible, se usa en multiples instancias
 * @param  array $items
 * @return string
 */
function generate_expandables( $items ){
    if( !is_array($items) || empty($items) ){
        return false;
    }

    $modules = '';

    foreach( $items as $item ){
        $modules .= '<article class="faq">';
        $modules .= '<h2 class="faq-title" data-func="deployParent" data-parent=".faq" >'. $item['titulo'] .'</h2>';
        $modules .= '<div class="faq-body">';
        $modules .= '<div class="page-content">';
        $modules .= apply_filters('the_content', $item['contenido']);
        $modules .= '</div>';
        $modules .= '</div>';
        $modules .= '</article>';
    }

    return $modules;
}

/**
 * Genera el modulo de un evento de calendario
 * @param  mixed $event_or_id - ID o $post_object del evento en cuestion
 * @return string - HTML del modulo
 */
function generate_calendar_module( $event_or_id, $options = array(), $section = null ){
    $settings = shortcode_atts(array(
        'classes' => '',
    ), $options);

    $p = null;
    if( is_numeric( $event_or_id ) ){ $p = get_post( $event_or_id ); }
    elseif( is_object( $event_or_id ) ){ $p = $event_or_id; }
    else { return false; }

    $enLinea = false;
    if( get_current_blog_id() === 2 ){
        $enLinea = true;
    }

    $inicio = get_field('fecha_inicio', $p->ID);
    $fin    = get_field('fecha_termino', $p->ID);

    // sacamos el timestamp de la fecha de inicio, siempre presente
    $inicio_stamp = strtotime( get_field('fecha_inicio', $p->ID) );
    $fin_stamp = 0;

    $module = '<article class="event-content '. $settings['classes'] .'" data-start="'.$inicio.'" data-end="'.$fin.'">';
    $module .= '<div class="event-date-box">';
    $module .= '<div class="event-date-tag">';
    $module .= '<span>'. date_i18n('d', $inicio_stamp) .'</span>';
    $module .= '<span>'. date_i18n('M', $inicio_stamp) .'</span>';
    $module .= '</div>';
    $module .= '</div>';
    $module .= '<div class="event-info">';

    $module .= '<h3 class="event-title">';

    if( $enLinea ){
        $module .= '<a class="external" href="'. get_permalink( $p->ID ) .'" title="Ver evento">'. get_the_title( $p->ID ) .'</a>';
    }
    else {
        $module .= get_the_title( $p->ID );
    }

    $module .= '</h3>';

    // se arma el string del dia o periodo
    $date_string = '';

    if( $fin ){
        $fin_stamp = strtotime( $fin );
        $date_string = 'Del '. date_i18n('d/m/Y', $inicio_stamp) .' al '. date_i18n('d/m/Y', $fin_stamp);
    }
    else {
        $date_string = date_i18n('d/m/Y', $inicio_stamp);
    }

    $module .= '<p class="event-date">'. $date_string .'</p>';

    if( $horario = get_field('horario', $p->ID) ){
        $module .= '<p class="event-place">'. $horario .'</p>';
    }

    if( $direccion = get_field('direccion', $p->ID) ){
        $module .= '<p class="event-place">'. $direccion .'</p>';
    }

    $sede = wp_get_post_terms( $p->ID, 'sede' );
    if( !empty($sede) ){
        $module .= '<p class="event-place">'. $sede[0]->name .'</p>';
    }

    if( $section === 'tomasino-por-un-dia' ) {
        $id_evento_crm      = get_field('id_evento_crm', $p->ID);
        $id_tipo_evento_crm = get_field('id_tipo_evento', $p->ID);

        $module .= '<button class="button-calendar" data-func="setInscriptionForm" data-id-event="'.$id_evento_crm.'" data-id_type_event="'.$id_tipo_evento_crm.'" >Inscribirme</button>';
    }

    if( $info = get_field('mas_info', $p->ID) ){
        $module .= '<div class="event-place" ><a class="external" href="'. ensure_url($info) .'" title="Ver enlace" rel="external nofollow" target="_blank" >Más información</a></div>';
    }

    $module .= '</div>';
    $module .= '</article>';

    return $module;
}

/**
 * Genera el calendario de eventos
 * debe mostrar los dias en donde hay algo pasando
 * @return string
 */
function generate_events_calendar(){
    global $wpdb;

    $available_dates = array();

    // consulta directa es menos cara
    $eventos = $wpdb->get_results("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_status = 'publish'
        AND post_type = 'calendario'
    ");

    if( !empty($eventos) ){
        foreach( $eventos as $evento ){
            $available_dates[] = get_field('fecha_inicio', $evento->ID);
        }
    }

    needs_script('jquery-ui-datepicker');
    wp_localize_script( 'mainScript', 'calendar_dates', $available_dates );
    $cal = '<div class="calendar-box" data-role="datepicker-calendar"></div>';

    return $cal;
}

/**
 * Genera el modulo de un testimonio
 * @param  mixed $post_or_id - ID o $post del testimonio
 * @param  array $options - Opciones del modulo
 * @return string
 */
function generate_testimonial_module( $post_or_id, $options = array() ){
    $settings = shortcode_atts(array(
        'classes' => 'masonry-item',
    ), $options);

    if( is_object($post_or_id) ){
        $testi = $post_or_id;
    }
    elseif( is_numeric($post_or_id) ){
        $testi = get_post( $post_or_id );
    }


    $module = '<article id="'. $testi->post_name .'" class="'. $settings['classes'] .' simple-access experiencia">';
    $module .= '<div class="thumbnail">';

    if( $video = get_field('video', $testi->ID) ) {
        $module .= apply_filters('the_content', $video);
    }
    else {
        $module .= get_the_post_thumbnail($testi->ID, 'regular-small');
    }

    $module .= '</div>';
    $module .= '<div class="quote">';
    $module .= get_field('cita', $testi->ID);
    $module .= '</div>';

    $author = get_field('info_autor', $testi->ID)[0];

    $module .= '<div class="author">';
    $module .= '<p class="name" >'. $author['nombre'] .'</p>';
    $module .= '<p class="desc" >'. $author['descripcion'] .'</p>';
    $module .= '<p class="place" >'. $author['institucion'] .'</p>';
    $module .= '</div>';
    $module .= '</article>';

    return $module;
}

/**
 * Genera la tabla de porcentajes en becas y creditos
 * @return string
 */
function generate_porcentajes_table(){
    needs_script('dataTables');

     $cached_data = wp_cache_get( 'tabla_porcentajes', 'santo_tomas' );
     if( $cached_data ){
         return $cached_data;
     }

    // cambiado por un wp_option
    // $tabla = get_field('tabla');

    // cambiado hacia un option para evitar error en la administracion
    $tabla = get_option('tabla_porcentajes');

    // update_option('tabla_porcentajes', $tabla);


    $table_rows = '';
    $institucion_options = array();
    $sedes_options = array();
    $carreras_options = array();
    $jornadas_options = array();

    if( !empty($tabla) ){
        foreach( $tabla as $row ){
            $institucion_options[] = '<option value="'. $row['institucion'] .'" >'. $row['institucion'] .'</option>';
            $sedes_options[] = '<option value="'. $row['sede'] .'" >'. $row['sede'] .'</option>';
            $carreras_options[] = '<option value="'. $row['carrera'] .'">'. $row['carrera'] .'</option>';
            $jornadas_options[] = '<option value="'. $row['jornada'] .'" >'. $row['jornada'] .'</option>';


            $table_rows .= '<tr class="visible" >';
            $table_rows .= '<td data-col-label="Institución" data-col="institucion" data-value="'. $row['institucion'] .'">'. $row['institucion'] .'</td>';
            $table_rows .= '<td data-col-label="Sede" data-col="sede" data-value="'. $row['sede'] .'">'. $row['sede'] .'</td>';
            $table_rows .= '<td data-col-label="Carrera" data-col="carrera" data-value="'. $row['carrera'] .'">'. $row['carrera'] .'</td>';
            $table_rows .= '<td data-col-label="Jornada" class="data-jornada" data-col="jornada" data-value="'. $row['jornada'] .'">'. $row['jornada'] .'</td>';
            $table_rows .= '<td data-col-label="Puntaje" class="puntaje">
                                <table>';

                                if( $row['percent_15'] && $row['percent_15'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_15'] .'</td></tr>';
                                if( $row['percent_20'] && $row['percent_20'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_20'] .'</td></tr>';
                                if( $row['percent_25'] && $row['percent_25'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_25'] .'</td></tr>';
                                if( $row['percent_30'] && $row['percent_30'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_30'] .'</td></tr>';
                                if( $row['percent_35'] && $row['percent_35'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_35'] .'</td></tr>';
                                if( $row['percent_45'] && $row['percent_45'] !== '-')
                                    $table_rows .= '<tr><td>'. $row['percent_45'] .'</td></tr>';
                                if( $row['percent_50'] && $row['percent_50'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_50'] .'</td></tr>';
                                if( $row['percent_60'] && $row['percent_60'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_60'] .'</td></tr>';
                                if( $row['percent_75'] && $row['percent_75'] !== '-')
                                    $table_rows .= '<tr><td>'. $row['percent_75'] .'</td></tr>';
                                if( $row['percent_80'] && $row['percent_80'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_80'] .'</td></tr>';
                                if( $row['percent_100'] && $row['percent_100'] !== '-' )
                                    $table_rows .= '<tr><td>'. $row['percent_100'] .'</td></tr>';

            $table_rows .=     '</table>
                            </td>';

            $table_rows .= '<td data-col-label="Porcentaje" class="porcentaje">
                                <table>';

                                if( $row['percent_15'] && $row['percent_15'] !== '-' )
                                    $table_rows .= '<tr><td>15%</td></tr>';
                                if( $row['percent_20'] && $row['percent_20'] !== '-' )
                                    $table_rows .= '<tr><td>20%</td></tr>';
                                if( $row['percent_25'] && $row['percent_25'] !== '-' )
                                    $table_rows .= '<tr><td>25%</td></tr>';
                                if( $row['percent_30'] && $row['percent_30'] !== '-' )
                                    $table_rows .= '<tr><td>30%</td></tr>';
                                if( $row['percent_35'] && $row['percent_35'] !== '-' )
                                    $table_rows .= '<tr><td>35%</td></tr>';
                                if( $row['percent_45'] && $row['percent_45'] !== '-' )
                                    $table_rows .= '<tr><td>45%</td></tr>';
                                if( $row['percent_50'] && $row['percent_50'] !== '-' )
                                    $table_rows .= '<tr><td>50%</td></tr>';
                                if( $row['percent_60'] && $row['percent_60'] !== '-' )
                                    $table_rows .= '<tr><td>60%</td></tr>';
                                if( $row['percent_75'] && $row['percent_75'] !== '-' )
                                    $table_rows .= '<tr><td>75%</td></tr>';
                                if( $row['percent_80'] && $row['percent_80'] !== '-' )
                                    $table_rows .= '<tr><td>80%</td></tr>';
                                if( $row['percent_100'] && $row['percent_100'] !== '-' )
                                    $table_rows .= '<tr><td>100%</td></tr>';

            $table_rows .=  '   </table>
                            </td>';

            $table_rows .= '</tr>';
        }
    }

    //se eliminan los vlaores duplicados y se ordenan alfabeticamente
    $institucion_options = array_unique( $institucion_options );
    $sedes_options = array_unique( $sedes_options );
    $carreras_options = array_unique( $carreras_options );
    $jornadas_options = array_unique( $jornadas_options );
    asort( $institucion_options );
    asort( $sedes_options );
    asort( $carreras_options );
    asort( $jornadas_options );

    $cached_data = array(
        'institucion_options' => $institucion_options,
        'sedes_options' => $sedes_options,
        'carreras_options' => $carreras_options,
        'jornadas_options' => $jornadas_options,
        'table_rows' => $table_rows
    );

    // wp_cache_set( 'tabla_porcentajes', $cached_data, 'santo_tomas', 60*60*24 );

    return $cached_data;
}

/**
 * Genera los optionas para los filtros de busqueda de las sedes
 * ordenadas segun su posicion
 * @param  [arrau] $terms - array de terms
 * @return string
 */
function generate_ordering_option_sedes( $terms ){
    if( empty($terms) ){ return false; }

    usort( $terms, 'order_by_posicion' );

    $options = '';
    foreach( $terms as $t ){
        $options .= '<option value="'. $t->term_id .'" >'. $t->name .'</option>';
    }

    return $options;
}

/**
 * Genera el modulo de la galeria de imagenes
 * @param  array $imagenes - informacion directa del campo ACF, DEBE tener este formato basico:
 *                         array(
 *                             array(
 *                                 'imagen' => (int)$attachment_id,
 *                             )
 *                         )
 * @return string - HTML de la galeria
 */
function generate_regular_gallery_slider( $imagenes ){
    if( empty($imagenes) ){ return false; }

    $items = '';
    $thumbnails = '';

    $count = 0;

    foreach( $imagenes as $img ){
        if( !$img['imagen'] ){ continue; }
        $active = $count === 0 ? 'active' : '';

        $items .= '<figure class="single-slider-item '. $active .'" data-slide="'. $count .'" data-role="single-slider-item" data-attid="'. $img['imagen'] .'">';
        $items .= wp_get_attachment_image( $img['imagen'], 'regular-bigger', false, array( 'class' => 'single-slider-image' ));

        $items .= '</figure>';

        $thumbnails .= '<button class="single-slider-thumbnail '. $active .'" title="Ver imagen" data-target="'. $count .'" data-role="single-slider-thumbnail">';
        $thumbnails .= wp_get_attachment_image( $img['imagen'], 'regular-tiny');
        $thumbnails .= '</button>';

        $count++;
    }

    $out = '<div class="single-slider-module" data-role="single-slider-module">';
    $out .= '<div class="single-slider-body">';
    $out .= '<div class="single-slider-main" data-role="slider">';
    $out .= '<div class="single-slider-holder">';
    $out .= $items;
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<div class="single-slider-arrows-box">';
    $out .= '<button class="single-slider-arrow prev" title="Ver imagen anterior" data-role="single-slider-arrow" data-direction="prev"></button>';
    $out .= '<button class="single-slider-arrow next" title="Ver imagen siguiente" data-role="single-slider-arrow" data-direction="next"></button>';
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<div class="single-slider-thumbnails-holder">';
    $out .= '<button class="single-slider-thumbnail-arrow prev" title="Anterior" data-role="single-slider-thumbnail-arrow" data-direction="prev"></button>';
    $out .= '<div class="single-slider-thumbnails">';
    $out .= '<div class="single-slider-thumbnails-list" data-role="thumbnails-holder">';
    $out .= $thumbnails;
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<button class="single-slider-thumbnail-arrow next" title="Siguiente" data-role="single-slider-thumbnail-arrow" data-direction="next"></button>';
    $out .= '</div>';
    $out .= '</div>';

    return $out;
}

/**
 * Genera el modulo de carrera en los archivos de carreras
 * @param  mixed $post_or_id - ID o $post de la carrera
 * @return string
 */
function generate_career_module( $post_or_id ){
    $p = null;
    if( is_numeric( $post_or_id ) ){ $p = get_post( $post_or_id ); }
    elseif( is_object( $post_or_id ) ){ $p = $post_or_id; }
    else { return false; }

    $html = '<article class="career-module">';
    $html .= '<a class="career-title" href="'. get_permalink( $p->ID ) .'" title="Ver carrera" >';
    $html .= get_the_post_thumbnail($p->ID, 'regular-small', ['class' => 'elastic-img cover']);
    $html .= get_the_title( $p->ID );
    $html .= '</a>';
    $html .= '</article>';

    return $html;
}

function generate_careers_search_list( $options = [] ){
    $settings = shortcode_atts([
        'show_icons' => true,
        'tax_search' => false,
        'taxonomy' => '',
        'term_id' => '',
        'meta_query' => null
    ], $options);


    $tax_query = null;
    $taxonomy = '';
    $term_id = 0;

    if( $settings['tax_search'] ){
        $tax_query = [[
            'taxonomy' => $settings['taxonomy'],
            'field' => 'term_id',
            'terms' => (int)$settings['term_id']
        ]];

        $taxonomy = $settings['taxonomy'];
        $term_id = $settings['term_id'];
    }


    $query_args = array(
        'post_type' => 'carrera',
        'posts_per_page' => -1,
        'posts_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => $tax_query,
        'meta_query' => $settings['meta_query']
    );

    $search = new WP_Query($query_args);

    // un bucket para cada institucion
    // se deben separar porque en lso resultados se muestran de manera separada

    $results_u = array();
    $results_ip = array();
    $results_cft = array();
    $all_results = array();

    if( $search->have_posts() ){
        while( $search->have_posts() ){
            $search->the_post();

            $institucion = wp_get_post_terms( $search->post->ID, 'institucion', array("fields" => "slugs"));

            if( empty($institucion) || is_wp_error($institucion) ){
                // si no tiene asignada institucion o da error
                continue;
            }

            $institucion = $institucion[0];
            $permalink = get_permalink();
            $jornada = '';

            if( $settings['show_icons'] ){
                if( $taxonomy === 'sede' ){
                    $sedes_asociadas = get_field('sedes_jornadas', $post_id);
                    foreach( $sedes_asociadas as $row ){
                        if( $row['sede'] == $term_id ){
                            $jornadas = $row['tipo_jornada'];
                            break;
                        }
                    }
                }
                else {
                    $jornadas = get_field('jornada');
                }

                $jornada = strtolower(implode(' ', $jornadas));
            }


            $parsed_title = cleanString($search->post->post_title);
            $parsed_title = str_replace(' ', '-', $parsed_title);
            $parsed_title = preg_replace('/[^A-Za-z0-9\-]/', '', $parsed_title);
            $parsed_title = str_replace('-', ' ', $parsed_title);

            $nueva = '';
            if( get_field('carrera_nueva') ){
                $nueva = '<span>¡Carrera nueva!</span>';
            }

            $link = '<li data-value="'. strtolower($parsed_title) .'" ><a href="'. get_permalink() .'" class="sede-link '. $jornada .'" title="Ver carrera">'. get_the_title() .' '. $nueva  .'</a></li>';

            // el unico tipo de busqueda que no separa por institucion
            // es la busqueda por universidad, se hace la diferencia
            if( $taxonomy === 'institucion' ){
                $all_results[] = $link;
            }
            else {
                if( $institucion === 'universidad-santo-tomas' ){
                    $results_u[] = $link;
                }
                elseif( $institucion === 'instituto-profesional' ){
                    $results_ip[] = $link;
                }
                elseif( $institucion === 'centro-de-formacion-tecnica' ){
                    $results_cft[] = $link;
                }
            }
        }


        // el unico tipo de busqueda que no separa por institucion
        // es la busqueda por universidad, se hace la diferencia
        if( $taxonomy === 'institucion' ){
            $tercio = ceil( count($all_results) / 3 );
            // como esta no separ, la separacion por columnas es matematica
            $first_col = array_slice($all_results, 0, $tercio);
            $second_col = array_slice($all_results, $tercio, $tercio);
            $third_col = array_slice($all_results, $tercio * 2, $tercio);
        }
        else {
            $first_col = $results_u;
            $second_col = $results_ip;
            $third_col = $results_cft;
        }

        // se generan los titulos de las columnas
        $general_title = '';
        $col_1_title = '';
        $col_2_title = '';
        $col_3_title = '';

        if( $taxonomy === 'institucion' ){
            $req_inst = get_term_by('id', (int)$term_id, 'institucion');
            if( $req_inst->slug === 'universidad-santo-tomas' ){
                $general_title = '<h4 class="special-info-subtitle">Carreras Universitarias</h4>';
            }
            elseif( $req_inst->slug === 'instituto-profesional' ){
                $general_title = '<h4 class="special-info-subtitle">Carreras de Instituto Profesional</h4>';
            }
            elseif( $req_inst->slug === 'centro-de-formacion-tecnica' ){
                $general_title = '<h4 class="special-info-subtitle">Carreras Centro de Formación Técnica</h4>';
            }
        }
        else {
            $col_1_title = '<h4 class="special-info-subtitle">Carreras Universitarias</h4>';
            $col_2_title = '<h4 class="special-info-subtitle">Carreras de Instituto Profesional</h4>';
            $col_3_title = '<h4 class="special-info-subtitle">Carreras Centro de Formación Técnica</h4>';
        }


        $html = $general_title;
        $html .= '<div class="special-info-body bordered-columns">';

        if( !empty(  $first_col ) ) {
            $html .= '<div class="grid-4 grid-smalltablet-12">';
            $html .= $col_1_title;
            $html .= '<ul class="regular-list" >';
            $html .= implode('', $first_col);
            $html .= '</ul>';
            $html .= '</div>';
        }

        if( !empty($second_col) ){
            $html .= '<div class="grid-4 grid-smalltablet-12">';
            $html .= $col_2_title;
            $html .= '<ul class="regular-list" >';
            $html .= implode('', $second_col);
            $html .= '</ul>';
            $html .= '</div>';
        }

        if( !empty( $third_col ) ){
            $html .= '<div class="grid-4 grid-smalltablet-12">';
            $html .= $col_3_title;
            $html .= '<ul class="regular-list" >';
            $html .= implode('', $third_col);
            $html .= '</ul>';
            $html .= '</div>';
        }

        $html .= '</div>';
    }

    // si no hay resultatos
    else {
        $html = '<div class="special-info-body bordered-columns">';
        $html .= '<h4 class="special-info-subtitle">Lo sentimos</h4>';
        $html .= '<p class="text-gris">No se encontraron carreras</p>';
        $html .= '</div>';
    }

    return $html;
}


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Shortcodes
////////////////////////////////////////////////////////////////////////////////
add_shortcode( 'mapadelsitio', 'generate_sitemap' );
function generate_sitemap( $atts ){
    return wp_nav_menu(array(
        'theme_location' => 'mapasitio',
        'echo' => false
    ));
}

add_shortcode('boton', 'generate_button');
function generate_button( $atts, $content ){
    $settings = shortcode_atts(array(
        'alineacion' => 'izquierda'
    ), $atts);

    if( !$content ){ return false; }

    $align = '';

    // primero sacamos la alineacion real
    switch ($settings['alineacion']) {
        case 'izquierda':
            $align = 'lefted-text';
            break;
        case 'centro':
            $align = 'centered-text';
            break;
        case 'derecha':
            $align = 'righted-text';
            break;

        default:
            $align = 'lefted-text';
            break;
    }


    $html = '<div class="island '. $align .'">';
    $html .= preg_replace('/\s(href=[\'|"][^\'"]+[\'|"])/', ' $1 class="button secundario small wide full-vertical-tablet-down"', $content);
    $html .= '</div>';

    return $html;
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Envios de Formularios
////////////////////////////////////////////////////////////////////////////////

add_action('contacto_response', 'respuesta_contacto');
function respuesta_contacto( $datos ){
    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //
    $cuerpo = '<p>Hemos recibido su mensaje de contacto, nos pondremos en contacto a la brevedad.</p>';
    $cuerpo .= '<p>Los datos enviados son:</p>';

    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Datos personales</p>';
    $cuerpo .= '<p>';
    $cuerpo .= 'RUT: '. $datos['rut'] . '<br>';
    $cuerpo .= 'Mail: '. $datos['mail'] . '<br>';
    $cuerpo .= 'Celular: '. $datos['celular'] . '<br>';
    $cuerpo .= 'Mensaje:</p>';

    $cuerpo .= apply_filters('the_content', $datos['mensaje']);

    send_custom_email(array(
        'to' => $datos['nombre'] . '<'. $datos['mail'] .'>',
        'subject' => 'Hemos recibido su mensaje',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['contacto'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['contacto'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su mensaje',
            'intro' => 'Estimado/a <strong>'. $datos['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        ),
        'email_origen' => array(
            'origen' => 'formulario_contacto'
        )
    ));

    //
    //
    //

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido un mensaje de contacto.</p>';
    $cuerpo .= '<p>Los datos enviados son:</p>';

    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Datos personales</p>';
    $cuerpo .= '<p>';
    $cuerpo .= 'Nombre: '. $datos['nombre'] . '<br>';
    $cuerpo .= 'RUT: '. $datos['rut'] . '<br>';
    $cuerpo .= 'Mail: '. $datos['mail'] . '<br>';
    $cuerpo .= 'Celular: '. $datos['celular'] . '<br>';
    $cuerpo .= 'Menjase:</p>';

    $cuerpo .= apply_filters('the_content', $datos['mensaje']);

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['contacto'] .'>',
        'subject' => 'Hemos recibido un mensaje de contacto',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['contacto'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $datos['nombre'] . ' <'. $datos['mail'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido un mensaje de contacto',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));
}


add_action('clicktocall_response', 'respuesta_clicktocall');
function respuesta_clicktocall( $datos ){
    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //
    $cuerpo = '<p>Hemos recibido su solicitud.</p>';
    $cuerpo .= '<p>Los datos enviados son:</p>';

    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Datos personales</p>';
    $cuerpo .= '<p>';
    $cuerpo .= 'RUT: '. $datos['rut'] . '<br>';
    $cuerpo .= 'Mail: '. $datos['mail'] . '<br>';
    $cuerpo .= 'Celular: '. $datos['celular'] . '<br>';
    $cuerpo .= 'Teléfono: '. $datos['telefono'] . '</p>';

    send_custom_email(array(
        'to' => $datos['nombre'] . '<'. $datos['mail'] .'>',
        'subject' => 'Hemos recibido su solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['te_llamamos'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['te_llamamos'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su solicitud',
            'intro' => 'Estimado/a <strong>'. $datos['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));

    //
    //
    //

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una solicitud de llamada.</p>';
    $cuerpo .= '<p>Los datos enviados son:</p>';

    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Datos personales</p>';
    $cuerpo .= '<p>';
    $cuerpo .= 'Nombre: '. $datos['nombre'] . '<br>';
    $cuerpo .= 'RUT: '. $datos['rut'] . '<br>';
    $cuerpo .= 'Mail: '. $datos['mail'] . '<br>';
    $cuerpo .= 'Celular: '. $datos['celular'] . '<br>';
    $cuerpo .= 'Teléfono: '. $datos['telefono'] . '</p>';


    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['te_llamamos'] .'>',
        'subject' => 'Hemos recibido una solicitud de llamada',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['te_llamamos'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $datos['nombre'] . ' <'. $datos['mail'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud de llamada',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));
}


add_action('postulacion_response', 'respuesta_postulacion');
function respuesta_postulacion( $datos ){
    $emails = get_emails();

    $cuerpo_datos = '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Datos personales</p>';
    $cuerpo_datos .= '<p>';
    $cuerpo_datos .= 'RUT: '. $datos['rut'] . '<br>';
    $cuerpo_datos .= 'Mail: '. $datos['mail'] . '<br>';
    $cuerpo_datos .= 'Celular: '. $datos['celular'] . '<br>';
    $cuerpo_datos .= 'Teléfono: '. $datos['telefono'] . '</p>';

    $cuerpo_datos .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Educación</p>';
    $cuerpo_datos .= '<p>';
    $cuerpo_datos .= 'Colegio: '. $datos['colegio'] . '<br>';
    $cuerpo_datos .= $datos['comuna'] . ', '. $datos['region'] .'<br>';
    $cuerpo_datos .= 'Curso: '. $datos['curso'] . '<br>';
    $cuerpo_datos .= 'Año de egreso: '. $datos['egreso'] . '</p>';


    $cuerpo_tablas = '';
    $i = 1;
    foreach( $datos['carreras'] as $carrera ){
        $cuerpo_tablas .= '<h3>Carrera '. $i .':</h3>';
        $cuerpo_tablas .= '<p><strong>'. $carrera->name .'</strong></p>';

        $cuerpo_tablas .= '<table style="margin-bottom: 30px; width:100%; background: #ffffff; border-top:1px dotted #9C9C9C; color: #9c9c9c;">';

        $cuerpo_tablas .= '<tr>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Institución</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Sede</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Jornada</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Matrícula</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Arancel anual</th>';
        $cuerpo_tablas .= '</tr>';

        $cuerpo_tablas .= '<tr>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $carrera->institucion .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $carrera->sede .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $carrera->jornada .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($carrera->matricula, 0, ',', '.') .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($carrera->arancel, 0, ',', '.') .'</td>';
        $cuerpo_tablas .= '</tr>';

        $cuerpo_tablas .= '</table>';

        $i++;
    }


    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //

    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;
    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Carreras de tu interés</p>';
    $cuerpo .= $cuerpo_tablas;

    $cuerpo .= '<div style="margin: 2em 0; font-size: 11px; color: #999999;">';
    $cuerpo .= apply_filters('the_content', get_field('texto_legal', 'options'));
    $cuerpo .= '</div>';


    send_custom_email(array(
        'to' => $datos['nombre'] . '<'. $datos['mail'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $datos['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));

    //
    //
    //

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una nueva postulación.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;
    $cuerpo .= '<p style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #006A56" >Carreras seleccionadas</p>';
    $cuerpo .= $cuerpo_tablas;


    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una postulación',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $datos['nombre'] . ' <'. $datos['mail'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una postulación',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));
}
function eventos($tax){
    $query_args = array(
        'post_type' => 'calendario',
        'posts_per_page' => -1,
        'meta_key' => 'fecha_inicio',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'tax_query' => array(array(
            'taxonomy' => 'tipos_calendarios',
            'field' => 'slug',
            'terms' => $tax
        ))
    );

    $q = new WP_Query($query_args);
    $out = '';
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            $out .= generate_calendar_module($q->post, null, $tax);
        }
    } else {
        $out = alerta(array(
            'titulo' => 'Lo sentimos',
            'mensaje' => 'No se encontraron eventos en esta fecha.'
        ));
    }

    wp_reset_query();
    return $out;
}

/**
 * Se encarga de enviar los formularios CRM simples, estos son:
 * Contacto y te llamamos
 * @return bool
 */
function send_crm_form(){
    global $idaCRM;

    // se envia el contacto
    if( $_POST['ws-form-name'] === 'contacto' ){
        // se agrega el codigo de conversion al head
        // custom action
        add_action('print_conversion_code', function(){
            get_template_part('partials/conversions/codigo', 'contacto');
        });

        return $idaCRM->push_contacto();
    }
    // se envia el te llamamos
    elseif( $_POST['ws-form-name'] === 'tellamamos' ){
        // se agrega el codigo de conversion al head
        // custom action
        add_action('print_conversion_code', function(){
            get_template_part('partials/conversions/codigo', 'tellamamos');
        });

        return $idaCRM->push_clicktocall();
    }
}

/**
 * Recepcion del formulario de ensayo a la PSU
 * en desuso, ensayo ya no está
 * @param  array  $data - $_POST
 * @return bool
 */
function send_ensayo_form( $data ){
    global $wpdb, $idaCRM;

    // if( ! wp_verify_nonce( $_POST['st_nonce'], 'enviar_formulario' ) ){
    //     wp_die('Error al enviar el formulario');
    // }

    $_POST["contactId"] = $idaCRM->check_crear_usuario();
    $idaCRM->tabla = "crm_psu_usuarios";
    $idaCRM->save_usuario_wp();
    $idaCRM->save_psu_ensayo_wp();
    // mapeo los datos
    $resumen = '';
    foreach( $data as $k => $v ){
        // los campos que no aplican

        if(
            $k == '_wp_http_referer' ||
            $k == 'st_nonce' ||
            $k == 'email-conf' ||
            $k == 'combo-carreras'
        ){ continue; }

        elseif( $k == 'contacto-celular-codigo' || $k == 'contacto-celular-numero' ){
            if( $k == 'contacto-celular-numero' ){ continue; }

            $celular = $data['contacto-celular-codigo'] . ' - ' . $data['contacto-celular-numero'];
            $resumen .= '<p><strong>Celular</strong> : '. $celular .'</p>';
        }
        elseif( $k == 'contacto-telefono-codigo' || $k == 'contacto-telefono-numero' ){
            if( $k == 'contacto-telefono-numero' ){ continue; }

            $telefono = $data['contacto-telefono-codigo'] . ' - ' . $data['contacto-telefono-numero'];
            $resumen .= '<p><strong>Teléfono</strong> : '. $telefono .'</p>';
        }
        elseif( $k == 'cotizacion-region' ){
            $resumen .= '<p><strong>Región</strong> : '. get_region_by_id($v) .' </p>';
        }
        elseif( $k == 'cotizacion-sede-ensayo' ){
            $resumen .= '<p><strong>Rendir Ensayo en Sede</strong> : '. get_zonaadmision_by_id($v) .' </p>';
        }
        elseif( $k == 'cotizacion-comuna' ){
            $resumen .= '<p><strong>Comuna</strong> : '. get_comuna_by_id($v) .'</p>';
        }
        elseif( $k == 'cotizacion-colegio' ){
            $resumen .= '<p><strong>Colegio</strong> : '. get_colegio_by_id($v) .'</p>';
        }
        elseif( $k == 'cotizacion-ano-cursado' ){

            $resumen .= '<p><strong>Año Cursado</strong> : '. $v .'</p>';
        }
        elseif( $k == 'cotizacion-ano-egreso' && ($v ==  '' || $v == 0 || $v == null )){
            $resumen .= '<p><strong>Año de egreso</strong> : '.  (date("Y")  + (4 - (int)$data["cotizacion-ano-cursado"])) .'</p>';
        }
        else {
            $k = ucwords( str_replace('contacto', ' ', $k) );
            $k = ucwords( str_replace('cotizacion', ' ', $k) );
            $name = ucwords( str_replace('-', ' ', $k) );
            $resumen .= '<p><strong>'. $name .'</strong> : '. $v .'</p>';
        }
    }

    $cuerpo_tablas = '';
    $i = 1;
    foreach( $data['combo-carreras'] as $carrera ){
        if( empty($carrera['carrera']) ){ continue; }

        $db_carrera = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM santotomas_carreras
            WHERE xrmId = %s;
        ", $carrera['carrera']));
        if( empty($db_carrera) ){ continue; }

        $db_carrera = $db_carrera[0];

        $cuerpo_tablas .= '<h3 class="career-summary-title">Carrera '. $i .': ';
        $cuerpo_tablas .= '<strong>'. $db_carrera->name .'</strong></h3>';

        $cuerpo_tablas .= '<table class="career-summary-table" style="margin-bottom: 30px; width:100%; background: #ffffff; border-top:1px dotted #9C9C9C; color: #9c9c9c;">';

        $cuerpo_tablas .= '<tr>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Institución</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Sede</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Jornada</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Matrícula</th>';
        $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Arancel anual</th>';
        $cuerpo_tablas .= '</tr>';

        $cuerpo_tablas .= '<tr>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->institucion .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->sede .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->jornada .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($db_carrera->matricula, 0, ',', '.') .'</td>';
        $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($db_carrera->arancel, 0, ',', '.') .'</td>';
        $cuerpo_tablas .= '</tr>';

        $cuerpo_tablas .= '</table>';

        $i++;
    }

    $resumen .= '<div class="career-summary special">';
    $resumen .= $cuerpo_tablas;
    $resumen .= '</div>';

    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //

    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $resumen;

    send_custom_email(array(
        'to' => $data['nombre'] . '<'. $data['contacto-email'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $data['contacto-nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una nueva solicitud de inscripción al ensayo PSU.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['contacto-nombre'] . ' <'. $data['contacto-email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));

    return array(
        'status' => 'ok',
        'feedback' => $resumen
    );
}

/**
 * Recepcion del formulario de tomasino por un dia
 * @param  array  $data - $_POST
 * @return bool
 */
function send_tomasino_form( $data ) {
  global $wpdb, $idaCRM;

  if( $data['tipo-inscripcion'] === 'individual' ) {
    if (!$idaCRM->client) {
      $idaCRM->conectarSoap();
    }

    $verificarRut = new stdClass();
    $verificarRut->rut = str_replace(".", "", $_POST["rut"]);
    //en realidad es update o create
    $_POST["contactId"] = $idaCRM->crear_contacto_crm();

    $params->postulacion->contactId =  $_POST["contactId"];
    if (isset($_POST["combo-carreras"][0]["carrera"])) {
      $params->postulacion->ofertaDeAdmisionId_1 = $_POST["combo-carreras"][0]["carrera"];
    }
    if (isset($_POST["combo-carreras"][1]["carrera"]) && $_POST["combo-carreras"][1]["carrera"] != "") {
      $params->postulacion->ofertaDeAdmisionId_2 = $_POST["combo-carreras"][1]["carrera"];
    }
    if (isset($_POST["combo-carreras"][2]["carrera"]) && $_POST["combo-carreras"][2]["carrera"] != "") {
      $params->postulacion->ofertaDeAdmisionId_3 = $_POST["combo-carreras"][2]["carrera"];
    }
    $idaCRM->client->postCreatePostulacion($params);

    if( !empty($data["id_tipo_evento"]) && !empty($data["id_evento_crm"]) ):
      $params = new stdClass();
      $params->contactId = $_POST['contactId'];
      $params->tipoDeEventoId = $data['id_tipo_evento'];
      $params->eventId = $data['id_evento_crm'];
      $idaCRM->client->postCreateTomasinoPorUnDia($params);
    endif;
  }

  $idaCRM->tabla = "crm_tomasino";
  $idaCRM->save_tomasino_wp();


    // if( ! wp_verify_nonce( $_POST['st_nonce'], 'enviar_formulario' ) ){
    //     wp_die('Error al enviar el formulario');
    // }


    // mapeo los datos
    $resumen = '';

    foreach( $data as $k => $v ){
        if($v=="") continue;
        // cambia segun tipo de inscripcion
        if( $tipo_inscripcion === 'colegio' ) {
            // si es colegio
            // se salta los anos de estudio/egreso
            if( $k == 'ano-cursado' || $k == 'ano-egreso' || $k == 'id_evento_crm' || $k == 'id_tipo_evento' ) continue;
        }

        // cambia segun tipo de inscripcion
        else {
            // si es colegio
            // se salta los anos de estudio/egreso
            if( $k == 'colegio-cargo' || $k == 'numero-cuartos' || $k == 'numero-alumnos' || $k == 'id_evento_crm' || $k == 'id_tipo_evento' || $k == 'cotizacion-sede-ensayo') continue;
        }

        // los campos que no aplican
        if(
            $k == '_wp_http_referer' ||
            $k == 'st_nonce' ||
            $k == 'email-conf' ||
            $k == 'id_evento_crm' ||
            $k == 'id_tipo_evento' ||
            $k == 'claveAjax' ||
            $k == 'contactId' ||
            $k == 'combo-carreras'
        ){ continue; }

        elseif( $k == 'celular-codigo' || $k == 'celular-numero' ){
            if( $k == 'celular-numero' ){ continue; }

            $celular = $data['celular-codigo'] . ' - ' . $data['celular-numero'];
            $resumen .= '<p><strong>Celular</strong> : '. $celular .'</p>';
        }
        elseif( $k == 'telefono-codigo' || $k == 'telefono-numero' ){
            if( $k == 'telefono-numero' ){ continue; }

            $telefono = $data['telefono-codigo'] . ' - ' . $data['telefono-numero'];
            $resumen .= '<p><strong>Teléfono</strong> : '. $telefono .'</p>';
        }
        elseif( $k == 'region' ){
            $resumen .= '<p><strong>Región</strong> : '. get_region_by_id($v) .' </p>';
        }
        elseif( $k == 'comuna' ){
            $resumen .= '<p><strong>Comuna</strong> : '. get_comuna_by_id($v) .'</p>';
        }
        elseif( $k == 'colegio' ){
            $resumen .= '<p><strong>Colegio</strong> : '. get_colegio_by_id($v) .'</p>';
        }
        elseif( $k == 'ano-cursado' ){
            $resumen .= '<p><strong>Año Cursado</strong> : '. $v .'</p>';
        }
        elseif( $k == 'ano-egreso' && ($v ==  '' || $v == 0 || $v == null )){
            $resumen .= '<p><strong>Año de egreso</strong> : '.  (date("Y")  + (4 - (int)$data["ano-cursado"])) .'</p>';
        }
        else {
            $name = ucwords( str_replace('-', ' ', $k) );
            $resumen .= '<p><strong>'. $name .'</strong> : '. $v .'</p>';
        }
    }

    // $cuerpo_tablas = '';
    // $i = 1;
    // foreach( $data['combo-carreras'] as $carrera ){
    //     if( empty($carrera['carrera']) ){ continue; }

    //     $db_carrera = $wpdb->get_results($wpdb->prepare("
    //         SELECT * FROM santotomas_carreras
    //         WHERE xrmId = %s;
    //     ", $carrera['carrera']));
    //     if( empty($db_carrera) ){ continue; }

    //     $db_carrera = $db_carrera[0];

    //     $cuerpo_tablas .= '<h3>Carrera '. $i .':';
    //     $cuerpo_tablas .= '<strong>'. $db_carrera->name .'</strong></h3>';

    //     $cuerpo_tablas .= '<table class="career-summary-table" style="margin-bottom: 30px; width:100%; background: #ffffff; border-top:1px dotted #9C9C9C; color: #9c9c9c;">';

    //     $cuerpo_tablas .= '<tr>';
    //     $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Institución</th>';
    //     $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Sede</th>';
    //     $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Jornada</th>';
    //     $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Matrícula</th>';
    //     $cuerpo_tablas .= '<th style="padding: 1em; text-align: left;">Arancel anual</th>';
    //     $cuerpo_tablas .= '</tr>';

    //     $cuerpo_tablas .= '<tr>';
    //     $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->institucion .'</td>';
    //     $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->sede .'</td>';
    //     $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">'. $db_carrera->jornada .'</td>';
    //     $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($db_carrera->matricula, 0, ',', '.') .'</td>';
    //     $cuerpo_tablas .= '<td style="padding: 1em; text-align: left;">$'. number_format($db_carrera->arancel, 0, ',', '.') .'</td>';
    //     $cuerpo_tablas .= '</tr>';

    //     $cuerpo_tablas .= '</table>';

    //     $i++;
    // }

    // $resumen .= '<div class="career-summary special">';
    // $resumen .= $cuerpo_tablas;
    // $resumen .= '</div>';

    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //

    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $resumen;

    send_custom_email(array(
        'to' => $data['nombre'] . '<'. $data['email'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $data['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una nueva solicitud de inscripción al ensayo PSU.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] . ' <'. $data['email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));

    return array(
        'status' => 'ok',
        'feedback' => $resumen
    );
}

/**
 * Recepcion del formulario de talleres vocacionales
 * @param  array  $data - $_POST
 * @return bool
 */
function send_talleres_form( $data ){
    global $idaCRM;
    $idaCRM->tabla = "crm_admision";
    $_POST["formulario"]="talleres";
    $idaCRM->save_crm_wp();

    // if( ! wp_verify_nonce( $_POST['st_nonce'], 'enviar_formulario' ) ){
    //     wp_die('Error al enviar el formulario');
    // }

    // mapeo los datos
    $resumen = '';
    foreach( $data as $k => $v ){
        // los nonces no valen
        if( $k == '_wp_http_referer' || $k == 'st_nonce' || $k == 'email-conf' ){ continue; }

        elseif( $k == 'celular-codigo' || $k == 'celular-numero' ){
            if( $k == 'celular-numero' ){ continue; }

            $celular = $data['celular-codigo'] . ' - ' . $data['celular-numero'];
            $resumen .= '<p><strong>Celular</strong> : '. $celular .'</p>';
        }
        elseif( $k == 'telefono-codigo' || $k == 'telefono-numero' ){
            if( $k == 'telefono-numero' ){ continue; }

            $telefono = $data['telefono-codigo'] . ' - ' . $data['telefono-numero'];
            $resumen .= '<p><strong>Teléfono</strong> : '. $telefono .'</p>';
        }
        elseif( $k == 'region' ){
            $resumen .= '<p><strong>Región</strong> : '. get_region_by_id($v) .' </p>';
        }
        elseif( $k == 'comuna' ){
            $resumen .= '<p><strong>Comuna</strong> : '. get_comuna_by_id($v) .'</p>';
        }
        elseif( $k == 'colegio' ){
            $resumen .= '<p><strong>Colegio</strong> : '. get_colegio_by_id($v) .'</p>';
        }
        else {
            $name = ucwords( str_replace('-', ' ', $k) );
            $resumen .= '<p><strong>'. $name .'</strong> : '. $v .'</p>';
        }
    }

    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //
    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $resumen;

    send_custom_email(array(
        'to' => $data['nombre'] . '<'. $data['email'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $data['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));
    // Envia un mail de feedback al administrador
    //
    //
    $cuerpo = '<p>Hemos recibido una nueva solicitud de talleres vocacionales.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] . ' <'. $data['email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));

    return array(
        'status' => 'ok',
        'feedback' => $resumen
    );
}

/**
 * Recepcion del formulario de orientadores
 * @param  array  $data - $_POST
 * @return bool
 */
function send_orientadores_form( $data ){
    global $idaCRM;
    $idaCRM->tabla = "crm_admision";
    $_POST["formulario"]="orientadores";
    $idaCRM->save_crm_wp();
    // if( ! wp_verify_nonce( $_POST['st_nonce'], 'enviar_formulario' ) ){
    //     wp_die('Error al enviar el formulario');
    // }
    // mapeo los datos
    $resumen = '';
    foreach( $data as $k => $v ){
        // los nonces no valen
        if( $k == '_wp_http_referer' || $k == 'st_nonce' || $k == 'email-conf' ){ continue; }
        elseif( $k == 'celular-codigo' || $k == 'celular-numero' ){
            if( $k == 'celular-numero' ){ continue; }
            $celular = $data['celular-codigo'] . ' - ' . $data['celular-numero'];
            $resumen .= '<p><strong>Celular</strong> : '. $celular .'</p>';
        }
        elseif( $k == 'telefono-codigo' || $k == 'telefono-numero' ){
            if( $k == 'telefono-numero' ){ continue; }
            $telefono = $data['telefono-codigo'] . ' - ' . $data['telefono-numero'];
            $resumen .= '<p><strong>Teléfono</strong> : '. $telefono .'</p>';
        }
        elseif( $k == 'region' ){
            $resumen .= '<p><strong>Región</strong> : '. get_region_by_id($v) .' </p>';
        }
        elseif( $k == 'comuna' ){
            $resumen .= '<p><strong>Comuna</strong> : '. get_comuna_by_id($v) .'</p>';
        }
        elseif( $k == 'colegio' ){
            $resumen .= '<p><strong>Colegio</strong> : '. get_colegio_by_id($v) .'</p>';
        }
        else {
            $name = ucwords( str_replace('-', ' ', $k) );
            $resumen .= '<p><strong>'. $name .'</strong> : '. $v .'</p>';
        }
    }

    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //
    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $resumen;

    send_custom_email(array(
        'to' => $data['nombre'] . '<'. $data['email'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $data['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));

    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una nueva solicitud de actividades para orientadores.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] . ' <'. $data['email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));

    return array(
        'status' => 'ok',
        'feedback' => $resumen
    );
}

/**
 * Recepcion del formulario de charlas a colegios
 * @param  array  $data - $_POST
 * @return bool
 */
function send_charlas_form( $data ){
    global $idaCRM;
    $idaCRM->tabla = "crm_admision";
    $_POST["formulario"]="charlas";
    $idaCRM->save_crm_wp();

    // if( ! wp_verify_nonce( $_POST['st_nonce'], 'enviar_formulario' ) ){
    //     wp_die('Error al enviar el formulario');
    // }

    // mapeo los datos
    $resumen = '';
    foreach( $data as $k => $v ){
        // los nonces no valen
        if( $k == '_wp_http_referer' || $k == 'st_nonce' || $k == 'email-conf' ){ continue; }

        elseif( $k == 'celular-codigo' || $k == 'celular-numero' ){
            if( $k == 'celular-numero' ){ continue; }

            $celular = $data['celular-codigo'] . ' - ' . $data['celular-numero'];
            $resumen .= '<p><strong>Celular</strong> : '. $celular .'</p>';
        }
        elseif( $k == 'telefono-codigo' || $k == 'telefono-numero' ){
            if( $k == 'telefono-numero' ){ continue; }

            $telefono = $data['telefono-codigo'] . ' - ' . $data['telefono-numero'];
            $resumen .= '<p><strong>Teléfono</strong> : '. $telefono .'</p>';
        }
        elseif( $k == 'region' ){
            $resumen .= '<p><strong>Región</strong> : '. get_region_by_id($v) .' </p>';
        }
        elseif( $k == 'comuna' ){
            $resumen .= '<p><strong>Comuna</strong> : '. get_comuna_by_id($v) .'</p>';
        }
        else {
            $name = ucwords( str_replace('-', ' ', $k) );
            $resumen .= '<p><strong>'. $name .'</strong> : '. $v .'</p>';
        }
    }

    $emails = get_emails();

    // Envia un mail de feedback al usuario que lleno el formulario
    //
    //

    $cuerpo = '<p>Hemos recibido su consulta.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $resumen;

    send_custom_email(array(
        'to' => $data['nombre'] . '<'. $data['email'] .'>',
        'subject' => 'Hemos recibido su consulta',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Reply-To: Admisión Santo Tomás <'. $emails['cotizacion'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su consulta',
            'intro' => 'Estimado/a <strong>'. $data['nombre'] . ':</strong>',
            'mensaje' => $cuerpo
        )
    ));


    // Envia un mail de feedback al administrador
    //
    //

    $cuerpo = '<p>Hemos recibido una nueva solicitud de actividades para orientadores.</p>';
    $cuerpo .= '<p>Los datos recibidos son:</p>';
    $cuerpo .= $cuerpo_datos;

    send_custom_email(array(
        'to' => 'Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
        'subject' => 'Hemos recibido una solicitud',
        'headers' => array(
            'From: Admisión Santo Tomás <'. $emails['cotizacion'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] . ' <'. $data['email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido una solicitud',
            'intro' => 'Estimado administrador:',
            'mensaje' => $cuerpo
        )
    ));

    return array(
        'status' => 'ok',
        'feedback' => $resumen
    );
}

/**
 * Sete el contenido de un email a html
 * se usa en send_custom_email
 */
function set_html_content_type(){
    return 'text/html';
}

/**
 * Envia un email usando una de las plantillas previamente determinadas,
 * Esta funcion usa los output buffers de php para usar la plantilla de emails
 * de esta forma se hace mas facil la edicion y administracion de estas plantillas
 * @param  array $email_data - Array de datos que debe contener el email, tiene la forma de
 * array(
 *        'type' => 'notificacion',
 *        'to' => $emails['contacto'],
 *        'subject' => 'Nuevo Mensaje de contacto',
 *        'headers' => array(
 *            'From: Santo Tomás en Línea <'. $emails['permanente'] .'>',
 *            'Cc: '. $emails['permanente'],
 *            'Reply-To: '. $data['contact-name'] .' <'. $data['contact-email'] .'>'
 *        ),
 *        'email_contents' => array(
 *            'title' => '',
 *            'titulo' => '',
 *            'intro' => '',
 *            'mensaje' => ''
 *        )
 *    )
 * @return  void
 */
function send_custom_email( $email_data, $return = false ){
    // $email_data['email_contents'] = array();
    // type = 'notificacion',
    // title = <title> del email (obligatorio),
    // intro = introduccion al mensaje (obligatorio)
    // mensaje = mensaje del email en formato HTML (obligatorio)

    $to = $email_data['to'];
    $subject = $email_data['subject'];
    $headers = $email_data['headers'];
    $attachments = isset($email_data['attachments']) && !empty($email_data['attachments']) ? $email_data['attachments'] : null;

    $GLOBALS['email_contents'] = $email_data['email_contents'];
    $GLOBALS['email_origen']   = $email_data['email_origen'];

    // se empieza un output buffer para contener el template del email
    ob_start();
    get_template_part('partials/email', 'notificacion');
    $message = ob_get_clean();
    // temina el output buffer

    // solo en caso de que se quiera devolver el string del correo
    if( !!$return ){ return $message; }

    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_mail( $to, $subject, $message, $headers, $attachments );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Exportaciones de contenido
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Funciones auxiliares
////////////////////////////////////////////////////////////////////////////////

/**
 * Ordena un array de sedes por su posicion
 * se usa como callback en usort
 */
function order_by_posicion( $a, $b ){
    if( is_object($a) ){
        $field_a = 'sede_'.$a->term_id;
        $field_b = 'sede_'.$b->term_id;
    }
    elseif( is_array($a) ) {
        $field_a = 'sede_'.$a['sede'];
        $field_b = 'sede_'.$b['sede'];
    }
    elseif ( is_numeric($a) ) {
        $field_a = 'sede_'.$a;
        $field_b = 'sede_'.$b;
    }

    $pos_a = get_field('posicion', $field_a );
    $pos_b = get_field('posicion', $field_b );

    if( $pos_a == $pos_b ) return 0;
    if( $pos_a < $pos_b ) return -1;
    else return 1;
}

/**
 * Ordena un array de instituciones por su posicion
 * se usa como callback en usort
 */
function order_institucion_by_posicion( $a, $b ){
    if( is_object($a) ){
        $field_a = 'institucion_'.$a->term_id;
        $field_b = 'institucion_'.$b->term_id;
    }
    elseif( is_array($a) ) {
        $field_a = 'institucion_'.$a['institucion'];
        $field_b = 'institucion_'.$b['institucion'];
    }
    elseif ( is_numeric($a) ) {
        $field_a = 'institucion_'.$a;
        $field_b = 'institucion_'.$b;
    }

    $pos_a = get_field('posicion', $field_a );
    $pos_b = get_field('posicion', $field_b );

    if( $pos_a == $pos_b ) return 0;
    if( $pos_a < $pos_b ) return -1;
    else return 1;
}


/**
 * Devuelve un mensaje de alerta formateado en base al boilerplate del sitio
 * @param  [array] $info - informacion de la alerta, tiene 'titulo' y 'mensaje'
 * @return string - HTML de la alerta
 */
function alerta( $info = array() ){
    $html = '<div class="message alert">';

    if( isset($info['titulo']) ) {
        $html .= '<h2 class="message-title">'. $info['titulo'] .'</h2>';
    }

    if( isset($info['mensaje']) ) {
        $html .= apply_filters('the_content', $info['mensaje']);
    }

    $html .= '</div>';

    return $html;
}

/**
 * [generate_share_urls]
 * @param  [object]     $post_object
 * @return [array]      URLs para compartir el post
 */
function generate_share_urls( $post_object, $custom_message = false, $target = false, $content_field = false ){

    $shortlink = wp_get_shortlink( $post_object->ID );

    if( $target ){
        $shortlink = $shortlink . '#' . $target;
    }

    $clean_url = urldecode( $shortlink );

    $title = urlencode( get_the_title( $post_object->ID ) );

    if( $custom_message ){
        $message = urlencode( cut_string_to( $custom_message, 70 ) );
    }
    elseif( $content_field ){
        $message = urlencode( cut_string_to( get_field($content_field, $post_object->ID), 70 ) );
    }
    else {
        $message = urlencode( cut_string_to( $post_object->post_content, 70 ) );
    }

    $image_url = '';
    if( has_post_thumbnail( $post_object->ID ) ){
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), 'full' );
        $image_url = $image_url[0];
    }

    $fb_link = 'http://www.facebook.com/sharer.php?u=' . get_permalink( $post_object->ID );

    $twt_link = 'https://twitter.com/intent/tweet?text=' . $title . '+' . $clean_url;

    $google_link = 'https://plus.google.com/share?url=' . $clean_url;

    $linkedin_link = 'https://www.linkedin.com/cws/share?url=' . $clean_url;

    return array(
        'facebook' => $fb_link,
        'twitter' => $twt_link,
        'google' => $google_link,
        'linkedin' => $linkedin_link,
        'shortlink' => $shortlink,
        'permalink' => get_permalink( $post_object->ID )
    );
}

/**
 * Parsea el texto de un tweet (o cualquier string) en busca de URL, hashtags y menciones
 * para luego transformarlas en links accesibles
 * @param  string $tweet_text - Texto que se quiere parsear
 * @return string - Texto parseado
 */
function parse_twitter_links( $tweet_text ){
    $urlRegexp = "/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/";
    $twitterMentionRegexp = "/\B@([\w-]+)/m";
    $hashTagRegexp = "/[#]+[A-Za-z0-9-_äáàëéèíìöóòúùñç]+/"; // hashtags hispanos

    $tweet_text = preg_replace( $urlRegexp, '<a href="$0" title="Ver enlace" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    $tweet_text = preg_replace( $twitterMentionRegexp, '<a href="https://twitter.com/$0" title="Ver perfil" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    $tweet_text = preg_replace( $hashTagRegexp, '<a href="https://twitter.com/$0" title="Ver tweets relacionados con el hashtag $0" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    return $tweet_text;
}

/**
 * Devuelve el nombre de usuario ingresado en el campo ACF "usuarios_sociales"
 * dependiendo de el nombre de la cuenta social
 * @param  string $account - Nombre de la red, posibles valores: "twitter", "facebook", "google", "linkedin"
 * @return string - Nombre de usuario de la cuenta
 */
function get_social_account( $account ){
    $usuarios = get_field('usuarios_sociales', 'options')[0];
    return $usuarios[ $account ];
}

/**
 * Va a buscar un $post en base al slug (post_name) pasado
 * @param  string $slug - Slug o post_name del post que se quiere rescatar
 * @param  string $field - (opcional) Campo especifico que se desea del post.
 *                         Puede ser cualquiera del post object
 * @return mixed - false si no encuentra el post, $post_object (object) si es que lo encuentra
 */
function get_post_by_slug( $slug, $field = false ){
    global $wpdb;
    $pid = $wpdb->get_var($wpdb->prepare("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_name = %s
    ", $slug));

    if( !$pid ){ return false; }

    $post_obj = get_post( $pid );

    if( $field && $post_obj ) {
        return $post_obj->{$field};
    }

    return get_post( $pid );
}

/**
 * Devuelve el nombre del usuario
 * @param  object $user $user_object de wordpress a quien sacarle el nombre
 * @return string Nombre del usuario parseado, danto prioridad a "primer_nombre apellido" y luego a $display_name
 */
function get_user_name( $user ){
    if( !$user || !is_object($user) ){
        return false;
    }

    $name = '';

    if( $user->first_name || $user->last_name ){
        $name = $user->first_name . ' ' . $user->last_name;
    }

    if( !$name ){ $name = $user->display_name; }

    return $name;
}

/**
 * Devuelve el post_content de un post basandose en el ID indicado
 * @param  int $pid ID del post en cuestion
 * @return string post_content del post en cuestion
 */
function get_content_by_id( $pid ){
    $p = get_post( $pid );
    return $p->post_content;
}

/**
 * Devuelve un array con los href de las redes sociales
 * @return array
 */
function get_social_links(){
    $perfiles_sociales = get_field('perfiles_sociales', 'options');
    if( !$perfiles_sociales ){ return false; }

    $perfiles_sociales = $perfiles_sociales[0];

    // filtro los resultados para asegurar una url (todas las sociales deben ir con https)
    $filtrados = array();
    foreach( $perfiles_sociales as $red => $url ){
        $filtrados[ $red ] = ensure_url( $url, 'https' );
    }

    // el repeater solo tiene un row
    return $filtrados;
}

/**
 * Devuelve el ID del termino basado en su slug/taxonomia
 * @param  string $term_slug Slug del $term en cuestion
 * @param  string $taxonomy  Nombre de la taxonomia asociada al $term
 * @return int El ID del $term indicado, 0 si no se encuentra
 */
function get_term_id( $term_slug, $taxonomy ){
    $term = get_term_by( 'slug', $term_slug, $taxonomy);
    if( !$term ){ return 0; }

    return intVal( $term->term_id );
}

/**
 * Revisa si se esta viendo la pagina de la categoria indicada o de alguno de sus categorias hijas
 * @param  slug  $parent_category_slug Slug de la categoria padre
 * @return boolean true si se encuentra en alguna de las paginas indicadas
 */
function is_category_current( $parent_category_slug ){
    // revisamos si es que estamos en el archivo de categoria
    if( is_category( $parent_category_slug ) ){ return true; }
    elseif( !is_category() && !is_single() ){ return false; }

    // revisa si es que estamos en el archivo de algun hijo de esta categoria
    $parent_term_id = get_term_id( $parent_category_slug, 'category' );

    if( is_category() ){
        $current_term = get_term_by( 'id', get_query_var( 'cat' ), 'category');
        if( $current_term->parent == $parent_term_id ){ return true; }
    }


    // revisamos si es que es un single y pertenece a la categoria o a alguno de sus hijos
    if( is_single() ){
        global $post;
        $post_cats = wp_get_post_terms($post->ID, 'category');

        // si no tiene categorias asociadas es false
        if( empty($post_cats) ){ return false; }

        $post_cat = $post_cats[0];
        // si el post tiene asignada la categoria
        if( $post_cat->slug === $parent_category_slug ){ return true; }

        // si el post tiene asignada una categoria hija a la en cuestion
        if( $post_cat->parent == $parent_term_id ){ return true; }
    }

    // si llega aca no es nada
    return false;
}

/**
 * Devuelve true si es que el $term indicado tiene hijos asignados
 * @param  int $term_id     ID del $term a revisar
 * @param  string $taxonomy Nombre de la taxonomia
 * @return boolean          true si el $term es padre, false si no tiene hijos o la taxonomia no existe
 */
function is_parent_term( $term_id, $taxonomy ){
    $children = get_term_children( $term_id, $taxonomy );
    if( is_wp_error( $children ) ){ return false; }

    return !!count($children);
}

/**
 * [printMe]
 * Imprime en pantalla cualquier cosa entre <pre>
 * @param  [mixed] $thing [description]
 * @return void
 */
function printMe( $thing ){
    echo '<pre>';
    print_r( $thing );
    echo '</pre>';
}
function get_format_date($date) {

    $array_date = explode(' ', $date);
    $array_date = $array_date[0];
    $array_date = explode('-', $array_date);
    $dia        = $array_date[2];
    $mes        = $array_date[1];
    $anho       = $array_date[0];

    return $dia.'/'.$mes.'/'.$anho;
}
/**
 * [ensure_url]
 * Convierte un string con forma de url en una URL valida, si ya es una URL valida entonces se devuelve tal cual
 * @param  [type] $proto_url [description]
 * @return [type]            [description]
 */
function ensure_url( $proto_url, $protocol = 'http' ){
    // se revisa si es un link interno primero
    if( substr($proto_url, 0, 1) === '/' ){
        return $proto_url;
    }

    if (filter_var($proto_url, FILTER_VALIDATE_URL)) {
        return $proto_url;
    }
    elseif( substr($proto_url, 0, 7) !== 'http://' || substr($proto_url, 0, 7) !== 'https:/' ){
        $url = $protocol . '://' . $proto_url;
    }

    // doble chequeo de validacion de URL
    if ( ! filter_var($url, FILTER_VALIDATE_URL) ) {
        return '';
    }

    return $url;
}

/**
 * Devuelve la URL de un attachment o false si no se encuentra el attachment
 * @param  [int] $id   ID del attachment
 * @param  [string] $size Nombre del tamano a sacar
 * @return [string] URL de la imagen en el tamano solicitado (false si es que falla)
 */
function get_image_src( $id, $size ){
    $img_data = wp_get_attachment_image_src( $id, $size );
    if( empty($img_data) ){ return false; }
    return $img_data[0];
}

/**
 * Revisa si el script dado ya se encuentra en la cola de impresion
 * si no es asi lo mete en la cola
 * @param  [string] $script_name [nombre del script a incluir]
 * @return void
 */
function needs_script( $script_name ){
    if( !wp_script_is( $script_name ) ){
        wp_enqueue_script( $script_name );
    }
}

/**
 * Devuelve el nombre del rol de un usuario
 * @param  [object] $user Objeto de usuario de wordpress
 * @return [string]
 */
function get_user_role( $user ) {
    $user_roles = $user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}

/**
 * Devuelve un string indicando cuanto tiempo (segundos, minutos, dias, horas ,etc...) ha pasado desde el timestamp indicado
 * @param  [int] $time Timestamp
 * @return [string]
 */
function time_ago( $time ) {
    $periods = array(
        array('singular' => 'segundo', 'plural' => 'segundos'),
        array('singular' => 'miunto', 'plural' => 'minutos'),
        array('singular' => 'hora', 'plural' => 'horas'),
        array('singular' => 'dia', 'plural' => 'dias'),
        array('singular' => 'semana', 'plural' => 'semanas'),
        array('singular' => 'mes', 'plural' => 'meses'),
        array('singular' => 'año', 'plural' => 'años'),
        array('singular' => 'decada', 'plural' => 'decadas')
    );
    $lengths = array("60","60","24","7","4.35","12","10");

    $now = strtotime("-3 hours"); // la hora de ahora con el timezone de santiago (-3 GMT)

    $difference = $now - $time;

    for( $id = 0; $difference > $lengths[$id] && $id < count($lengths)-1; $id++ ){
        $difference /= $lengths[$id];
    }

    $difference = round($difference);

    $time_tag = pluralize( $difference, $periods[$id]['singular'], $periods[$id]['plural'] );

    return "hace $difference $time_tag";
}

/**
 * [pluralize]
 * Pluraliza una palabra en base al numero que se pasa
 * @param  [int] $amount             numero de items
 * @param  [string] $singular_name   Nombre del item en singular
 * @param  [string] $plural_name     Nombre de item en plural
 * @return [string]                  Item pluralizado
 */
function pluralize( $amount, $singular_name, $plural_name ){
    if( intval($amount) !== 1 ){ return $plural_name; }
    return $singular_name;
}

/**
 * Devuelve el HTML de la paginacion de una $wp_query
 * @param  object $query $wp_query a la cual paginar
 * @param  string  $prev  Texto para el boton anterior
 * @param  string  $next  Texto para el boton siguiente
 * @return string HTML de la paginacion
 */
function get_pagination( $query = false, $prev = 'Anterior', $next = 'Siguiente' ) {
    global $wp_query;
    if ( !$query ) { $query = $wp_query; }

    $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;

    // opciones generales para los links de paginacion, la opcion "format" puede esar en español7
    // solo si es que esta activo el filtro para cambiar esto
    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '/page/%#%',
        'total' => $query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'mid_size' => 2,
        'type' => 'array'
    );

    $items = "";
    $pageLinksArray = paginate_links($pagination);

    if( !empty( $pageLinksArray ) ){
        // reviso si es que existe un link "anterior", lo saco del array y lo guardo en variable
        $prevLink = '';
        if( preg_match('/'. $prev .'/i', $pageLinksArray[0]) ){
            $prevLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link direction" title="Página anterior" rel="prev" ', array_shift($pageLinksArray));
            $prevLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '&lsaquo;', $prevLink);
        }

        // lo mismo para el link "siguiente"
        $nextLink = '';
        if( preg_match('/'. $next .'/i', end($pageLinksArray)) ){
            $nextLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link direction" title="Página siguiente" rel="next" ', array_pop($pageLinksArray));
            $nextLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '&rsaquo;', $nextLink);
        }

        // se ponen los links "anterior" y "siguiente" dentro del html deseado

        $items .= $prevLink;
        //se itera sobre los links de paginas
        foreach( (array)$pageLinksArray as $pageLink ){
            // se itera sobre el resto de los links con el fin de cambiar y/o agregar clases personalizadas

            // si estoy en la pagina
            if( preg_match('/current/i', $pageLink) ){
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num active" rel="nofollow" ', $pageLink);
            }

            // si son los puntitos
            elseif( preg_match('/dots/i', $pageLink) ){
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num dots" rel="nofollow" ', $pageLink);
            }

            // se cambian las clases de los links
            else {
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num" rel="nofollow" title="Ir a la página" ', $pageLink);
            }
        }
        $items .= $nextLink;
    }

    $out = '<section class="pagination">';
    $out .= $items;
    $out .= '</section>';

    return $out;
}

/**
 * Se encarga de subir adecuadamente un archivo a wordpress para que
 * quede con todos sus tamanos en caso de imagen y
 * se cree un attachment que sea visible, linkeable y editable via administrador de medios
 * @param  array $file_data - Informacion proveniente de $_FILES
 * @param  array $mimes - Array de mimeTypes permitidos
 * @return int - El attachment ID del archivo recien subido
 */
function upload_custom_file( $file_data, $mimes = null ){
    if ( ! function_exists( 'wp_handle_upload' ) ) { require_once( ABSPATH . 'wp-admin/includes/file.php' ); }

    $fotoUpload = wp_handle_upload( $file_data, array( 'mimes' => $mimes, 'test_form' => false ) );
    $filename = $fotoUpload['file'];
    $wp_filetype = wp_check_filetype(basename($filename), null );
    $wp_upload_dir = wp_upload_dir();
    $attachment = array(
        'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $filename ),
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

/**
 * cut_string_to
 * @param  [string] $string     [Texto a cortar]
 * @param  [int] $charnum       [Numero de caracteres máximo para el texto]
 * @param  string $sufix        [Sufijo para el texto cortado]
 * @return [string]             [Texto cortado]
 */
function cut_string_to( $string, $charnum, $sufix = ' ...' ){
    $string = strip_tags( $string );
    if( strlen($string) > $charnum ){
        $string = substr($string, 0, ($charnum - strlen( $sufix )) ) . $sufix;
    }
    return mb_convert_encoding($string, "UTF-8");
}

/**
 * Devuelve la extension del archivo
 * @param  string $file_path - PATH al archivo
 * @return string - Extension del archivo
 */
function parse_mime_type( $file_path ) {
    $chunks = explode('/', $file_path);
    return substr(strrchr( array_pop($chunks) ,'.'),1);
}

//Return date as 01/02/03
function get_long_date($date){
    $dia = date_i18n('d', strtotime($date));
    $mes = date_i18n('m', strtotime($date));
    $ano = date_i18n('y', strtotime(ydate));
    $fecha = $dia . '/' . $mes . '/' . $ano;
    return $fecha;
}

/**
 * Devuelve el peso del archivo formateado
 * @param  string $attachment_file_path - PATH al archivo
 * @return string - Tamano formateado en kb
 */
function get_attachment_size( $attachment_file_path ) {
    return size_format( filesize( $attachment_file_path ) );
}

/**
 * Devuelve informacion variada acerca de un attachment en cuanto al archivo
 * @param  int $attach_id - ID del attachment
 * @return array - Coleccion de datos del attachment
 */
function get_file_info( $attach_id ) {
    $filePath = get_attached_file( $attach_id );
    $attach = get_post( $attach_id );

    if ( is_object($attach) ){
        return array(
            'attachment-id' => $attach_id,
            'attachment' => $attach,
            'filepath' => $filePath,
            'file_url' => $attach->guid,
            'file_mimetype' => parse_mime_type( $filePath ),
            'file_size' => get_attachment_size( $filePath )
        );
    }

    return array();
}

/**
 * Devuelve la URL actual con un "/" al final
 * Se usa para el filtro de sedes por lo que al generar la URL se quita este filtro para uso posterior
 * @return string - URL actual
 */
function get_current_url(){
    $current_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return remove_query_arg( 'filtro-sede', $current_url );
}

/**
 * Anade o mezcla un array de tax_query existente con otro devolviendo el resultado
 * @param  mixed - $old_tax_query - tax_query actual, puede estar vacio
 * @param  array - $aditional_tax_query - tax_query que agregar
 * @param  string $relation = relation del tax_query, default: "AND"
 * @return array - tax_query formateado y mesclado
 */
function merge_tax_query( $old_tax_query, $aditional_tax_query, $relation = 'AND' ){
    if( !$old_tax_query || !is_array( $old_tax_query ) ){
        return array( $aditional_tax_query );
    }

    if( !isset($old_tax_query['relation']) || !$old_tax_query['relation'] ){
        $old_tax_query['relation'] = $relation;
    }

    $old_tax_query[] = $aditional_tax_query;
    return $old_tax_query;
}

/**
 * Devuelve el nombre del rol de un usuario
 * @param  [object] $current_user Objeto de usuario de wordpress
 * @return [string]
 */
function get_current_user_role( $current_user ) {
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}

/**
 * revisa si es que la pagina actual es la del registro de wordpress (wp_login)
 * @return boolean
 */
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/**
 * getPlusOnesByURL()
 *
 * Get the numeric, total count of +1s from Google+ users for a given URL.
 *
 * Example usage:
 * <code>
 *   $url = 'http://www.facebook.com/';
 *   printf("The URL '%s' received %s +1s from Google+ users.", $url, GetPlusOnesByURL($url));
 * </code>
 *
 * @author          Stephan Schmitz <eyecatchup@gmail.com>
 * @copyright       Copyright (c) 2014 Stephan Schmitz
 * @license         http://eyecatchup.mit-license.org/  MIT License
 * @link            <a href="https://gist.github.com/eyecatchup/8495140">Source</a>.
 * @link            <a href="http://stackoverflow.com/a/13385591/624466">Read more</a>.
 *
 * @param   $url    string  The URL to check the +1 count for.
 * @return  intval          The total count of +1s.
 */
function getPlusOnesByURL($url) {
    if( !$url ){ return 0; } // si no hay url devuelve 0

    !filter_var($url, FILTER_VALIDATE_URL) &&
        die(sprintf('PHP said, "%s" is not a valid URL.', $url));

    foreach (array('apis', 'plusone') as $host) {
        $ch = curl_init(sprintf('https://%s.google.com/u/0/_/+1/fastbutton?url=%s',
                                      $host, urlencode($url)));
        curl_setopt_array($ch, array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) ' . 'AppleWebKit/537.36 (KHTML, like Gecko) ' . 'Chrome/32.0.1700.72 Safari/537.36'
        ));
        $response = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
        curl_close($ch);

        if (200 === $curlinfo['http_code'] && 0 < strlen($response)) { break 1; }
        $response = 0;
    }
    // si no hay respuesta se falla silenciosamente
    // !$response && die("Requests to Google's server fail..?!");
    if(!$response){
        return 0;
    }


    preg_match_all('/window\.__SSR\s\=\s\{c:\s(\d+?)\./', $response, $match, PREG_SET_ORDER);
    return (1 === sizeof($match) && 2 === sizeof($match[0])) ? intval($match[0][1]) : 0;
}

/**
 * Formatea un timestamp en un formato aceptable po iCal
 * @param  [int] $timestamp
 * @return string - fecha formateada
 */
function dateToCal($timestamp) {
  return date('Ymd\THis\Z', $timestamp);
}

/**
 * Escapa caracteres raros para compatibilidad con iCal
 * @param  [string] $string - texto a sanitizar
 * @return [string] - Texto sanitizado
 */
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

/**
 * Devuelve el objeto post ancestro de primer nivel al post indicado
 * @param  [mixed] $current_post_or_id - ID o post_object del que se quiere sacar el ancestro
 * @return int - post_id del ancestro de primer nivel
 */
function get_super_parent( $current_post_or_id ){
    $ancestros = get_post_ancestors( $current_post_or_id );
    $super = array_pop( $ancestros );
    if( $super ) return $super;

    if( is_object( $current_post_or_id ) && is_a( $current_post_or_id, 'WP_Post' ) )
        return $current_post_or_id->ID;

    return $current_post_or_id;
}

/**
 * Devuelve el ID de la página data en base a su padre, hace una consulta directa a la bbdd
 * @param  [int] $parent_id - ID del padre (contexto)
 * @param  [mixed] $child_slug - Slug del objetivo o false si se quiere sacar todos los hijos de la pagina
 * @return mixed - ID de la pagina en cuestion o array de IDs de los hijos en caso de no haber $child_slug
 */
function get_child_by_slug( $parent_id, $child_slug ){
    global $wpdb;

    if( $child_slug ){
        return $wpdb->get_var($wpdb->prepare(
            "SELECT ID
            FROM $wpdb->posts
            WHERE post_type = 'page'
            AND post_status = 'publish'
            AND post_parent = %d
            AND post_name = %s",
        $parent_id, $child_slug ));
    }

    // en caso de que no haya un $child_slug se devuelve un array plano de los IDs de las paginas hijas
    $children = $wpdb->get_results($wpdb->prepare(
        "SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'page'
        AND post_status = 'publish'
        AND post_parent = %d ",
    $parent_id ));

    // se aplana el array para que no queden objetos y cosas raras
    if( is_array($children) && !empty($children) ){
        $children = array_map(function( $val ){ return $val->ID; }, $children);
    }

    return $children;
}

/**
 * Devuelve el permalink de un post o pagina desde el slug
 * @param  [string] $slug  - Slug de la pagina o post
 * @return string
 */
function get_link_by_slug( $slug ){
    return get_permalink( get_post_by_slug( $slug, 'ID' ) );
}

/**
 * Devuelve un array asociativo de emails correspondientes a las notificaciones
 * Estos se setean en el area de administracion bajo "opciones generales" > "notificaciones"
 * @return array
 */
function get_emails(){
    return get_field('emails_notificaciones', 'options')[0];
}

/**
 * Intercala los valores de 2 arrays en base al array mas largo
 * @param  [array] $array_1 - primer array
 * @param  [array] $array_2 - segundo array
 * @return array - resultado intercalado
 */
function interpolar_array($array_1, $array_2){
    $resultado = array();

    $size_1 = sizeof($array_1);
    $size_2 = sizeof($array_2);

    if( $size_1 > $size_2 ){
        $max = $size_1;
        $big = $array_1;
        $small = $array_2;
    }
    else {
        $max = $size_2;
        $big = $array_2;
        $small = $array_1;
    }

    for( $i = 0; $i < $max; $i++ ){
        $resultado[] = $big[$i];
        if( isset($small[$i]) ){
            $resultado[] = $small[$i];
        }
    }

    return $resultado;
}

/**
 * Devuelve un array con los nombres de todos los paises
 * @return array
 */
function get_paises(){
    return array('Afganistán', 'Albania', 'Alemania', 'Andorra', 'Angola', 'Anguila', 'Antigua y Barbuda', 'Antillas Holandesas', 'Antártida', 'Arabia Saudita', 'Argelia', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbayán', 'Bahamas', 'Bahréin', 'Bangladesh', 'Barbados', 'Belice', 'Benín', 'Bermudas', 'Bielorrusia', 'Bolivia', 'Bosnia-Herzegovina', 'Botsuana', 'Brasil', 'Brunéi', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Bután', 'Bélgica', 'Cabo Verde', 'Camboya', 'Camerún', 'Canadá', 'Chad', 'Chile', 'China', 'Chipre', 'Ciudad del Vaticano', 'Colombia', 'Comoras', 'Congo', 'Corea del Norte', 'Corea del Sur', 'Costa Rica', 'Costa de Marfil', 'Croacia', 'Cuba', 'Dinamarca', 'Dominica', 'Ecuador', 'Egipto', 'El Salvador', 'Emiratos Árabes Unidos', 'Eritrea', 'Eslovaquia', 'Eslovenia', 'España', 'Estados Unidos', 'Estonia', 'Etiopía', 'Filipinas', 'Finlandia', 'Fiyi', 'Francia', 'Gabón', 'Gambia', 'Georgia', 'Ghana', 'Gibraltar', 'Granada', 'Grecia', 'Groenlandia', 'Guadalupe', 'Guam', 'Guatemala', 'Guayana Francesa', 'Guernsey', 'Guinea', 'Guinea Ecuatorial', 'Guinea-Bissau', 'Guyana', 'Haití', 'Honduras', 'Hungría', 'India', 'Indonesia', 'Iraq', 'Irlanda', 'Irán', 'Isla Bouvet', 'Isla Christmas', 'Isla Niue', 'Isla Norfolk', 'Isla de Man', 'Islandia', 'Islas Caimán', 'Islas Cocos', 'Islas Cook', 'Islas Feroe', 'Islas Georgia del Sur y Sandwich del Sur', 'Islas Heard y McDonald', 'Islas Malvinas', 'Islas Marianas del Norte', 'Islas Marshall', 'Islas Salomón', 'Islas Turcas y Caicos', 'Islas Vírgenes Británicas', 'Islas Vírgenes de los Estados Unidos', 'Islas menores alejadas de los Estados Unidos', 'Islas Åland', 'Israel', 'Italia', 'Jamaica', 'Japón', 'Jersey', 'Jordania', 'Kazajistán', 'Kenia', 'Kirguistán', 'Kiribati', 'Kuwait', 'Laos', 'Lesoto', 'Letonia', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Luxemburgo', 'Líbano', 'Macedonia', 'Madagascar', 'Malasia', 'Malaui', 'Maldivas', 'Mali', 'Malta', 'Marruecos', 'Martinica', 'Mauricio', 'Mauritania', 'Mayotte', 'Micronesia', 'Moldavia', 'Mongolia', 'Montenegro', 'Montserrat', 'Mozambique', 'Myanmar', 'México', 'Mónaco', 'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'Nigeria', 'Noruega', 'Nueva Caledonia', 'Nueva Zelanda', 'Níger', 'Omán', 'Pakistán', 'Palau', 'Panamá', 'Papúa Nueva Guinea', 'Paraguay', 'Países Bajos', 'Perú', 'Pitcairn', 'Polinesia Francesa', 'Polonia', 'Portugal', 'Puerto Rico', 'Qatar', 'Región Administrativa Especial de Hong Kong de la República Popular China', 'Región Administrativa Especial de Macao de la República Popular China', 'Reino Unido', 'República Centroafricana', 'República Checa', 'República Democrática del Congo', 'República Dominicana', 'Reunión', 'Ruanda', 'Rumania', 'Rusia', 'Sahara Occidental', 'Samoa', 'Samoa Americana', 'San Bartolomé', 'San Cristóbal y Nieves', 'San Marino', 'San Martín', 'San Pedro y Miquelón', 'San Vicente y las Granadinas', 'Santa Elena', 'Santa Lucía', 'Santo Tomé y Príncipe', 'Senegal', 'Serbia', 'Serbia y Montenegro', 'Seychelles', 'Sierra Leona', 'Singapur', 'Siria', 'Somalia', 'Sri Lanka', 'Suazilandia', 'Sudáfrica', 'Sudán', 'Suecia', 'Suiza', 'Surinam', 'Svalbard y Jan Mayen', 'Tailandia', 'Taiwán', 'Tanzanía', 'Tayikistán', 'Territorio Británico del Océano Índico', 'Territorio Palestino', 'Territorios Australes Franceses', 'Timor Oriental', 'Togo', 'Tokelau', 'Tonga', 'Trinidad y Tobago', 'Turkmenistán', 'Turquía', 'Tuvalu', 'Túnez', 'Ucrania', 'Uganda', 'Uruguay', 'Uzbekistán', 'Vanuatu', 'Venezuela', 'Vietnam', 'Wallis y Futuna', 'Yemen', 'Yibuti', 'Zambia', 'Zimbabue');
}

/**
 * Devuelve un array con los nombres de todas las regiones de Chile
 * @return array
 */
function get_regiones(){
    return array(
        'I Región de Tarapacá',
        'II Región de Antofagasta',
        'III Región de Atacama',
        'IV Región de Coquimbo',
        'V Región de Valparaíso',
        'VI Región del Libertador General Bernardo O\'Higgins',
        'VII Región del Maule',
        'VIII Región del Bío Bío',
        'IX Región de La Araucanía',
        'X Región de Los Lagos',
        'XI Región de Aysen del General Carlos Ibañez del Campo',
        'XII Región de Magallanes y de La Antártica Chilena',
        'XIII Región Metropolitana de Santiago',
        'XIV Región de Los Ríos',
        'XV Región de Arica y Parinacota'
    );
}

/**
 * Devuelve un array con los nombres de todos los codigos telefonicos en Chile
 * @return array
 */
function get_phone_codes(){
    return array(
        '2', '32', '33', '34', '35', '39',
        '41', '42', '43', '44', '45', '51',
        '52', '53', '55', '57', '58', '61',
        '63', '64', '65', '67', '68', '71',
        '72', '73', '75'
    );
}

/**
 * Usada en las páginas de archivo de taxonomias (taxonomy.php)
 * Devuelve el objeto del $term que actualmente se esta viendo
 * @return object - $term_object
 */
function get_current_term(){
    return get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
}

/**
 * Revisa si una URL es externa o no
 * @param  [string]  $url   - URL a probar
 * @return boolean
 */
function is_external( $url ){
    return !strpos($url, home_url()) || strpos($url,"/") === 0;
}

/**
 * Quita todos los tildes de un stringg
 * @param  string $text
 * @return string
 */
function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
    );

    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

/**
 * Sanitiza un array de $_POST
 * @param  array $arr   - Información del $_POST
 * @return array
 */
function sanitize_input_array( $arr ){
    $safe_arr = [];

    foreach( $arr as $key => $val ){
        if( is_array($val) ) {
            $safe_arr[$key] = sanitize_input_array( $val );
        }
        else {
            $safe_arr[$key] = sanitize_text_field( $val );
        }
    }

    return $safe_arr;
}

////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// Adaptadores a tablas CRM
////////////////////////////////////////////////////////////////////////////////

/**
 * Busca y devuelve el nombre de la comuna segun su ID
 */
function get_comuna_by_id( $id ){
    global $wpdb;

    $comuna = $wpdb->get_var($wpdb->prepare(" SELECT name FROM santotomas_comunas WHERE Id = %s ", $id));
    return ucwords( mb_strtolower($comuna) );
}

/**
 * Busca y devuelve el nombre de la region segun su ID
 */
function get_region_by_id( $id ){
    global $wpdb;

    $region = $wpdb->get_var($wpdb->prepare(" SELECT name FROM santotomas_regiones WHERE Id = %s ", $id));
    return ucwords( mb_strtolower($region) );
}

/**
 * Busca y devuelve el nombre de la carrera segun su ID
 */
function get_carrera_by_id( $id ){
    global $wpdb;

    $carrera = $wpdb->get_var($wpdb->prepare(" SELECT name FROM santotomas_carreras WHERE xrmId = %s ", $id));
    return ucwords( mb_strtolower($carrera) );
}

/**
 * Busca y devuelve el nombre de la colegio segun su ID
 */
function get_colegio_by_id( $id ){
    global $wpdb;

    $colegio = $wpdb->get_var($wpdb->prepare(" SELECT name FROM santotomas_colegios WHERE Id = %s ", $id));
    return ucwords( mb_strtolower($colegio) );
}
/**
 * Busca y devuelve el nombre de la colegio segun su ID
 */
function get_zonaadmision_by_id( $id ){
    global $wpdb;

    $zonas = $wpdb->get_var($wpdb->prepare(" SELECT name FROM santotomas_zonasadmision WHERE Id = %s ", $id));
    return ucwords( mb_strtolower($zonas) );
}


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Clases
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////// AJAX
// se instancia la clase ajax
$st_ajax = new ST_ajax();
class ST_ajax {
    /////// setea los actions para registrar ajax en wordpress
    function __construct(){
        add_action('wp_ajax_st_front_ajax', array( $this, 'set_ajax' ));
        add_action('wp_ajax_nopriv_st_front_ajax', array( $this, 'set_ajax' ));
    }

    // se asgura de que exista un metodo en esta clase, si no existe entonces die()
    function set_ajax(){
        if( isset($_REQUEST['funcion']) && $_REQUEST['funcion'] && method_exists($this, $_REQUEST['funcion']) ){
            $this->{$_REQUEST['funcion']}( sanitize_input_array( $_REQUEST ) );
        }
        else {
            die('Not Allowed >:(');
        }
    }

    function career_search( $data ){
        die(json_encode([
            'status' => 'ok',
            'html' => generate_careers_search_list([
                'show_icons' => true,
                'tax_search' => true,
                'taxonomy' => $data['type'],
                'term_id' => $data['value']
            ])
        ]));
    }

    function get_calendar_events( $data ){
        ///
        /// se crean las variables de la fecha que se busca
        ///

        /// reviso cual es la direccion de la accion (prev o next)
        $direction = $data['direction'];

        // en base a la direccion se decide el mes objetivo
        if( $direction === 'prev' ){ $target_month_num = intval($data['month']) - 1; }
        elseif( $direction === 'next' ) { $target_month_num = intval($data['month']) + 1; }
        elseif( $direction === 'same' ) { $target_month_num = intval($data['month']); }

        $target_year = intval($data['year']);

        if( $direction !== 'day' ){
            /// hay que hacer una validacion del mes objetivo para
            /// preparar los casos de los extremos antes de enero y despues de diciembre
            /// o meses que pueden quedar en 0 o 13
            /// en el caso de que esto pase el ano objetivo tambien debe cambiar
            if( $target_month_num < 1 ){
                $target_month_num = 12;
                $target_year = $target_year - 1;
            }
            elseif( $target_month_num > 12 ){
                $target_month_num = 1;
                $target_year = $target_year + 1;
            }

            $target_month_name = date_i18n('F', mktime(0,0,0, $target_month_num, 1, $target_year));
            $last_day_of_month = date('t', mktime(0,0,0, $target_month_num, 1, $target_year));

            $period_start = date('Ymd', mktime(0,0,0, $target_month_num, 1, $target_year));
            $period_end = date('Ymd', mktime(23,59,59, $target_month_num, $last_day_of_month, $target_year));

            $meta_query = array(
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
            );
        }
        else {
            $target_month_num = $data['month'];
            $target_year = $data['year'];
            $target_day = $data['day'];

            $target_month_name = date_i18n('F', mktime(0,0,0, $target_month_num, $target_day, $target_year));
            $last_day_of_month = date('t', mktime(0,0,0, $target_month_num, $target_day, $target_year));

            $period_start = date('Ymd', mktime(0,0,0, $target_month_num, $target_day, $target_year));

            $meta_query = array(
                'relation' => 'OR',
                array(
                    array(
                        'key'     => 'fecha_inicio',
                        'value'   => $period_start,
                        'compare' => '='
                    )
                ),
                array(
                    array(
                        'key'     => 'fecha_termino',
                        'value'   => $period_start,
                        'compare' => '>='
                    )
                )
            );
        }


        $tax_query = null;
        if( isset($data['filter']) && $data['filter'] ){
            $tax_query = array(
                array(
                    'taxonomy' => 'tipos_calendarios',
                    'field' => 'term_id',
                    'terms' => (int)$data['filter']
                )
            );
        }


        $arguments = array(
            'post_type' => 'calendario',
            'post_status' => 'publish',
            'posts_per_page' => 31,
            'meta_key' => 'fecha_inicio',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',

            'tax_query' => $tax_query,

            /// todos los posts que sean dentro de este mes
            /// desde el primer hasta el ultimo dia
            'meta_query' => $meta_query
        );

       // $test_query = new WP_Query($arguments);


        $items = generate_calendar_module_list( $arguments );

        $prev_month = strtotime("-1 month", mktime(0,0,0, $target_month_num, 1, $target_year));
        $prev_month = date_i18n('F - Y', $prev_month);

        $next_month = strtotime("+1 month", mktime(0,0,0, $target_month_num, 1, $target_year));
        $next_month = date_i18n('F - Y', $next_month);

        die(json_encode(array(
            'items' => $items,
            'month_num' => $target_month_num,
            'month_name' => $target_month_name,
            'year' => $target_year,
            'prev' => strtoupper($prev_month),
            'next' => strtoupper($next_month)
        )));
    }

    function send_postulacion( $data ){
        global $idaCRM, $wpdb;

        // if(  ! wp_verify_nonce( $data['st_nonce'], 'enviar_formulario_cotizacion' ) ) {
        //     die(json_encode(array('status' => 'error', 'error' => 'invalid_nonce')));
        // }

        // se envia el formulario a traves del CRM
        $respuesta_crm = $idaCRM->push_postulacion();

        // si el CRM da false
        // se indica un error
        if( !$respuesta_crm ){
            ob_start();
            get_template_part('partials/cotizacion-feedback-error');
            $feedback = ob_get_clean();
            die(json_encode(array(
                'status' => 'crm_error',
                'feedback' => $feedback
            )));
        }

        $nombre = trim($data['contacto-nombre'] .' '. $data['contacto-apellido-paterno'] .' '. $data['contacto-apellido-materno']);

        $colegio = $wpdb->get_var($wpdb->prepare("
            SELECT name
            FROM santotomas_colegios
            WHERE id = %s
        ", $data['cotizacion-colegio']));

        $comuna = $wpdb->get_var($wpdb->prepare("
            SELECT comunas.name
            FROM santotomas_comunas as comunas
            WHERE comunas.id = %s
        ", $data['cotizacion-comuna']));

        $region = $wpdb->get_var($wpdb->prepare("
            SELECT regiones.name
            FROM santotomas_regiones as regiones
            WHERE regiones.id = %s
        ", $data['cotizacion-region']));


        if( $data['cotizacion-ano-cursado'] === 'egresado' ){
            $curso = 'Egresado';
            $egreso = $data['cotizacion-ano-egreso'];
        }
        else {
            $offset = 4 - intval($data['cotizacion-ano-cursado']);
            $curso = $data['cotizacion-ano-cursado'] . ' Medio';
            $egreso = date('Y') + $offset;
        }

        $carreras = array();
        foreach( $data['combo-carreras'] as $car ){
            if( empty($car['carrera']) ){ continue; }

            $db_carrera = $wpdb->get_results($wpdb->prepare("
                SELECT * FROM santotomas_carreras
                WHERE xrmId = %s;
            ", $car['carrera']));

            if( !empty($db_carrera) ){
                $carreras[] = $db_carrera[0];
            }
        }

        $GLOBALS['datosForm'] = array(
            'nombre' => $nombre,
            'rut' => $data['contacto-rut'],
            'mail' => $data['contacto-email'],
            'celular' => $data['contacto-celular-codigo'] . ' - ' . $data['contacto-celular-numero'],
            'colegio' => $colegio,
            'comuna' => $comuna,
            'region' => $region,
            'curso' => $curso,
            'egreso' => $egreso,
            'carreras' => $carreras
        );

        ob_start();
        get_template_part('partials/cotizacion-feedback');
        $feedback = ob_get_clean();

        die(json_encode(array(
            'status' => 'ok',
            'feedback' => $feedback
        )));
    }
}



////////////////////////////////////////////////////////////////////////////////
//////////////////// Endpoints REST API
////////////////////////////////////////////////////////////////////////////////
$st_rest = new ST_rest();
class ST_rest {
    function __construct(){
        add_action('rest_api_init', array( $this, 'set_endpoints' ));
    }

    function set_endpoints(){
        register_rest_route('st-rest', 'galeria/(?P<id>\d+)/(?P<index>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'get_gallery'],
            'args' => array(
                'id' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                ),
                'index' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                )
            )
        ]);
    }

    function get_gallery( WP_REST_Request $request ){
        $pid = (int)$request->get_param( 'id' );
        $index = (int)$request->get_param( 'index' );
        $galeria = get_field('galerias', $pid)[$index];

        $html = generate_regular_gallery_slider( $galeria['imagenes'] );

        return [
            'status' => 'ok',
            'html' => $html
        ];
    }
}

function get_despliegue_areas(){
    $pagearea = get_page_by_path('areas-ust');
    $areas_args = array(
                'post_type' => 'page',
                'posts_per_page' => '-1',
                'post_parent' => $pagearea->ID,
                'order' => 'ASC',
                'orderby' => 'title'
                );
    $areas_ust = new WP_Query($areas_args);
    $count = 0;
                            
    if($areas_ust->have_posts()):
        while($areas_ust->have_posts()):
            $areas_ust->the_post();
            $count++;

            $printareasust .=                  '<li>';
            $printareasust .=                      '<a href="'.get_permalink($post).'" title="Ver ">';
            $printareasust .=                          get_the_title( $post );
            $printareasust .=                      '</a>';
            $printareasust .=                  '</li>';

            if($count==8){
                $firstcol = $printareasust;
                $printareasust = "";
            }else if($count==15){
                $seconcol = $printareasust;
                $printareasust = "";
            }
        endwhile;
    endif;
    wp_reset_query();

    $printareas  =  '<div class="content-box">';
    $printareas .=      '<h2 class="content-box-title primario light">';
    $printareas .=          '<span class="tag full">Áreas de Santo Tomás</span>';
    $printareas .=      '</h2>';
    $printareas .=          '<div class="content-box-body parent height-equalized">';
    $printareas .=              '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltabet">';
    $printareas .=                  '<ul class="regular-list two-child regular-text">';
    $printareas .=                      $firstcol;
    $printareas .=                  '</ul>';
    $printareas .=              '</div>';
    $printareas .=              '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltabet">';
    $printareas .=                  '<ul class="regular-list two-child regular-text">';
    $printareas .=                      $seconcol;
    $printareas .=                  '</ul>';
    $printareas .=              '</div>';
    $printareas .=          '</div>';
    $printareas .=  '</div>';

    return $printareas;
}