(function(window, document, $){
    "use strict";

    var DEBUG = true;

    var $window = $(window),
        $document = $(document),
        $body, $mainNav, $mainHeader;

    /// guardo los media queries
    var TABLETS_DOWN = 'screen and (max-width: 1024px)',
        VERTICAL_TABLETS_DOWN = 'screen and (max-width: 850px)',
        PHABLETS_DOWN = 'screen and (max-width: 640px)';

    var throttle = function( fn ){
        return setTimeout(fn, 1);
    };

    var mqMap = function( mq ){
        var MQ = '';

        switch( mq ){
            case 'tablet-down' :
                MQ = TABLETS_DOWN;
                break;
            case 'vertical-tablet-down' :
                MQ = VERTICAL_TABLETS_DOWN;
                break;
            case 'phablet-down' :
                MQ = PHABLETS_DOWN;
                break;
        }

        return MQ;
    };

    var normalize = (function() {
            var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
                to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
                mapping = {};

            for(var i = 0, j = from.length; i < j; i++ )
                mapping[ from.charAt( i ) ] = to.charAt( i );

            return function( str ) {
                var ret = [];
                for( var i = 0, j = str.length; i < j; i++ ) {
                    var c = str.charAt( i );
                    if( mapping.hasOwnProperty( str.charAt( i ) ) )
                        ret.push( mapping[ c ] );
                    else
                        ret.push( c );
                }
                return ret.join( '' );
            };
        })();


    // trackeos de analytics
    var track = function( data ){
        if( !dataLayer ){
            DEBUG && console.log('No hay dataLayer');
            return;
        }

        dataLayer.push(data);
        DEBUG && console.log('Enviado a GTM', data);
    };

    var App = function(){
        this.path = document.body.getAttribute('data-path');
        this.ajaxURL = '/wp-admin/admin-ajax.php';
        this.loadLegacyAssets();

        // precarga de imagen de fondo
        // loader del formulario de cortizacion
        // para que no se demore en mostrar el feedback
        var preload_img = new Image();
        preload_img.src = this.path + 'images/icons/loading-select-icon.svg';
    };

    App.prototype = {
        onReady : function(){
            this.setGlobals();
            this.autoHandleEvents( $('[data-func]') );
            this.handleMobileTables();
            this.conditionalInits();
            this.handleForms();
            this.fixed_table();

            // elimina el 300ms delay en IOS
            $('a, button, input[type="submit"]').on('touchstart', $.noop);

            // activa trackeos de eventos en GTM
            $body.on('click.st_gtm', '[data-track]', function(){
                var $item = $(this);

                track({
                    event : $item.data('gtm-event'),
                    eventCategory : $item.data('gtm-eventcategory'),
                    eventAction : $item.data('gtm-eventaction'),
                    eventLabel : $item.data('gtm-eventlabel')
                });
            });
        },

        onLoad : function(){
            var app = this;

            $('[data-equalize="children"][data-mq="tablet-down"]').equalizeChildrenHeights(true, TABLETS_DOWN);
            $('[data-equalize="children"][data-mq="vertical-tablet-down"]').equalizeChildrenHeights(true, VERTICAL_TABLETS_DOWN);
            $('[data-equalize="target"][data-mq="vertical-tablet-down"]').equalizeTarget(true, VERTICAL_TABLETS_DOWN);

            // videos elasticos
            $('.experiencia-destacada .thumbnail, .experiencia .thumbnail').fitVids();

             //  se activa masonry
            if( document.querySelector('[data-masonry-grid]') ){
                var $masonry_items = $('[data-masonry-grid]');

                $masonry_items.each(function( index, el ){
                    throttle(function(){
                        app.masonry = new Masonry( el, {
                            itemSelector: '.masonry-item',
                            percentPosition: true
                        });
                    });
                });
            }

            $window.trigger('resize');
        },

        onResize : function(){
            throttle(this.setFixedHeader);
        },

        onScroll : function(){
            if( Modernizr.mq( VERTICAL_TABLETS_DOWN ) ){
                if( this.fixedNav ){
                    $mainHeader.css('height', 'auto').removeClass('fixed');
                    this.fixedNav = false;
                }

                return;
            }

            var scroll = $window.scrollTop();

            if( (scroll >= this.navPos) && !this.fixedNav ){
                $mainHeader.addClass('fixed').css('height', $mainHeader.height());
                this.fixedNav = true;
            }
            else if( (scroll < this.navPos) && this.fixedNav ){
                $mainHeader.css('height', 'auto').removeClass('fixed');
                this.fixedNav = false;
            }
        },

        loadLegacyAssets : function(){
            // voy a asumir que cualquier browser que no soporte <canvas> es un oldIE (IE8-)
            if( Modernizr.canvas ){ return false; }

            Modernizr.load({
                load : this.path + 'scripts/support/selectivizr.min.js'
            });
        },

        autoHandleEvents : function( $elements ){
            if( !$elements || !$elements.length ){ return false; }

            var self = this;

            $elements.each(function(i,el){
                var func = el.getAttribute('data-func') || false,
                    evts = el.getAttribute('data-events') || 'click.customStuff';

                if( func && typeof( self[func] ) === 'function' ){
                    $(el)
                        .off(evts)
                        .on(evts, $.proxy(self[func], self))
                        .attr('data-delegated', 'true');
                }
            });
        },

        setEnquire : function(){
            var app = this,
                $mutable = $('[data-mutable]');

            enquire.register( TABLETS_DOWN, [{
                match: function(){
                    app.moveElements($mutable.filter('[data-mutable="tablet-down"]'), 'mobile');
                },
                unmatch: function(){
                    app.moveElements($mutable.filter('[data-mutable="tablet-down"]'), 'desktop');
                }
            }]);

            enquire.register( VERTICAL_TABLETS_DOWN, [{
                match: function(){
                    app.moveElements($mutable.filter('[data-mutable="vertical-tablet-down"]'), 'mobile');
                },
                unmatch: function(){
                    app.moveElements($mutable.filter('[data-mutable="vertical-tablet-down"]'), 'desktop');

                    // en caso de que el menu este desplegado cuando se hace un resize
                    $('[data-func="deployMainNav"]').removeClass('deployed');
                    $('#main-nav').removeClass('deployed').removeAttr('style');
                }
            }]);

            // para qeu todo funcione bien en movil
            // se gatilla el evento resize en window
            $window.trigger('resize');
        },

        conditionalInits : function(){
            // modulo de sliders en singles
            if( $('[data-role="index-slider-module"]').length ){
                this.indexSlider( $('[data-role="index-slider-module"]') );
            }

            // modulo de sliders en singles
            if( $('[data-role="single-slider-module"]').length ){
                this.singleSlider( $('[data-role="single-slider-module"]') );
            }

            /// para los single que tengan contadores de shares
            if( $('[data-role="share-counter"]').length ){
                this.getShareCount( $('[data-role="share-counter"]') );
            }

            /// todos los inpiut type file se estilizan
            if( $('input[type="file"]').length ){
                $('input[type="file"]').beautify();
            }

            // mapas de google
            if( typeof google !== 'undefined' && $('[data-googlemap]').length ){
                this.handleMaps( $('[data-googlemap]') );
            }

            // si no reconoces matchmedia no mereces enquire
            if( window.matchMedia ){
                this.setEnquire();
            }

            // datepicker para cuando sea necesario
            if( typeof($.fn.datepicker) !== 'undefined' ){
                // se asume la global "calendar_dates" que viene desde wordpress
                $('[data-role="datepicker-calendar"]').datepicker({
                    dayNames : ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesMin : ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                    dayNamesShort : ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    beforeShowDay : function( date ){
                        var stampString = $.datepicker.formatDate('yymmdd', date);

                        if( $.inArray( stampString, calendar_dates) !== -1 ){
                            return [true, '', ''];
                        }

                        return [false, '', ''];
                    },
                    onSelect : function( text, datepicker ){
                        app.calendarLoad({
                            direction : 'day',
                            month : datepicker.selectedMonth + 1, // empieza desde 0
                            year : datepicker.selectedYear,
                            day : datepicker.selectedDay,
                            filter : $('#calendar-filter').val()
                        });
                    }
                });
            }


            /// cuando se encuentra touch el menu actua diferente
            if( Modernizr.touch ){
                $('.main-nav-items').on('click', '.menu-item-has-children > a', function( event ){
                    event.stopPropagation();

                    var $li = $(event.currentTarget).parent();

                    if( $li.hasClass ('deployed') ){
                        return true;
                    }

                    event.preventDefault();

                    $li.siblings().removeClass('deployed');
                    $li.addClass('deployed');
                });

                $document.on('click', function(){
                    $('.main-nav-items .menu-item-has-children').removeClass('deployed');
                });
            }

            /// Se activa cuando hay un hash y me encuentro en las plantillas de single curso.
            if( $body.hasClass('page-template-becas-y-creditos') && window.location.hash){
                // activamos de inmediato el tab correspondiente
                var tab_hash = window.location.hash.substr(1);
                $('[data-func="tabControl"][data-target="'+ tab_hash +'"]').trigger('click');
            }

            // dataTables para las tablas cuaticas
            if( $('[data-tabletype="paginated"]').length ){
                this.handleDataTable( $('[data-tabletype="paginated"]') );
            }

            // dataTables para las tablas aranceles
            if( $('[data-tabletype="sortable"]').length ){
                this.handleSortableTable( $('[data-tabletype="sortable"]') );
            }
        },

        setGlobals : function(){
            $body = $('body');
            $mainHeader = $('#main-header');
            $mainNav = $('#main-nav');

            if( $mainNav.length ){
                this.navPos = $mainNav.offset().top;
            }
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Auxiliares
        ///////////////////////////////////////////////////////////
        debug : function( message ){
            DEBUG && console.log( message );
        },

        moveElements : function( $set, type ){
            var areaType = 'data-' + type +'-area',
                groups = $set.groupByAtt( areaType );

            groups.forEach(function( $group ){
                var $target = $('[data-area-name="'+ $group.first().attr( areaType ) +'"]');

                $group.sort(function(a, b){
                    return $(a).data('order') - $(b).data('order');
                });

                $group.appendTo( $target );
            });
        },

        setFixedHeader : function(){
            var header = document.querySelector('#main-header');
            if( !header ){ return; }

            if( Modernizr.mq(VERTICAL_TABLETS_DOWN) ){
                var headerHeight = header.offsetHeight;
                var relOffset = 0;
                var formDeployer = document.getElementById('mobile-form-deployer');

                if( formDeployer ){
                    relOffset = formDeployer.offsetHeight;
                }

                document.body.style.marginTop = headerHeight + relOffset + 'px';
            }
            else {
                document.body.style.marginTop = 0;
            }
        },

        copySelectData : function( $fields ){
            var map = [];

            $fields.each(function( index, select ){
                var $clone = $(select).clone(true);
                $clone.data('selected', $(select).prop('selectedIndex'));
                map.push($clone);
            });

            return map;
        },

        calendarLoad : function( data ){
            var app = this,
                $dataHolder = $('[data-role="calendar-data"]'),
                $monthName = $('[data-role="calendar-month"]'),
                $itemsHolder = $('[data-role="calendar-items-holder"]');

            if( !app.isLoading ){
                app.isLoading = true;

                /// se debe indicar que se esta cargando, asumo estados estandar
                /// eso queire decir, opacity nomas
                $monthName.css('opacity', '0.2');
                $itemsHolder.css('opacity', '0.2');

                $.ajax({
                    method : 'get',
                    url : app.ajaxURL,
                    dataType : 'json',
                    data : {
                        action : 'st_front_ajax',
                        funcion : 'get_calendar_events',
                        month : data.month,
                        year : data.year,
                        day : data.day,
                        direction : data.direction,
                        filter : data.filter
                    }
                }).done(function( response ){
                    $dataHolder.data('month', response.month_num);
                    $dataHolder.data('year', response.year);

                    $monthName
                        .text( response.month_name + ' - ' +  response.year)
                        .attr({
                            'data-prev' : response.prev,
                            'data-next' : response.next
                        });

                    $itemsHolder.html( response.items );

                    $monthName.css('opacity', '1');
                    $itemsHolder.css('opacity', '1');

                    app.isLoading = false;
                });
            }
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Generales
        ///////////////////////////////////////////////////////////
        genericInvalidInputAction : function( $input ){
            // informacion basica
            var offset = $input.offset(),
                height = $input.outerHeight(),
                width = $input.outerWidth(),
                id = $input.attr('id'),
                mensaje = $input.data('error-message') || 'Campo obligatorio';

            if( ! $('#' + id + '-error-tooltip').length ){
                // genero el tooltip
                var $tooltip = $('<div />').attr({
                        'id' : id + '-error-tooltip',
                        'class' : 'form-error-tooltip',
                        'style' : 'z-index:1010'
                    }).text( mensaje );

                $tooltip.appendTo('body').css({
                    top : offset.top + height + 10,
                    left : offset.left + width - $tooltip.outerWidth()
                });

                setTimeout(function(){
                    $tooltip.fadeOut(900, function(){ $tooltip.remove(); });
                }, 10000);
            }
        },

        fixed_table: function(){
            if( $('[data-fixed="fixed"]').length ){
                var ninjaSticky = $('[data-fixed="fixed"]').ninjaStickyBox( 65, {
                    engage : function( $element, sticky ){
                        console.log( $('.header-body').outerHeight() );
                        sticky.position_offset = $('.header-body').outerHeight();
                    }
                });
                $window.scroll(function(){
                    ninjaSticky.handleResize();
                });
            }
        },

        handleForms : function(){
            var app = this;

            /// metodos comunes para validacion
            var validations = {
                validateRut : function( $input ) {
                    var value = $input.val().trim(),
                        validity = value.length >= 6 && $.Rut.validar( value );
                    if(
                        value == '0000000-0' ||
                        value == '1111111-1' ||
                        value == '2222222-2' ||
                        value == '3333333-3' ||
                        value == '4444444-4' ||
                        value == '5555555-5' ||
                        value == '6666666-6' ||
                        value == '7777777-7' ||
                        value == '8888888-8' ||
                        value == '00000000-0' ||                        
                        value == '11111111-1' ||
                        value == '22222222-2' ||
                        value == '33333333-3' ||
                        value == '44444444-4' ||
                        value == '55555555-4' ||
                        value == '66666666-6' ||
                        value == '77777777-7' ||
                        value == '88888888-8' ||
                        value == '99999999-9'
                        ){
                        return false;
                      }
                    if( !validity ){ return false; }

                    // modifique el formateador para que quitara los puntos
                    // y dejara solo el guion
                    $input.val( $.Rut.formatear( value, true ) );
                    $('#' + $input.attr("id")  + '-error-tooltip' ).remove();
                    return true;
                },

                // validacion de inputs numericos
                onlyNumbers : function( $input ){
                    var value = $input.val(),
                        cleaned = value.replace(/\D/g, ''),
                        minLength = $input.attr('data-min') || 8;
                        $input.val(cleaned);

                    //solo actua en los campos requeridos
                    if( !cleaned && !$input.prop('required') ){ return true; }

                    if( cleaned.length < minLength ){
                        return false;
                    }
                    $('#' + $input.attr("id")  + '-error-tooltip' ).remove();
                    return true;
                },

                onlyNumbersEgreso : function( $input ){
                    var value = $input.val(),
                        cleaned = value.replace(/\D/g, ''),
                        minLength = $input.attr('data-min') || 4;
                        console.log(minLength);
                        $input.val(cleaned);

                    var siglo = cleaned.substring(0, 2);
                    //solo actua en los campos requeridos
                    if( !cleaned && !$input.prop('required') ){ return true; }

                    if (siglo != 20 && siglo != 19){
                      return false;
                    }

                    if( cleaned.length < minLength ){
                        return false;
                    }
                    $('#' + $input.attr("id")  + '-error-tooltip' ).remove();
                    return true;
                },

                onlyString : function( $input ) {
                    var value = $input.val(),
                        cleaned = value.replace(/\d/g, '');

                    $input.val(cleaned);

                    //solo actua en los campos requeridos
                    if( !cleaned && !$input.prop('required') ){ return true; }

                    $('#' + $input.attr("id")  + '-error-tooltip' ).remove();
                    return cleaned;
                },

                // validacion de confirmacion de email
                equalToEmail : function( $input, validizr ){
                    var value = $input.val(),
                        sampleVal = $('#' + $input.data('sample')).val();

                    // si cualquiera de los 2 esta vacio
                    if( !value || !sampleVal ) {
                        return false;
                    }

                    // si cualquiera de los 2 no corresponde a un email
                    if( !validizr.emailRegEx.test(value) || !validizr.emailRegEx.test(sampleVal) ){
                        return false;
                    }

                    // si no son iguales
                    if( value !== sampleVal ){
                        return false;
                    }

                    // si paso todo lo anterior entonces esta bien
                    $('#' + $input.attr("id")  + '-error-tooltip' ).remove();
                    return true;
                }
            };


            // validacion generica: campos comunes y envio sincronico
            $('[data-validation="generic"]').validizr({
                customValidation : validations,
                notValidInputCallback : this.genericInvalidInputAction
            });

            // validacion de filtros: se usa en las plantillas aranceles y becas y creditos
            $('[data-validation="calendar-filters"]').validizr({
                validFormCallback : function( $form ){
                    var direction = 'same',
                        $dataHolder = $('[data-role="calendar-data"]'),
                        month = $dataHolder.data('month'),
                        year = $dataHolder.data('year');

                    app.calendarLoad({
                        direction : direction,
                        month : month,
                        year : year,
                        filter : $('#calendar-filter').val()
                    });

                    // para asegurar que el formulario no se envie
                    return false;
                }
            });

            app.resultsActive = false;
            // validacion para los formularios de busqueda de carreras
            $('[data-validation="career-search"]').validizr({
                customValidation : {
                    careerSelect : function( $input, validizr, event ){
                        // variables de elementos
                        var $searchSection = $input.parents('.career-search-section'),
                            $resultsSection = $('#career-search-results'),
                            $resultsBox = $resultsSection.find('[data-role="results-box"]');

                        // variables de data
                        var searchType = validizr.$form.data('filter-type'),
                            val = $input.val();

                        if( !$input.val() ){
                            // cancelar busqueda
                            $searchSection.removeClass('active');
                            $searchSection.siblings().removeClass('active');
                            $resultsSection.removeClass('active');

                            // se resetean los resultados de busqueda
                            $resultsBox.removeClass('loaded').empty();

                            return true;
                        }

                        // cuando se selecciona un filtro se resetean todos los demas
                        $searchSection
                            .siblings()
                            .removeClass('active')
                            .find('select')
                            .prop('selectedIndex', 0);

                        // se resetean los resultados de busqueda
                        $resultsBox.removeClass('loaded').empty();

                        // se activa el campo actual
                        $searchSection.addClass('active');
                        $resultsSection.addClass('active');

                        $.getJSON( app.ajaxURL, {
                            action : 'st_front_ajax',
                            funcion : 'career_search',
                            type : $input.attr('name'),
                            value : $input.val()
                        }).then(function( response ){
                            $resultsBox.addClass('loaded').html( response.html );
                        });

                        return true;
                    }
                }
            });

            // validacion del formulario de cotizacion
            // es compleja y tiene conexion con CRM remoto
            $('[data-validation="cotizacion"]').validizr({
                customValidation : validations,
                notValidInputCallback : this.genericInvalidInputAction,
                validFormCallback : function( $form ){
                    var resetSelect = function( index, element ){
                        $(element)
                            .prop('selectedIndex',0)
                            .find('option').not(':first-child').remove();
                    };

                    var formData = $form.serialize();

                    ///
                    /// Se cuenta el numero de carreras enviadas
                    ///
                    var num_carreras = (function(){
                        var count = $form.find('[data-name="selector-carrera"]').filter(function(){
                                return !!$(this).val();
                            }).length;
                        return '-' + count + 'c';
                    }());

                    // path GTM
                    var path = $form.parents('[data-gtm-tag]').data('gtm-tag');
                    var adwords_type = $form.parents('[data-gtm-tag]').data('adwords-type');

                    $form.addClass('sending');


                    $.ajax({
                        url: "/wp-admin/admin-ajax.php",
                        method: "POST",
                        data: 'action=st_front_ajax&funcion=send_postulacion&'+ formData,
                        dataType: 'json'
                    }).done(function( response ){
                        DEBUG && console.log('ajax complete');

                        // se prepara en caso de que el nonce falle
                        if( response.status === 'error' ){
                            DEBUG && console.log(response.error);
                            return;
                        }

                        var $feedback = $(response.feedback);

                        // se ingresa el feedback
                        $form.after( $feedback );

                        // se le quita la clase al formulario y se SACA del DOM
                        $form.removeClass('sending').detach();

                        // se resetean los campos de combos de carreras
                        // en caso de que se vuelva a llenar el formulario

                        // primero se resetean los selectores de jornada y de carrera
                        $form.find('[data-name="selector-jornada"], [data-name="selector-carrera"]').each(resetSelect);

                        // se resetean los selects de selecion de sede
                        $form.find('[data-name="selector-sede"]').prop('selectedIndex',0);

                        // se quitan todas las clases de validacion
                        // y los dataset de validez
                        $form.find('input:not([type="submit"]), select, textarea').removeClass('invalid-input valid-input').data('input_validity', undefined).removeAttr('data-input-validity');

                        // se maneja el boton para voler al formulario
                        $feedback.find('#backToForm').on('click', function(e){
                            $feedback.after( $form );
                            $feedback.remove();

                            // Se resetea al paso uno
                            $form.find('fieldset')
                                .removeClass('current')
                                .filter('[data-index="0"]')
                                .addClass('current');

                            $('.complex-form-progress-holder .progress')
                                .removeClass('current')
                                .filter('[data-index="0"]')
                                .addClass('current');

                            DEBUG && console.log('Form Reset!');
                        });

                        if( response.status === 'crm_error' ){
                            dataLayer.push({
                                'event' : 'VirtualPageview',
                                'virtualPageURL' : '/' + path + '/error/',
                                'virtualPageTitle' : 'cotizacion error'
                            });
                            DEBUG && console.log('Hubo un error a nivel de CRM');
                            return;
                        }


                        // se envia la pagina virtual a GTML
                        if( dataLayer ){
                            var gtm_args = {
                                    'event' : 'VirtualPageview',
                                    'virtualPageURL' : '/' + path + '/exito'+ num_carreras +'/',
                                    'virtualPageTitle' : 'cotizacion exito'
                                };

                            dataLayer.push(gtm_args);
                            DEBUG && console.log('¡Exito!', gtm_args);
                        }

                        // despues de la pagina dinamia se colocan el resto de los eventos de conversion

                        // FBEvents
                        if( typeof fbq === 'function' ){
                            console.log('FBevents Exec');
                            fbq('track', 'CompleteRegistration');
                        }

                        // Adwords
                        if( typeof window.google_trackConversion === 'function' ){
                            var conv_label = '';

                            switch(path){
                                // header
                                case 'cotizacion':
                                    conv_label = 'sOYZCO-numoQ-LbWrAM';
                                break;

                                // home
                                case 'cotizacion-home':
                                    conv_label = 'PWQuCM6PtmoQ-LbWrAM';
                                break;

                                // landings
                                case 'formulario-de-cotizacion':
                                    if( adwords_type === 'vespertino' ){
                                        conv_label = 'OHakCOnboWoQ-LbWrAM';
                                    }
                                    else {
                                        conv_label = 'QRbZCOujtmoQ-LbWrAM';
                                    }
                                break;
                            }

                            console.log('Google Adwords Exec');
                            window.google_trackConversion({
                                google_conversion_id: 898997112,
                                google_conversion_language: "en",
                                google_conversion_format: "3",
                                google_conversion_color: "ffffff",
                                google_conversion_label: conv_label,
                                google_remarketing_only: false
                            });
                        }
                    });
                }
            })
            .find('.complex-form-step')
            .on('focus.st', 'input, select', app.formStepFocus);
        },

        handleMobileTables : function(){
            $('.page-content table').each(function(i, table){
                $(table).wrap('<div class="regular-content-table-holder"></div>');
            });
        },

        handleDataTable : function( $table ){
            var dataTable = $table.DataTable({
                    searching : true,
                    ordering : false,
                    lengthChange : false,
                    pageLength : 10,
                    pagingType : 'numbers',
                    language : {
                        url          : "//cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json",
                        info         : 'Mostrando página _PAGE_ de _PAGES_',
                        infoFiltered : 'Filtrados de _MAX_ entradas',
                        paginate: {
                            first:    '',
                            previous: 'Anterior',
                            next:     'Siguiente',
                            last:     ''
                        },
                        aria: {
                            paginate: {
                                first:    'Primera',
                                previous: 'Anterior',
                                next:     'Siguiente',
                                last:     'Última'
                            }
                        }
                    }
                });

            dataTable.columns().flatten().each( function ( col_index ) {
                // los filtros son solo para las primeras 4 columnas
                if( col_index > 3 ){ return false; }

                // busco el select correspondiente al filtro
                var $select = $('[data-col-filter="'+ col_index +'"]');

                // eventHandler para generar el filtro
                $select.on('change', function(){
                    dataTable
                        .column( col_index )
                        .search( $(this).val() )
                        .draw();
                });
            });
        },

        handleSortableTable : function( $table ){
            var dataTable = $table.DataTable({
                paging: false

            });
        },

        setLightBox : function( classes ){
            /// se crean los elementos
            var $bg = $('<div />').attr({ id : 'lightbox-background', class : 'lightbox-background' }),
                $scrollable = $('<div />').attr({ class : 'lightbox-scrollable-holder' }),
                $holder = $('<div />').attr({ class : 'lighbox-holder' }).append('<div class="lightbox-close-holder"></div>'),
                $content = $('<div />').attr({ class : 'lightbox-content' }),
                $closeBtn = $('<button class="button secundario tiny" >Cerrar</button>');

            // se inicia la promesa
            var promise = new $.Deferred();

            if( classes ){
                $holder.addClass( classes );
            }

            $closeBtn.on('click', this.closeLightBox);
            $window.on('keyup.lightbox', this.closeLightBox);

            $holder.appendTo( $scrollable ).find('.lightbox-close-holder').append( $closeBtn );

            $body.append( $bg );

            $bg.animate({ opacity : 1 }).promise().then(function(){
                $body.css('overflow', 'hidden');
                $bg.append( $scrollable );
                $holder.append( $content );
                promise.resolve( $bg, $content );
            });

            return promise;
        },

        closeLightBox : function( e ){
            if( e.type === 'click' || (e.type === 'keyup' && e.keyCode == 27) ){
                $('#lightbox-background').remove();
                $body.css('overflow', 'auto');
                $window.off('keyup.lightbox keyup.singleSlider');
            }
        },

        getShareCount : function( $elements ){
            $elements.each(function(index, element){
                var type = element.getAttribute('data-type'),
                    url = element.getAttribute('data-url') || window.location.href,
                    jsonUrl = '',
                    data = {};

                var params = {
                    nolog: true,
                    id: url,
                    source: "widget",
                    userId: "@viewer",
                    groupId: "@self"
                };

                if( type === 'facebook' ){
                    jsonUrl = 'http://graph.facebook.com/';
                    data.id = url;
                }
                else if( type === 'twitter' ){
                    jsonUrl = 'http://cdn.api.twitter.com/1/urls/count.json';
                    data.url = url;
                }
                else if( type === 'linkedin' ){
                    jsonUrl = 'http://www.linkedin.com/countserv/count/share';
                    data.url = url;
                }

                $.ajax({
                    method : 'GET',
                    url : jsonUrl,
                    data : data,
                    dataType : 'jsonp'
                }).then(function( response ){
                    var count = '';

                    // se saca el valor de cada red segun lo que responda el API correspondiente
                    if( type === 'facebook' ){ count = response.shares; }
                    else if( type === 'twitter' ){ count = response.count; }
                    else if( type === 'linkedin' ){ count = response.count; }

                    // prevencion de error en caso de false o undefined
                    count = count ? count : 0;
                    element.textContent = count;
                });
            });
        },

        handleMaps : function( $boxes ){
            $boxes.ninjaMap();
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Modulos
        ///////////////////////////////////////////////////////////
        singleSlider : function( $elements ){
            /// primero revisamos la dependencia en ninjaSlider
            if( typeof window.NinjaSlider === 'undefined' || typeof $.fn.owlCarousel === 'undefined' ){
                this.debug('Falta ninjaSlider');
                this.debug('Falta owlCarousel');
                return false;
            }

            var app = this;

            $elements.each(function(i, module){
                var $module = $(module),
                    $slider = $module.find('[data-role="slider"]'),
                    $arrows = $module.find('[data-role="single-slider-arrow"]'),
                    $thumbnailsHolder = $module.find('[data-role="thumbnails-holder"]'),
                    $thumbnailArrows = $module.find('[data-role="single-slider-thumbnail-arrow"]'),
                    $thumbnails = $module.find('[data-role="single-slider-thumbnail"]'),
                    slider, carousel;


                // se inicializa el carousel de los thumbnails-holder
                carousel = $thumbnailsHolder.owlCarousel({
                    items : 6,
                    itemsDesktop : [1199,4],
                    itemsDesktopSmall : [980,4],
                    itemsTablet: [768,3],
                    itemsMobile : [320,2],
                }).data('owlCarousel');

                // se inicializa el slider principal
                slider = $slider.ninjaSlider({
                    auto : false,
                    transitionCallback : function(index, activeSlide, container){
                        var $slide = $(activeSlide);
                        $slide.siblings().removeClass('active');
                        $slide.addClass('active');

                        $thumbnails.removeClass('active').filter('[data-target="'+ index +'"]').addClass('active');
                        carousel.goTo( index );
                    }
                }).data('ninjaSlider');

                // se delegan las flechas principales
                $arrows.on('click.singleSlider', function(e){
                    // this es el boton
                    e.preventDefault();

                    var direction = this.getAttribute('data-direction');
                    slider[ direction ]();
                });

                // se delegan los thumbnails para que actuen sobre el slider principal
                $thumbnails.on('click.singleSlider', function(e){
                    // this es el boton
                    e.preventDefault();

                    var target = parseInt( this.getAttribute('data-target') );
                    slider.slide( target );
                });

                // se deben setear controles de los thumbnails
                $thumbnailArrows.on('click.singleSlider', function(e){
                    // this es el boton
                    e.preventDefault();

                    var direction = this.getAttribute('data-direction');
                    carousel[ direction ]();
                });

                // solo se deben delegar las teclas si hay un solo slider
                if( $elements.length === 1 ){
                    $window.on('keyup.singleSlider', function( e ){
                        if( e.keyCode == 39 ){ slider.next(); }
                        else if( e.keyCode == 37 ){ slider.prev(); }
                    });
                }
            });
        },

        indexSlider : function( $element ){
            /// primero revisamos la dependencia en ninjaSlider
            if( typeof window.NinjaSlider === 'undefined' ){
                this.debug('Falta ninjaSlider');
                return false;
            }

            var $bullets = $element.find('[data-role="bullets"]').children(),
                slider;

            // se inicializa el slider principal
            slider = $element.ninjaSlider({
                auto : 6000,
                transitionCallback : function(index, activeSlide, container){
                    var $slide = $(activeSlide);
                    $slide.siblings().removeClass('current');
                    $slide.addClass('current');

                    $bullets.removeClass('current').filter('[data-target="'+ index +'"]').addClass('current');
                }
            }).data('ninjaSlider');


            // se delegan los thumbnails para que actuen sobre el slider principal
            $bullets.on('click.singleSlider', function(e){
                // this es el boton
                e.preventDefault();

                var target = parseInt( this.getAttribute('data-target') );
                slider.slide( target );
            });
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Delegaciones directas
        ///////////////////////////////////////////////////////////
        formStepFocus : function( event ){
            var $current = $(event.currentTarget).parents('fieldset'),
                $fieldsets = $current.parents('form').find('.complex-form-step');
            $fieldsets.removeClass('current');
            $current.addClass('current');

            $('.complex-form-progress-holder .progress')
                .removeClass('current')
                .filter('[data-index="'+ $current.data('index') +'"]')
                .addClass('current');
        },

        deployCareerCombo : function( event ){
            event.preventDefault();

            var $btn = $(event.currentTarget),
                $combo = $btn.parents('.career-combo');

            $combo.siblings().removeClass('deployed');
            $combo.toggleClass('deployed');

            // se re-equalizan las alturas para que no se rompa el diseno
            $combo.parents('fieldset[data-equalize="children"]').equalizeChildrenHeights(false, VERTICAL_TABLETS_DOWN);
        },
        addRemoveCareerComboPrev : function(event){
          event.preventDefault();
          $(event.currentTarget).next().trigger("click");
        },
        addRemoveCareerCombo : function( event ){
            event.preventDefault();

            var $btn = $(event.currentTarget),
                $combo = $btn.parents('.career-combo'),
                combo_count = $combo.data('count');

            // $combo.siblings().removeClass('deployed');

            if( $combo.data('added') ){
                var $next = $combo.next();

                if( $next.length && $next.hasClass('added') ){
                    var $nextSelects = $next.find('select'),
                        fieldData = this.copySelectData( $nextSelects );

                    // reseteo el combo que sigue
                    $next.removeClass('deployed added').data('added', false);
                    $nextSelects
                    .prop('required', false).attr('required', false)
                    .each(function(i, field){
                        var $select = $(field);
                        $select.prop('selectedIndex',0);
                        // $select.find('option[value!=""]').remove();
                    });

                    // copio la informacion del combo que sigue en este
                    $combo.find('select')
                    .prop('required', true).attr('required', true)
                    .each(function(i, select){
                        $(select)
                            .html( fieldData[i].find('option') )
                            .prop('selectedIndex', fieldData[i].data('selected') );
                    });

                    // $combo.siblings().removeClass('deployed');
                    $combo.addClass('deployed');
                }
                else {
                    $combo.removeClass('deployed added').data('added', false);
                    $combo.find('select')
                    .prop('required', false).attr('required', false)
                    .each(function(i, field){
                        var $select = $(field);
                        $select.prop('selectedIndex',0);
                        // $select.find('option[value!=""]').remove();
                    });
                }

                track({
                    event : 'carrera '+ combo_count,
                    eventCategory : 'ocultar-carrera' + combo_count,
                    eventAction : 'clic',
                    eventLabel : 'btn-ocultar-carrera' + combo_count
                });

                // como se convierte en boton "desplegar" se quita la clase gtm_ocultar_carrera
                // y se agrega la clase gtm_desplegar_carrera
                $btn.removeClass('gtm_ocultar_carrera').addClass('gtm_desplegar_carrera');
                $btn.prev().text("AGREGAR OTRA CARRERA") || $btn.text("AGREGAR OTRA CARRERA") ;
            }
            else {
                $combo.addClass('deployed added').data('added', true);
                $combo.find('select').prop('required', true).attr('required', true);

                track({
                    event : 'carrera '+ combo_count,
                    eventCategory : 'desplegar-carrera' + combo_count,
                    eventAction : 'clic',
                    eventLabel : 'btn-desplegar-carrera' + combo_count
                });

                // como se convierte en boton "cerrar" se quita la clase gtm_desplegar_carrera
                // y se agrega la clase gtm_ocultar_carrera
                $btn.removeClass('gtm_desplegar_carrera').addClass('gtm_ocultar_carrera');
                $btn.prev().text("ELIMINAR CARRERA") || $btn.text("ELIMINAR CARRERA");
            }

            // se re-equalizan las alturas para que no se rompa el diseno
            $combo.parents('fieldset[data-equalize="children"]').equalizeChildrenHeights(false, VERTICAL_TABLETS_DOWN);
        },

        formControl : function( event ){
            event.preventDefault();

            var $btn = $(event.currentTarget),
                direction = $btn.data('direction'),
                $form = $btn.parents('form'),
                $fieldsets = $form.find('.complex-form-step'),
                $currentFieldset = $fieldsets.filter('.current'),
                currentIndex = $currentFieldset.data('index'),
                targetIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;

            if( direction === 'next' ){
                //// primero forzamos la validacion de los campos dentro del fielset
                var validizr = $form.data('validizr');

                $currentFieldset.find( validizr.fieldsSelector ).trigger('validate.validizr');
                if( !validizr.isFormValid( $currentFieldset ) ){
                    DEBUG && console.log('hay campos invalidos');
                    return;
                }

                // se envia un evento para que se capture en el script que
                // maneja el formulario
                // solo en el primer paso
                if( $currentFieldset.data('index') === 0 ){
                    var claveAjax = $form.find('input[name="claveAjax"]').val(),
                        datosFieldset = {};

                    // se convierten los campos del fieldset en un objeto
                    // para enviar a traves del evento
                    $currentFieldset.find( validizr.fieldsSelector ).each(function(index, input){
                        datosFieldset[ input.name ] = $(input).val();
                    });

                    $window.trigger('validarUsuario', [claveAjax, datosFieldset, $currentFieldset]);
                }
            }

            if( ! $fieldsets.filter('[data-index="'+ targetIndex +'"]').length ){
                return false;
            }

            $fieldsets
                .removeClass('current')
                .filter('[data-index="'+ targetIndex +'"]')
                .addClass('current');

            $('.complex-form-progress-holder .progress')
                .removeClass('current')
                .filter('[data-index="'+ targetIndex +'"]')
                .addClass('current');

            // if( $btn.parents('[data-override-eq="true"]').length ){ return; }

            // throttle(function(){
            //     $('html, body').animate({
            //         scrollTop : $fieldsets.filter('.current').offset().top
            //     });
            // });


            // se envia la pagina virtual a GTML
            if( dataLayer ){
                var path = $form.parents('[data-gtm-tag]').data('gtm-tag'),
                    gtm_args = {
                        'event' : 'VirtualPageview',
                        'virtualPageURL' : '/' + path + '/paso' + (currentIndex+1),
                        'virtualPageTitle' : 'cotizacion paso ' + (currentIndex+1)
                    };

                dataLayer.push(gtm_args);
                console.log(gtm_args);
                //DEBUG && console.log('pasoooo', gtm_args);
            }
        },

        filterSearchResults : function( event ){
            var $input = $(event.currentTarget),
                $resultsItems = $('[data-role="results-box"]').find('li'),
                pattern = new RegExp( normalize( $input.val().toLowerCase() ) );

            $resultsItems.each(function( index, item ){
                var title = item.getAttribute('data-value');

                if( title.match(pattern) ){
                    $(item).removeClass('hidden');
                }
                else {
                    $(item).addClass('hidden');
                }
            });
        },

        specialFormFilter : function( event ){
            var $tabla = $('[data-role="filtered-table"]'),
                data = $(event.currentTarget).parents('form').serializeArray();

            // primero se resetean todos los valores
            $tabla.find('tr').removeClass('hidden').addClass('visible');

            data.forEach(function( filter ){
                // si el filtro no tiene valor entonces no filtra nada
                if( !filter.value ){ return; }

                // se buscan todos los tr que contengan algo dintinto al filtro y se ocultan
                $tabla.find('tr:has([data-col="'+ filter.name +'"][data-value!="'+ filter.value +'"])').removeClass('visible').addClass('hidden');
            });

            // para asegurar que el formulario no se envie
            return false;
        },

        calendarControl : function( event ){
            event.preventDefault();

            var app = this,
                $item = $(event.currentTarget),
                direction = $item.data('direction'),
                $dataHolder = $('[data-role="calendar-data"]'),
                month = $dataHolder.data('month'),
                year = $dataHolder.data('year');

            app.calendarLoad({
                direction : direction,
                month : month,
                year : year,
                filter : $('#calendar-filter').val()
            });
        },

        toggleTarget : function( event ){
            event.preventDefault();

            // se revisa si esta limitado a un media query
            if( event.currentTarget.getAttribute('data-mq') ){
                var mqString = mqMap( event.currentTarget.getAttribute('data-mq') );

                // se revisa si entra al media query especificado
                if( mqString && !Modernizr.mq( mqString ) ){ return; }
            }

            // se selecciona a traves del atributo data-target
            $( event.currentTarget.getAttribute('data-target') ).toggleClass('deployed');

            // expansion para cuando quiero enfocar algo despues de mostrarlo
            if( event.currentTarget.getAttribute('data-focus') ){
                $( event.currentTarget.getAttribute('data-focus') ).focus();
            }
        },

        tabControl : function( event ){
            event.preventDefault();

            var $button = $(event.currentTarget),
                $target = $('[data-tab-name="'+ $button.data('target') +'"]');

            $button.siblings().removeClass('active');
            $target.siblings().removeClass('active');

            // si estoy clickeando el activo
            // en moviles se usa para deplegar el menu
            if( $button.hasClass('active') ){
                $button.parents('.tabs-controls').toggleClass('deployed');
                return;
            }

            throttle(function(){
                $button.addClass('active');
                $target.addClass('active');
                $button.parents('.tabs-controls').removeClass('deployed');
                $window.trigger('resize');
            });
        },

        deployParent : function( event ){
            event.preventDefault();

            // se revisa si esta limitado a un media query
            if( event.currentTarget.getAttribute('data-mq') ){
                var mqString = mqMap( event.currentTarget.getAttribute('data-mq') );

                // se revisa si entra al media query especificado
                if( mqString && !Modernizr.mq( mqString ) ){ return; }
            }

            $(event.currentTarget).parents( event.currentTarget.getAttribute('data-parent') ).toggleClass('deployed');

            if( typeof this.masonry !== 'undefined' ){
                this.masonry.layout();
            }
        },

        deployMainNav : function( event ){
            event.preventDefault();

            var $button = $(event.currentTarget),
                $mainNav = $('#main-nav');

            if( $button.is('.deployed') ){
                $button.removeClass('deployed');
                $mainNav.removeClass('deployed').css({
                    'max-height' : 0
                });

                $('#main-header').off('touchmove', this.blockScroll);

                document.body.style.overflow = 'auto';
                document.body.style.pointerEvents = 'auto';
            }
            else {
                $button.addClass('deployed');
                $mainNav.addClass('deployed');

                // la navegacion no deberia ser mas grande que la pantalla ofreciendo un scroll
                var windowHeight = $window.height();
                var headerHeight = $('#main-header').height();

                $('#main-header').css({
                    'pointer-events' : 'auto'
                }).on('touchmove', this.blockScroll);

                $mainNav.css({
                    'max-height' : windowHeight - headerHeight,
                    'pointer-events' : 'auto'
                });

                /// ponemos la clase una vez que se termina la transicion css
                $mainNav.one('webkitTransitionend transitionend', function(){
                    $mainNav.addClass('deployed');
                    document.body.style.overflow = 'hidden';
                    document.body.style.pointerEvents = 'none';
                });
            }
        },

        deployHeaderForm : function( event ){
            event.preventDefault();

            // selecciona los botones que tienen esta funcion
            var $deployers = $('[data-func="deployHeaderForm"]');

            // selecciona el contenedor del formulario
            var $formHolder = $('[data-role="header-form"]');

            // se saca la altura actual del header
            var boxOffset = $formHolder.offset().top;
            var scroll = $window.scrollTop();

            boxOffset = boxOffset - scroll;

            $deployers.toggleClass('deployed');

            if( $formHolder.hasClass('deployed') ){
                $('html, body').css({'overflow': 'auto','height': 'auto' });
                $formHolder.removeClass('deployed').css({ 'max-height' : 0 });
                $('#main-content, #main-footer').removeClass('overlay');
            }
            else {
              $('html, body').css({'overflow': 'hidden','height': '100%'});
                $formHolder.addClass('deployed').css({
                    'max-height' : $window.height() - boxOffset
                });

                $('#main-content, #main-footer').addClass('overlay');
            }
        },

        showShortUrl : function( event ){
            event.preventDefault();
            event.stopPropagation();

            var self = this,
                $item = $(event.currentTarget),
                shortUrl = $item.data('link') || $('link[rel="shortlink"]').attr('href') || window.location.href,
                urlInput = $('<input class="tooltip-data-input" type="text" name="short-url" value="'+ shortUrl +'" readonly>').get(0),
                $tooltip = $('<div />').attr({
                    'id' : 'short-url-tooltip-object',
                    'class' : 'regular-tooltip short-url'
                }).append( urlInput ),
                position = $item.offset(),
                unloadFunc = function( e ){
                    $('#short-url-tooltip-object').remove();
                    $(this).off('click.tooltip');
                };

            // primero se saca cualquiera que actualmente se este mostrando
            $('#short-url-tooltip-object').remove();

            // se setean las propiedades y se adjunta al body
            $tooltip.appendTo('body').css({
                'position' : 'absolute',
                'top' : position.top - $tooltip.outerHeight() - 20,
                'left' : position.left - $tooltip.outerWidth() + $item.outerWidth(),
                'opacity' : 1
            }).on('click', function(e){
                e.stopPropagation();
            });

            urlInput.setSelectionRange(0, urlInput.value.length);

            $('body').on('click.tooltip', unloadFunc);
        },

        printPage : function( event ){
            event.preventDefault();
            window.print();
        },

        expandFootNote : function( event ){
            event.preventDefault();
            $( event.currentTarget ).toggleClass('expanded');
        },

        inputControl : function( event ){
            var $item = $(event.currentTarget);

            if( ($item.is('[type="radio"]') && $item.is(':checked')) || $item.is('select') ){
                $('[data-role="'+ $item.data('group') +'"]')
                    .removeClass('active')
                    .find('input, select, textarea')
                    .removeAttr('required');

                $('[data-role="'+ $item.data('group') +'"][data-name="'+ $item.val() +'"]')
                    .addClass('active')
                    .find('input, select, textarea')
                    .not('[data-notrequired]')
                    .attr('required', true);
            }
        },

        goToTop : function( event ){
            event.preventDefault();
            $('html, body').animate({scrollTop : 0},800);
        },

        scrollToTarget : function( event ){
            event.preventDefault();

            var $item = $(event.currentTarget),
                target = $item.attr('href') || $item.data('target');

            if( !$(target).length ){ return; }

            $('html, body').animate({
                scrollTop : $(target).offset().top
            });
        },

        clickTo : function( event ){
            event.preventDefault();
            $(event.currentTarget.getAttribute('data-target')).trigger('click');
        },

        // sello st
        selloControl : function( event ){
            event.preventDefault();

            var $btn = $(event.currentTarget),
                $items = $('[data-role="sello-items"]');

            $items.removeClass('valoramos exigimos apoyamos');

            setTimeout(function(){
                $items.addClass( $btn.data('id') );
            }, 500);
        },

        // lightbox de galerias en paginas vive santo tomas
        showGallery : function( event ){
            event.preventDefault();

            var pid = event.currentTarget.getAttribute('data-pid'),
                index = event.currentTarget.getAttribute('data-index');

            var lightbox_promise = this.setLightBox('gallery-detail'),
                ajax_promise = $.get('/wp-json/st-rest/galeria/' + pid + '/' + index);

            $.when(lightbox_promise, ajax_promise).then(function( lightbox_info, ajax_response ){
                var $lightbox_bg = lightbox_info[0],
                    $lightbox_content = lightbox_info[1],
                    response = ajax_response[0].html;

                $lightbox_content.append( response );

                if( $lightbox_content.find('[data-role="single-slider-module"]').length ){
                    app.singleSlider( $lightbox_content.find('[data-role="single-slider-module"]') );
                }

                throttle(function(){
                    $lightbox_bg.addClass('loaded');
                });
            }).fail(function(){
                app.debug('fallo algo en el ajax');
                app.closeLightBox();
            });
        },

        // en paginas vive santo tomas
        // muestra el tab del formulario y preselcciona el item clickeado
        setInscriptionForm : function( event ){
            event.preventDefault();
            var selected     = $(event.currentTarget).parents('.event-info').find('[data-id-event]').data('id-event');
            var typeSelected = $(event.currentTarget).parents('.event-info').find('[data-id_type_event]').data('id_type_event');

            // hace aparecer el tab
            $('#form-tab-btn').trigger('click');

            // selecciona el valor selccionado en el [data-role="dynamic-select"]
            var $selected_option = $('[data-role="dynamic-select"]').find('option[value="'+ selected +'"]');

            $selected_option.prop('selected', true);
            $('[data-role="dynamic-select"]').prop('selectedIndex', $selected_option.index());

            $('input[name="id_tipo_evento"]').remove();

            var inputHiddenTypeEvent  = '<input type="hidden" name="id_tipo_evento" value="'+typeSelected+'">';

            if( typeSelected ) {
                $('.regular-form').append(inputHiddenTypeEvent);
            }

        },

        appendInputHidden : function( event ){
            var optionObj      = $(event.currentTarget).find('option:selected');
            var valueTypeEvent = optionObj.attr('data-id_type_event');

            $('input[name="id_tipo_evento"]').remove();

            var inputHiddenTypeEvent = '';

            if( valueTypeEvent ) {
                inputHiddenTypeEvent  = '<input type="hidden" name="id_tipo_evento" value="'+valueTypeEvent+'">';
                $('.regular-form').append(inputHiddenTypeEvent);
            }
        },

        preventPaste : function( event ) {
            event.preventDefault();
        }

    };

    var app = new App();

    $document.ready(function(){ app.onReady && app.onReady(); });

    $window.on({
        'load' : function(){ app.onLoad && app.onLoad(); },
        'resize' : function(){ app.onResize && app.onResize(); },
        'scroll' : function(){ app.onScroll && app.onScroll(); },
    });

    var $textmostrar = '+ Mostar';
    var $textocultar = '- Ocultar';
    $('.body-collapse').hide();
    $('.to-collapse').click(function(){
        $(this).siblings('.body-collapse').slideToggle(200);
        $(this).children('#collapse-btn').text(function (i, text) {
            return text === $textocultar ? $textmostrar : $textocultar;
        });
        $(this).toggleClass('malla__active');
    });

}(this, this.document, jQuery));


/////////////////////////////////////////
// Plugins y APIS
/////////////////////////////////////////
(function( window, $, undefined ){
    var $window = $(window);

    // pruebas personalizadas para modernizr
    Modernizr.addTest('device', function(){
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    });


    var unique = function( arr ) {
        var unique = [], i;

        for (i = 0; i < arr.length; i++) {
            var current = arr[i];
            if (unique.indexOf(current) < 0) { unique.push(current); }
        }
        return unique;
    };

    $.fn.svgfallback = function( callback ) {
        if( Modernizr.svg ){ return false; }

        return this.each(function() {
            this.src = this.getAttribute('data-svgfallback');
        });
    };

    $.fn.groupByAtt = function( attname ){
        var $set = this,
            groups = [],
            posibles = [];

        // se guardan todos los posibles valores
        $set.each(function(i,el){
            posibles.push( el.getAttribute(attname) );
        });

        // se quitan los elementos duplicados dejando solo los unicos
        posibles = unique( posibles );

        // se itera sobre las posibilidades y se agrupan los elementos
        posibles.forEach(function( value ){
            groups.push($set.filter('['+ attname +'="'+ value +'"]'));
        });

        return groups;
    };

    $.fn.equalizeHeights = function( dinamic, mqException ){
        var items = this,
            eq_h = function( $collection ){
                var heightArray = [];

                $collection.removeClass('height-equalized').height('auto');

                if( !mqException || !Modernizr.mq(mqException) ){
                    $collection.each(function(i,e){ heightArray.push( $(e).outerHeight() ); });
                    $collection.css({ height : Math.max.apply( Math, heightArray ) }).addClass('height-equalized').attr('data-max-height', Math.max.apply( Math, heightArray ));
                }
            };

        setTimeout(function(){
            eq_h( items );
        }, 0);

        if( dinamic ) {
            $window.on('resize', function(){
                setTimeout(function(){
                    eq_h( items );
                }, 10);
            });
        }
    };

    $.fn.equalizeChildrenHeights = function( dinamic, mqException ){
        return this.each(function(i,e){
            if( $(e).parents('[data-override-eq="true"]').length ){ return; }
            $(e).children().equalizeHeights(dinamic, mqException);
        });
    };

    $.fn.equalizeTarget = function( dinamic, mqException ){
        return this.each(function( index, box ){
            $(box).find( $(box).data('eq-target') ).equalizeHeights( dinamic, mqException );
        });
    };

    $.fn.equalizeGroup = function( attname, dinamic, mqException ){
        var groups = this.groupByAtt( attname );

        groups.forEach(function( $set ){
            $set.equalizeHeights( dinamic, mqException );
        });

        return this;
    };

    $.fn.random = function() {
        var randomIndex = Math.floor(Math.random() * this.length);
        return $(this[randomIndex]);
    };
}( this, jQuery ));

/////////////////////////////////////////
// Beautiful input plugin
/////////////////////////////////////////
(function( window, $, undefined ){
    window.Beautifier = function( element, callback ){
        this.$element = $(element);
        this.fileType = this.$element.data('file-type');
        this.name = this.$element.attr('name');
        this.placeholder = this.$element.data('placeholder');
        this.$fakeInput = $('<div />').attr({
            'class' : 'beautiful-input ' + this.fileType + (this.$element.data('aditional-classes') || ''),
            'data-name' : this.name,
            'data-identifier' : this.$element.data('identifier') || 0
        }).text( this.placeholder || '' );

        this.$element.css({ 'position' : 'absolute', 'top' : '-999999em' });
        this.$element.after( this.$fakeInput );

        this.$fakeInput.on('click.beautify', { $realElement : this.$element }, function( event ){
            event.preventDefault();
            event.data.$realElement.trigger('click.beautify');
        });

        this.$element.on('change.beautify',{ $fakeInput : this.$fakeInput }, function( event ){
            if( typeof( callback ) === 'function' ){
                callback( event );
            } else {
                var value = $(event.currentTarget).val();
                value = value.replace("C:\\fakepath\\", '').replace("C:\/fakepath\/", '');

                event.data.$fakeInput.text( value ? value : $(event.currentTarget).data('placeholder') );
            }
        });
    };
    $.fn.beautify = function( callback ) {
        return this.each(function() {
            var $element = $(this);
            if ($element.data('beautify')) { return $element.data('beautify'); }
            var beautify = new window.Beautifier( this, callback );
            $element.data('beautify', beautify);
        });
    };
}( this, jQuery ));


/////////////////////////////////////////
// Carga de tipografias
/////////////////////////////////////////

var familias = [
    'Roboto+Condensed:300italic,400italic,700italic,300,400,700:latin',
    'Roboto:400,300italic,300,400italic,700,700italic:latin',
    'Oswald:400,300,700:latin'
];

if( $('body').hasClass('page-template-archivo-experiencias') || $('body').hasClass('home') ){
    familias.push('PT+Serif:400,700:latin');
}


WebFontConfig = {
    google: { families: familias }
};

(function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = true;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();
