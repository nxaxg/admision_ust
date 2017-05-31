(function(window, document, $){
    var $window = $(window);

    var LandingSlider = function( container ){
        this.$container = $(container);
        this.$list = this.$container.find('[data-role="landing-slider-list"]');
        this.$items = this.$list.children();
        this.$arrows = this.$container.find('[data-role="landing-slider-btn"]');
        this.$bullets = this.$container.find('[data-role="landing-slider-bullet"]');

        this.init();
    };

    /////// prototipo
    LandingSlider.prototype = {
        init : function(){
            this.activeSlide = 0;
            this.$items.first().addClass('active');
            this.setup();
            this.setEvents();
        },
        reset : function(){
            this.$items.width('auto');
            this.$list.width('9999em');
        },

        setup : function(){
            ////// se calculan los espacios
            var width = this.width = this.$list.parent().width();
            this.totalItems = this.$items.length;
            this.marginWidth = parseInt( this.$items.last().css('marginLeft') );
            this.totalmarginsWidth = this.marginWidth * ( this.totalItems - 1 );

            ////// se aplcian las medidas
            
            // el ancho de los items debe ser el ancho del contenedor
            // this.$items.width( this.width );

            this.$items.each(function(i, el){
                el.style.width = width + 'px';
            });

            // el ancho de la lista debe ser la sumatoria del ancho de los items
            // this.$list.width( (this.width * this.totalItems) + this.totalmarginsWidth );
            this.$list.get(0).style.width = (width * this.totalItems) + this.totalmarginsWidth + 'px';
        },

        setEvents : function(){
            var slider = this,
                counter;

            this.$arrows.on('click.LandingSlider', function(ev){
                ev.preventDefault();

                var $arrow = $(ev.currentTarget),
                    direction = $arrow.data('direction'),
                    targetSlide = slider.activeSlide;

                if( direction === 'prev' && !slider.isFirst() ){
                    targetSlide = slider.activeSlide - 1;
                }
                else if( direction === 'next' && ! slider.isLast() ){
                    targetSlide = slider.activeSlide + 1;
                }

                slider.moveTo( targetSlide );
            });

            this.$bullets.on('click.LandingSlider', function(ev){
                ev.preventDefault();
                slider.moveTo( $(ev.currentTarget).data('target') );
            });

            $window.resize(function(){
                clearTimeout(counter);
                counter = setTimeout(function(){
                    slider.onResize();
                }, 300);
            });
        },

        onResize : function(){
            this.reset();
            this.setup();
            this.moveTo( this.activeSlide );
        },

        moveTo : function( targetSlide ){
            var targetPosition = (targetSlide * this.width) + ( this.marginWidth * targetSlide );

            this.$list.css({
                'transform' : 'translate3d('+ (targetPosition * -1) +'px,0,0)'
            });

            this.activeSlide = targetSlide;
            this.$items.removeClass('active').eq( targetSlide ).addClass('active');
            this.updateBullets( targetSlide );
        },

        updateBullets : function( targetSlide ){
            var $targetBullet = this.$bullets.removeClass('active').eq( targetSlide ),
                targetBulletPos = $targetBullet.position().left;

            $targetBullet.addClass('active');
        },

        //////// auxiliares
        isFirst : function(){
            return this.activeSlide === 0;
        },
        isLast : function(){
            return this.activeSlide === (this.totalItems - 1);
        }
    };




    jQuery.fn.landingSlider = function(){
        return this.each(function(){
            $(this).data('landingSlider', (new LandingSlider( this )));
        });
    };

}(window, document, jQuery));