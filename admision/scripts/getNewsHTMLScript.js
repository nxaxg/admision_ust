(function(window, $){
    var getHTML_lightbox = function(){
            var $bg = $('<div />').attr({ 'id' : 'get-HTML-lightbox-bg' }),
                $lightBox = $('<div />').attr({ 'class' : 'html-lightbox' }),
                $closeBtn = $('<a />')
                                .attr({ 'class' : 'close-html-lightbox-btn' })
                                .text('Cerrar')
                                .on('click', function(e){
                                    e.preventDefault();
                                    $('#get-HTML-lightbox-bg').remove();
                                });

            return {
                bg : $bg.append( $lightBox ),
                lightbox : $lightBox.append( $closeBtn )
            };
        };

    $(function(){
        $('#get-HTML-for-news').on('click', function(event){
            event.preventDefault();

            var holder = getHTML_lightbox();

            holder.bg.height( $(window.document).height() );

            $('body').append( holder.bg );

            $.ajax({
                type: "GET",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action : 'get_news_html',
                    post_id : $('#post_ID').val()
                }
            }).then(function(permalink){
                return $.get(permalink);
            }).then(function( response ){
                var $newTextArea = $('<textarea />').attr({ 'class' : 'html-content-textarea' }).val( response );
                holder.lightbox.addClass('loaded').append( $newTextArea );
            });
        });
    });

}(this, jQuery));