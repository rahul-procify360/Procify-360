<?php
if ( $GLOBALS['wp_query']->max_num_pages > 1 ) :

	// Set up paginated links.
	$links = paginate_links([
		'type'      => 'array',
		'prev_text' => '<span><i class="icon ion-arrow-left-c"></i>PREV</span>',
		'next_text' => '<span>NEXT<i class="icon ion-arrow-right-c"></i></span>',
	]);
?>
<div class="blog-pagination-wrapper blog-pagination-wrapper--without-numbers">

	<div class="pagination">

		<?php
		if ( \Aheto\Helper::str_contains( 'prev page-numbers', $links[0] ) ) {
			echo $links[0];
			unset( $links[0] );
		}

		$next_link = '';
		if ( \Aheto\Helper::str_contains( 'next page-numbers', end( $links ) ) ) {
			$next_link = array_pop( $links );
		}
		?>

		<div class="wrap">
			<?php echo join( "\n", $links ); ?>
		</div>

		<?php echo $next_link; ?>

	</div>

</div>
<?php
endif;
