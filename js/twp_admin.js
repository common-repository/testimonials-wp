(function($) {
    $(document).ready( function(){
        if($('.profile_upload').length){
            $('.profile_upload').click(function(e) {
                e.preventDefault();
                var custom_uploader = wp.media({
                    title: 'Custom Image',
                    button: {
                        text: 'Upload Image'
                    },
                    multiple: false
                })
                .on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('.profile_image').attr('src', attachment.url);
                    $('.profile_image_url').val( attachment.url);
                    $('#imageid').val( attachment.id);

                })
                .open();
            });
        }
        if($('.s2n_rating').length){
            
            $('.s2n_rating > i').on('mousemove',function(e) {

                var offseti = $(this).offset();
                if ((e.pageX - offseti.left) < $(this).width() / 2) {
                    $(this).prevAll().removeClass(star_half).addClass(star_full);
                    $(this).addClass(star_half).removeClass(star_empty);
                }else{
                    $(this).prevAll().addClass(star_full).removeClass(star_empty);
                    $(this).removeClass(star_half).addClass(star_full).removeClass(star_empty);
                }
                $(this).nextAll().removeClass(star_half).addClass(star_empty).removeClass(star_full);
            });
            
            $('.s2n_rating').on('mouseleave',function(e) {
                fill_stars(); 
            });
            $('.s2n_rating > i').on('click',function(e) {
                var offseti = $(this).offset();
                if ((e.pageX - offseti.left) < $(this).width() / 2) {
                    $('.star-rating').val( ( parseInt( $(this).attr('data-star') )  - 1) + '.5');
                }else{
                    $('.star-rating').val( $(this).attr('data-star') );
                }
                fill_stars();   
            });
            function fill_stars(){
                var rating = parseFloat( $('.star-rating').val() );
                if(rating === 0){
                    $( ".s2n_rating > i" ).each(function() {
                        $(this).removeClass(star_half).addClass(star_empty).removeClass(star_full)
                    });  
                }else{
                    $( ".s2n_rating > i" ).each(function() {
                        var star = parseFloat( $(this).attr('data-star') );
                        if( star <= rating){
                            $(this).removeClass(star_half).addClass(star_full).removeClass(star_empty);   
                        }else{
                            if(rating % 1 != 0 && Math.ceil( rating ) === star ){
                                $(this).removeClass(star_full).addClass(star_half).removeClass(star_empty);   
                            }else{
                                $(this).removeClass(star_half).addClass(star_empty).removeClass(star_full);   
                            }
                            
                        }   
                    });
                }
            }
        }
        
        
    });
})( jQuery );