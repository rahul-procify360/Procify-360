( function( $ ) {

	function regenerating_css() {

		$('.regenerating_css_js').on( 'click', function(e) {
			e.preventDefault();

			$(".regenerating_css_js img").addClass('active');
			let info = {
				action: 'regenerating_css_js',
			};

			$.ajax({
				url: 	  get.ajaxurl,
				type: 	  'POST',
				dataType: 'json',
				data: 	  info,
				success: function (data) {
					console.log('success');
					$(".regenerating_css_js img").removeClass('active');
					$("span.result").text('Done');
				},
				error: function (data) {
					$(".regenerating_css_js img").removeClass('active');
					console.log('error');
					console.log(data);
				},
			});

            window.location.reload();

		})
	}

	regenerating_css();

}( jQuery ) );
