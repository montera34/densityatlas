	jQuery(function($) {
		winwidth = $(window).width();
		if ( winwidth > 1200 ) {
			$( "#case-carousel" ).rcarousel( {visible: 4, step: 1, width: 300, height: 300, margin: 10} );
		} if ( winwidth > 768 && winwidth < 1200 ) {
			$( "#case-carousel" ).rcarousel( {visible: 3, step: 1, width: 300, height: 300, margin: 10} );
		} else {
			$( "#case-carousel" ).rcarousel( {visible: 1, step: 1, width: 300, height: 300, margin: 10, orientation: "vertical"} );
		}
		
	});

