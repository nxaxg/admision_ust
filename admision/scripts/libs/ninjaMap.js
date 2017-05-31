(function(window, document, $){
    "use strict";

    var render_map = function( map_box, options ){
        var $mapElement = $(map_box);

        // seteo de argumentos para el mapa
        var args = {
            zoom : 16,
            center : new google.maps.LatLng(0, 0),
            mapTypeId : google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            draggable: false,
            zoomControl: true,
            disableDoubleClickZoom: true,
            streetViewControl: false,
            overviewMapControl: false,
            panControl: false
        };

        var defaultSettings = $.extend(true, {}, args, (options || {}));

        // se crea el mapa en base al elemento
        var map = new google.maps.Map( map_box, defaultSettings);

        // se anade la referencia a los markers
        $mapElement.data('google_maps_markers', []);
        map.markers = [];

        if( $mapElement.data('map-markers') ){
            add_markers( $mapElement.data('map-markers'), map, $mapElement );
        }

        // se agrega el objeto de mapa al elemento para facilitar manipulacion posterior
        $mapElement.data('google_map', map);
    };

    var add_markers = function( markers_data, map, $mapElement ){
        // si los datos no vienen en forma de array no se ejecuta
        if( ! $.isArray( markers_data ) ){ return false; }

        $.each( markers_data, function(index, marker){
            var geocoder;
            var latlng;

            // si el marker viene con las coordenadas preformateadas se agregan directamente
            if( marker.lat && marker.lng ){
                latlng = new google.maps.LatLng( marker.lat, marker.lng, marker.tooltip );
                push_marker( marker, latlng, map, markers_data.length, $mapElement );
            }

            // si e marker viene con una direccion (string) hay que formatear las coordenadas con el api de Geocoding
            else if( marker.address ) {
                geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 
                    'address': marker.address 
                }, function(results, status){
                    // si paso todo bien se sacan las nuevas coordenadas
                    if (status == google.maps.GeocoderStatus.OK) {
                        push_marker( marker, results[0].geometry.location, map, markers_data.length, $mapElement );
                    }

                    // si se produjo un fallo se informa a traves de la consola
                    else {
                        console.log('Geocoder no fue exitoso para la direccion: ' + marker.address);
                        console.log(status);
                    }
                });
            }
        });
    };

    var push_marker = function( marker_data, latlng, map, totalLength, $mapElement ){
        // se genera la informacion de cada marker
        var map_marker = new google.maps.Marker({
                position : latlng,
                map : map
            });

        var element_markers_data = $mapElement.data('google_maps_markers');

        element_markers_data.push({
            marker_data : marker_data,
            map_marker : map_marker
        });

        // se agrega a la lista de markers del mapa
        $mapElement.data('google_maps_markers', element_markers_data);
        map.markers.push( map_marker );

        // si el marker viene con informacion html (tooltip) se agrega con el api
        if( marker_data.tooltip ){
            // se crea el objeto con el tooltip
            var infowindow = new google.maps.InfoWindow({
                    content : marker_data.tooltip
                });

            // se agrega listener para que al click en el marker se despliegue el tooltip
            google.maps.event.addListener(map_marker, 'click', function() {
                infowindow.open( map, map_marker );
            });
        }

        if( map.markers.length === totalLength ){
            var map_offset = false;

            if( $mapElement.data('map-offset') ){
                map_offset = $mapElement.data('map-offset');
            }

            center_map( map, map_offset ); 
            
            $(window).on('resize', function(){ 
                center_map( map, map_offset ); 
            });
        }
    };

    var center_map = function( map, offset ){
        // objeto que calcula los limites del mapa
        var bounds = new google.maps.LatLngBounds();
     
        // se loopea a traves de los markers para alimentar a bounds
        $.each( map.markers, function( i, marker ){
            var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
            bounds.extend( latlng );
        });
     
        // 1 solo marker
        if( map.markers.length == 1 ) {
            // se centra y zoomea el mapa
            map.setCenter( bounds.getCenter() );
            map.setZoom( 16 );
        }
        else {
            // se centra haciendo zoom para los limites establecidos por los markers
            map.fitBounds( bounds );
        }

        if( offset ){
            map.panBy(offset.x, offset.y);
        }
    };



    // se agrega plugin de jQuery
    $.fn.ninjaMap = function( options ){
        if( this.data('google_map') ){ 
            return this.data('google_map'); 
        }

        return this.each(function( index, elem ){
            render_map( elem, options );
        });
    };


}(this, this.document, jQuery));