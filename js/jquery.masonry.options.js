jQuery(document).ready(function(){
	jQuery('#home-gallery').masonry({
	itemSelector: '.home-item',
//	columnWidth: 240,
	columnWidth: function( containerWidth ) {
		return containerWidth / 4;
	},
//	gutterWidth: 10,
	isAnimated: true,
//	isFitWidth: true,
//	isResizable: true,
	animationOptions: {
		duration: 400
	}
	});
});
