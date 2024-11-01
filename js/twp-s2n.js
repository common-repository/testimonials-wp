(function($) {
  $(document).ready( function(){
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('.profile_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function effectTestimonial( way ){
        var current = parseInt( $('#current-testimonial').val() );     
        var max =  parseInt( $('#max-testimonial').val() ); 
        var display = parseInt( $('#show-display').val() );
        var effect = $('#slide-effect').val();
        if(way == 'start'){
            $('[data-testimonial=0]')
            .css("display", "flex")
            .hide()
            .fadeIn('fast'); 
            $('[data-select=0]').addClass( 'active' );
            

        }else if(way == 'prev'){
            var prev = ( (current - 1 < 0) ? max : current - 1);
            if( effect == 'fade'){
                $('[data-testimonial=' + current + ']').fadeOut( "fast" ).promise().done( function () {
                    $('[data-testimonial=' + prev + ']')
                    .css("display", "flex")
                    .hide()
                    .fadeIn('fast');
                });
            } else if( effect == 'slide'){
                $('[data-testimonial=' + current + ']').toggle("slide", {direction:'left'}).promise().done( function () {
                    $('[data-testimonial=' + prev + ']')
                    .css("display", "flex")
                    .hide()
                    .toggle("slide", {direction:'right'});
                });    
            }
                $('[data-select]').removeClass( 'active' );
                $('[data-select=' + prev + ']').addClass( 'active' );

                $('#current-testimonial').val(prev);
            
        }else if(way == 'next'){
            var next = ( (current + 1 > max) ? 0 : current + 1);
            if( effect == 'fade'){
                $('[data-testimonial=' + current + ']').fadeOut( "fast" ).promise().done( function () {
                    $('[data-testimonial=' + next + ']')
                    .css("display", "flex")
                    .hide()
                    .fadeIn('fast');
                });   

            } else if( effect == 'slide'){
                $('[data-testimonial=' + current + ']').toggle("slide", {direction:'right'}).promise().done( function () {
                    $('[data-testimonial=' + next + ']')
                    .css("display", "flex")
                    .hide()
                    .toggle("slide", {direction:'left'});
                });    
            }
             
                $('[data-select]').removeClass( 'active' );
                $('[data-select=' + next + ']').addClass( 'active' );

                $('#current-testimonial').val(next);
            
        }
    }
    if($('.slider-select').length){
        $('.slider-select').on( 'click' , function(e){
            var current = parseInt( $('#current-testimonial').val() );
            var data_select = $(this).attr('data-select');
            var effect = $('#slide-effect').val();
            if( effect == 'fade'){
                $('[data-testimonial=' + current + ']').fadeOut( "fast" ).promise().done( function () {

                    $('[data-testimonial=' + data_select + ']')
                        .css("display", "flex")
                        .hide()
                        .fadeIn('fast');
                   
                });
            } else if( effect == 'slide'){
                if(current > data_select){
                    $('[data-testimonial=' + current + ']').toggle("slide", {direction:'right'}).promise().done( function () {
                        $('[data-testimonial=' + data_select + ']')
                        .css("display", "flex")
                        .hide()
                        .toggle("slide", {direction:'left'});
                    }); 
                }else{
                    $('[data-testimonial=' + current + ']').toggle("slide", {direction:'left'}).promise().done( function () {
                        $('[data-testimonial=' + data_select + ']')
                        .css("display", "flex")
                        .hide()
                        .toggle("slide", {direction:'right'});
                    }); 
                }

            }
            

            $('[data-select]').removeClass( 'active' );
            $('[data-select=' + data_select + ']').addClass('active');
            $('#current-testimonial').val(data_select);
        });
    }
    if($('.s2n-testimonial').length){
        effectTestimonial( 'start' );
    }
    if($('.s2n-next').length){
        $('.s2n-next').on( 'click' , function(e){
            effectTestimonial( 'next' );
        });
    }
    if($('.s2n-prev').length){
        $('.s2n-prev').on( 'click' , function(e){
            effectTestimonial( 'prev' );
        });
    }
    if($('.upload-button').length){
        $('.upload-button').on( 'click' , function(e){
            e.preventDefault();
            $('.profile_image_url').trigger('click');

        });
        $(".profile_image_url").change(function(){
            readURL(this);
        });
    }
    if($('.submit-testimonial').length){
        $('.submit-testimonial').on( 'click' , function(e){
            e.preventDefault();
            $('.s2n-rate-us').toggle('hide');
            $('.form-saving').toggle('show');
            save_testimonial();
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
        function save_testimonial(){
            var data = {
                action: 'twp_ajax_save',
                firstname: $('[name="firstname"]').val(), 
                lastname: $('[name="lastname"]').val(),
                email: $('[name="email"]').val(),
                url: $('[name="url"]').val(),
                comment: $('[name="comments"]').val(),
                rating: $('[name="star-rating"]').val(),
                image: $('.profile_image').prop('src'),
                wp_nonce: twp_save.ajax_nonce,
            };
            $.post(twp_save.ajaxurl, data, function(response) {
                var result = $.parseJSON(response);
                if( ! $.isPlainObject(result)){
                    $('.s2n-rate-us').toggle('show');
                    $('.form-saving').toggle('hide');
                    $('.form-finished').toggle('show');
                    $('.error-msg').toggle('show');
                    return false;
                }
                if( result[0] !== 'Success') {
                    $('.s2n-rate-us').toggle('show');
                    $('.form-saving').toggle('hide');
                    $('.form-finished').toggle('show');
                    $('.error-msg').toggle('show');
                    $('.error-msg p').append( result[1] );
                    return false; 
                
                }

                $('.form-saving').toggle('hide');
                $('.form-finished').toggle('show');
                $('.success-msg').toggle('show');
                return false;
                 
            });

        }
    }  
  });
})( jQuery );
