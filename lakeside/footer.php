<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "wrapper" div and all content after.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
?>
<style type="text/css">
	.row.social {
		text-align: center;
    color: #fff;
    font-size: 1em;
    line-height: 1.5em;
	}
	.row.social a {
		font-size: 2.5em;
    margin-top: 1em;
	}

	.row.social h3 {
		font-size: 1.8em;
	}
</style>
</div>
			<?php do_action( 'hestia_do_footer' ); ?>


		</div>
	</div>
<?php wp_footer(); ?>

</body>
</html>
