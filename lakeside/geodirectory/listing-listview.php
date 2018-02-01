<?php
/**
 * Template for the list of places
 *
 * This is used mostly on the listing (category) pages and outputs the actual grid or list of listings.
 * See the link below for info on how to replace the template in your theme.
 *
 * @link http://docs.wpgeodirectory.com/customizing-geodirectory-templates/
 * @since 1.0.0
 * @package GeoDirectory
 * @global object $wpdb WordPress Database object.
 * @global object $post The current post object.
 * @global object $wp_query WordPress Query object.
 * @global string $gridview_columns The girdview style of the listings.
 * @global object $gd_session GeoDirectory Session object.
 */

/**
 * Called before the listing template used to list listing of places.
 *
 * This is used anywhere you see a list of listings.
 *
 * @since 1.0.0
 */
do_action('geodir_before_listing_listview');

global $gridview_columns, $gd_session, $related_nearest, $related_parent_lat, $related_parent_lon;

/**
 * Filter the default grid view class.
 *
 * This can be used to filter the default grid view class but can be overridden by a user $_SESSION.
 *
 * @since 1.0.0
 * @param string $gridview_columns The grid view class, can be '', 'gridview_onehalf', 'gridview_onethird', 'gridview_onefourth' or 'gridview_onefifth'.
 */
$grid_view_class = apply_filters('geodir_grid_view_widget_columns', $gridview_columns);
if ($gd_session->get('gd_listing_view') && !isset($before_widget) && !isset($related_posts)) {
	$grid_view_class = geodir_convert_listing_view_class($gd_session->get('gd_listing_view'));
}
?>

    <ul class="geodir_category_list_view clearfix <?php echo apply_filters('geodir_listing_listview_ul_extra_class', '', 'listing'); ?>">

        <?php if (have_posts()) :

            /**
             * Called inside the `ul` of the listings template, but before any `li` elements.
             *
             * When used by the widget view template then it will only show if there are listings to be shown.
             *
             * @since 1.0.0
             * @see 'geodir_after_listing_post_listview'
             */
            do_action('geodir_before_listing_post_listview');

            while (have_posts()) : the_post();
                global $post, $wpdb, $preview;

                /**
                 * Add a class to the `li` element of the listings list template.
                 *
                 * @since 1.0.0
                 * @param string $class The extra class for the `li` element, default empty.
                 */
                $post_view_class = apply_filters('geodir_post_view_extra_class', '');

                /**
                 * Add a class to the `article` tag inside the `li` element on the listings list template.
                 *
                 * @since 1.0.0
                 * @param string $class The extra class for the `article` element, default empty.
                 */
                $post_view_article_class = apply_filters('geodir_post_view_article_extra_class', '');
                ?>

                <li class="clearfix <?php if ($grid_view_class) {
                    echo 'geodir-gridview ' . $grid_view_class;
                } else {
                    echo ' geodir-listview ';
                } ?> <?php if ($post_view_class) {
                    echo $post_view_class;
                } ?>" <?php if (isset($listing_width) && $listing_width) echo "style='width:{$listing_width}%;'"; // Width for widget listing

                echo " data-post-id='$post->ID' ";
                /**
                 * Called inside the `<li>` tag for listing outputs.
                 *
                 * @since 1.5.9
                 * @param object $post The post object.
                 * @param string $string If called on the listing or widget template.
                 */
                do_action('geodir_listview_inside_li', $post, 'listing');
                ?> >
                    <article class="geodir-category-listing <?php if ($post_view_article_class) {
                        echo $post_view_article_class;
                    } ?>">

                        <div class="geodir-content <?php echo apply_filters('geodir_listing_listview_content_extra_class', '', 'widget'); ?>">
                            <?php
                            /** This action is documented in geodirectory-templates/listing-listview.php */
                            do_action('geodir_before_listing_post_title', 'listview', $post); ?>
                            <header class="geodir-entry-header">
                                <h3 class="geodir-entry-title">
                                    <a href="<?php the_permalink(); ?>"
                                       title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </header>
                            <!-- .entry-header -->
                            <?php
                            /** This action is documented in geodirectory-templates/listing-listview.php */
                            do_action('geodir_after_listing_post_title', 'listview', $post); ?>
                            <?php /// Print Distance
                            if (isset($_REQUEST['sgeo_lat']) && $_REQUEST['sgeo_lat'] != '') {
                                $startPoint = array('latitude' => $_REQUEST['sgeo_lat'], 'longitude' => $_REQUEST['sgeo_lon']);

                                $endLat = $post->post_latitude;
                                $endLon = $post->post_longitude;
                                $endPoint = array('latitude' => $endLat, 'longitude' => $endLon);
                                $uom = get_option('geodir_search_dist_1');
                                $distance = geodir_calculateDistanceFromLatLong($startPoint, $endPoint, $uom);
                                ?>
                                <h3>
                                    <?php
                                    if (round($distance, 2) == 0) {
                                        $uom = get_option('geodir_search_dist_2');
                                        $distance = geodir_calculateDistanceFromLatLong($startPoint, $endPoint, $uom);
                                        if ($uom == 'feet') {
                                            $uom = __('feet', 'geodirectory');
                                        } else {
                                            $uom = __('meters', 'geodirectory');
                                        }
                                        echo round($distance) . ' ' . __($uom, 'geodirectory') . '
			<br />
			';
                                    } else {
                                        if ($uom == 'miles') {
                                            $uom = __('miles', 'geodirectory');
                                        } else {
                                            $uom = __('km', 'geodirectory');
                                        }
                                        echo round($distance, 2) . ' ' . __($uom, 'geodirectory') . '
			<br />
			';
                                    }
                                    ?>
                                </h3>
                            <?php } ?>
                            <?php
                            /** This action is documented in geodirectory-templates/listing-listview.php */
                            do_action('geodir_before_listing_post_excerpt', $post); ?>
                            <?php echo geodir_show_listing_info('listing'); ?>
                            <?php if (isset($character_count) && $character_count == '0') {
                            } else { ?>
                                <div class="geodir-entry-content">
                                    <?php
                                    /**
                                     * Filter to hide the listing excerpt
                                     *
                                     * @since 1.5.3
                                     * @param bool $display Display the excerpt or not. Default true.
                                     * @param object $post The post object.
                                     */
                                    $post_ID = $post->ID;
                                    $lot_number = geodir_get_post_meta( $post_ID, 'geodir_lot_number', true );
                                    $lot_address = geodir_get_post_meta( $post_ID, 'post_address', true );
                                    $lot_city = geodir_get_post_meta( $post_ID, 'post_city', true );
                                    $lot_state = geodir_get_post_meta( $post_ID, 'post_region', true );
                                    $lot_zip = geodir_get_post_meta( $post_ID, 'post_zip', true );
                                    $lot_phone = geodir_get_post_meta( $post_ID, 'geodir_contact', true );
                                    $lot_children = geodir_get_post_meta( $post_ID, 'geodir_children', true );
                                    ?>
                                    <p class="address">
                                      Lot <?php echo $lot_number; ?><br />
                                      <?php echo $lot_address; ?><br />
                                      <?php echo $lot_city;?>, <?php echo $lot_state; ?> <?php echo $lot_zip; ?><br />
                                    </p>
                                    <?php
                                    $show_listing_excerpt = apply_filters('geodir_show_listing_post_excerpt', true, 'widget', $post);
                                    if ($show_listing_excerpt) {
                                        if ( isset( $character_count ) && ( $character_count || $character_count == '0' ) ) {
                                            $content_out = geodir_max_excerpt( $character_count );
                                        } else {
                                            $content_out = get_the_excerpt();
                                        }
                                        if ( ! empty( $content_out ) ) {
                                            echo "<p>" . $content_out . "</p>";
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php
                            /** This action is documented in geodirectory-templates/listing-listview.php */
                            do_action('geodir_after_listing_post_excerpt', $post); ?>
                        </div>
                        <!-- gd-content ends here-->
                        <?php
                        /**
                         * Called after printing listing content.
                         *
                         * @since 1.5.3
                         * @param object $post The post object.
                         * @param string $view The view type, default 'widget'.
                         */
                        do_action( 'geodir_after_listing_content', $post, 'widget' ); ?>
                        <footer class="geodir-entry-meta <?php echo apply_filters('geodir_listing_listview_meta_extra_class', '', 'widget'); ?>">
                            <div class="geodir-addinfo clearfix <?php echo apply_filters('geodir_listing_listview_addinfo_extra_class', '', 'widget'); ?>">
                                <?php
                                /**
                                 * Called before printing review stars html.
                                 *
                                 * @since 1.5.3
                                 * @param object $post The post object.
                                 * @param string $view The view type, default 'widget'.
                                 */
                                do_action( 'geodir_before_review_html', $post, 'widget' );



                                /**
                                 * Called after printing favorite html.
                                 *
                                 * @since 1.0.0
                                 */
                                // do_action( 'geodir_after_favorite_html', $post->ID, 'widget' );
                                ?>
                                <strong>Phone: </strong><br /><?php echo $lot_phone; ?><br />
                                <strong>Children</strong><br />
                                <?php echo $lot_children; ?>
                              <?php


                                if ($post->post_author == get_current_user_id()) {
                                    $addplacelink = get_permalink(geodir_add_listing_page_id());
                                    $editlink = geodir_getlink($addplacelink, array('pid' => $post->ID), false);
                                    $upgradelink = geodir_getlink($editlink, array('upgrade' => '1'), false);

                                    $ajaxlink = geodir_get_ajax_url();
                                    $deletelink = geodir_getlink($ajaxlink, array('geodir_ajax' => 'add_listing', 'ajax_action' => 'delete', 'pid' => $post->ID), false);
                                    ?>
                                    <span class="geodir-authorlink clearfix">
                                <?php
                if (isset($_REQUEST['geodir_dashbord']) && $_REQUEST['geodir_dashbord']) {
                    /** This action is documented in geodirectory-templates/listing-listview.php */
                    do_action('geodir_before_edit_post_link_on_listing');
                    ?>
                    <a href="<?php echo esc_url($editlink); ?>" class="geodir-edit"
                       title="<?php _e('Edit Listing', 'geodirectory'); ?>">
                        <?php
                        $geodir_listing_edit_icon = apply_filters('geodir_listing_edit_icon', 'fa fa-edit');
                        echo '<i class="'. $geodir_listing_edit_icon .'"></i>';
                        ?>
                        <?php _e('Edit', 'geodirectory'); ?>
                    </a>
                    <a href="<?php echo esc_url($deletelink); ?>" class="geodir-delete"
                       title="<?php _e('Delete Listing', 'geodirectory'); ?>">
                        <?php
                        $geodir_listing_delete_icon = apply_filters('geodir_listing_delete_icon', 'fa fa-close');
                        echo '<i class="'. $geodir_listing_delete_icon .'"></i>';
                        ?>
                        <?php _e('Delete', 'geodirectory'); ?>
                    </a>
                    <?php
                    /** This action is documented in geodirectory-templates/listing-listview.php */
                    do_action('geodir_after_edit_post_link_on_listing');
                } ?>
					</span>
                                <?php } ?>
                            </div>
                            <!-- geodir-addinfo ends here-->
                        </footer>
                        <!-- .entry-meta -->
                    </article>
                </li>

            <?php
            endwhile;

            /**
             * Called inside the `ul` of the listings template, but after all `li` elements.
             *
             * When used by the widget view template then it will only show if there are listings to be shown.
             *
             * @since 1.0.0
             * @see 'geodir_before_listing_post_listview'
             */
            do_action('geodir_after_listing_post_listview');

        else:
			$favorite = isset($_REQUEST['list']) && $_REQUEST['list'] == 'favourite' ? true : false;

			/**
             * Called inside the `ul` of the listings template, when no listing found.
             *
             * @since 1.5.5
			 * @param string 'listing-listview' Listing listview template.
			 * @param bool $favorite Are favorite listings results?
             */
            do_action('geodir_message_not_found_on_listing', 'listing-listview', $favorite);
        endif;

        ?>
    </ul>  <!-- geodir_category_list_view ends here-->

    <div class="clear"></div>
<?php
/**
 * Called after the listings list view template, after all the wrapper at the very end.
 *
 * @since 1.0.0
 */
do_action('geodir_after_listing_listview');
