(function( $ ) {
    $(function() {
        
		var rbk_menu_bar_color_options = {
			defaultColor: "#fff",
			change: function(event, ui){
				$('#rbk_mobile_logo_preview').css('background-color', event.target.value );
			},
			clear: function() {},
			hide: true,
			palettes: true
		};
        $( '#mbcolor' ).wpColorPicker(rbk_menu_bar_color_options);
        $( '#mbicolor' ).wpColorPicker(rbk_menu_bar_color_options);
         
    });

    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#rbk_mobile_logo').val(image_url);
            $('#rbk_mobile_logo_preview').html('<div id="rbk_fake_image"></div>');
            var img_el = $('<img />', { src: image_url, id: 'logo_img', style: 'display:none'});
            $('#rbk_mobile_logo_preview').append( img_el );

            // show loader to give time for image to load...

            setTimeout(function(){
            	rbk_set_image_width( img_el );
            	img_el.fadeIn();
            }, 500);
        });
    });

	// Calculate ratio
	function get_larger_number( num1, num2 ){
		if( num1 > num2 ){
			return num1;
		} else {
			return num2
		}
	}
	function get_smaller_number( num1, num2 ){
		if( num1 < num2 ){
			return num1;
		} else {
			return num2
		}
	}
	function get_image_ratio(el){
		var iw = el[0].width;
		var ih = el[0].height;
		var ln = get_larger_number( ih, iw );
		var sn = get_smaller_number( ih, iw );
		var ratio = ln/sn;
		return ratio;
	}

	function rbk_set_image_width( el ){
		var w = el[0].width;
		var h = el[0].height;
		var ratio;
		if( w > h ){
			ratio = w/h;
		} else {
			ratio = h/w;
		}
		var new_width = ratio * 46;
		$('#rbk_mobile_logo_preview img').css( 'width', new_width );
		$('#rbk_mobile_logo_preview img').fadeIn();				
	}
	if( $('#rbk_mobile_logo_preview img').length ) {
		rbk_set_image_width( $('#rbk_mobile_logo_preview img') );
	}


})( jQuery );