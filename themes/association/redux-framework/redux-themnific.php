<?php

    if ( ! class_exists( 'Redux_Framework_sample_config' ) ) {

        class Redux_Framework_sample_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                $this->initSettings();

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => esc_html__( 'Section via hook', 'association' ),
                    'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'association' ),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;', 'association' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'association' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'association' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo esc_attr($this->theme->display( 'Name' )); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( esc_html__( 'By %s', 'association' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( esc_html__( 'Version %s', 'association' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . esc_html__( 'Tags', 'association' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo esc_attr($this->theme->display( 'Description' )); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'association' ) . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes', 'association' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

               

                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => esc_html__( 'General Settings', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-cogs',
                    'fields' => array( // header end
					
					

					

                        array(
                            'id'       => 'tmnf-main-logo',
                            'type'     => 'media',
                            'preview'  => true,
                            'title'    => esc_html__( 'Main Logo', 'association' ),
                            'subtitle'     => esc_html__( 'Upload a logo for your theme.', 'association' ),
                        ),

						
						array(
                            'id'       => 'tmnf-tagline',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Site Title / Tagline','association'),
                            'subtitle' => esc_html__( 'Add any info text here.','association'),
							'default'  => esc_html__( 'Where “Caring for Our Community” matters','association'),
                            'validate' => 'html',
						),
						
                        array(
                            'id'       => 'tmnf-header-image',
                            'type'     => 'media',
                            'preview'  => true,
                            'title'    => esc_html__( 'Header image', 'association' ),
                            'subtitle'     => esc_html__( 'Upload a "header" image for pages & posts (featured image will override this image). Recommended size 1600x620px', 'association' ),
                        ),

                        array(
                            'id'       => 'tmnf-uppercase',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Uppercase Fonts', 'association' ),
                            'subtitle' => esc_html__( 'You can enable general uppercase here.', 'association' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),


					// section end
                    )
                );
				// General Settings THE END
				
				


                $this->sections[] = array(
                    'type' => 'divide',
                );




                $this->sections[] = array(
                    'title'  => esc_html__( 'Primary Styling', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end



						array(
                            'id'          => 'tmnf-body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Typography', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'body,input,textarea' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as general text.', 'association' ),
                            'default'     => array(
                                'color'       => '#3d3d3d',
                                'font-style'  => '400',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '16px',
                                'line-height' => '26px'
                            ),
                        ),

                        array(
                            'id'       => 'tmnf-background',
                            'type'     => 'background',
                            'title'    => esc_html__( 'Main Body Background', 'association' ),
                            'subtitle' => esc_html__( 'Body background with image, color, etc.', 'association' ),
                            'output'   => array('body,h2.widget span' ),
                            'default'     => array(
                                'background-color'       => '#f9f9f9',
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-ghost',
							'type'      => 'color',
							'title'     => esc_html__('Ghost Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a alternative background color (similar to Main Body Background)', 'association' ),
							'default'   => '#fff',
							'output'    => array(
								'background-color' => '.ghost,.imgwrap.ghost,ul#serinfo-nav,.widgetable ul.menu li,.page-numbers,.nav_item a,#sidebar .tab-post,input,textarea,input,select,.widgetable ul.social-menu li a',

							)
						),

                        array(
                            'id'       => 'tmnf-link-color',
                            'type'     => 'link_color',
                            'title'    => esc_html__( 'Links Color Option', 'association' ),
                            'subtitle' => esc_html__( 'Pick a link color', 'association' ),
							'output'   => array( 'a,.builder .sep a' ),
                            'default'  => array(
                                'regular' => '#222',
                                'hover'   => '#595959',
                                'active'  => '#000',
                            )
                        ),
						
                        array(
                            'id'       => 'tmnf-primary-border',
							'type'      => 'color',
							'title'     => esc_html__('Borders Color', 'association' ),
							'subtitle'  => esc_html__('Pick a color for primary borders', 'association' ),
							'default'   => '#ededed',
							'output'    => array(
								'border-color' => '.p-border,.mp-service-media img,ul.mpbox.clients .testi-inner,.entry h2,.meta,h3#reply-title,.tagcloud a,.page-numbers,input,textarea,select,.products,.nav_item a'
							)
						),
						
                        array(
                            'id'       => 'tmnf-custom-css',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Custom CSS', 'association' ),
                            'subtitle' => esc_html__( 'Quickly add some CSS to your theme by adding it to this block.', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                        ),


					// section end
                    )
                );
				// Primary styling THE END
				




                $this->sections[] = array(
                    'title'  => esc_html__( 'Header Styling', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end

						
						array(
							'id'        => 'tmnf-color-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Header Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a background color for header.', 'association' ),
							'default'   => '#fff',
							'output'    => array(
								'background-color' => '.header_inn'
							)
						),

						
						array(
                            'id'          => 'tmnf-nav-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Main Menu: Typography', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '#main-nav>li>a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as navigation text.', 'association' ),
                            'default'     => array(
                                'color'       => '#2e333d',
                                'font-weight'  => '800',
                                'font-family' => 'Raleway',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '18px'
                            ),
                        ),
						

						
						array(
							'id'        => 'tmnf-links-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Header Links: Color', 'association' ),
							'subtitle'  => esc_html__('Pick a color for header links.', 'association' ),
							'default'   => '#2e333d',
							'output'    => array(
								'color' => '#header h1 a,.above-nav a,#header h2.tagline',
							)
						),
					
					

						
						array(
							'id'        => 'tmnf-bg-color-nav',
							'type'      => 'color',
							'title'     => esc_html__('Sub-menu: Navigation Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a background color for sub-navigation.', 'association' ),
							'default'   => '#3498db',
							'output'    => array(
								'background-color' => '.nav li ul',
								'border-bottom-color' => '.nav>li>ul:after',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Navigation Links: Current & Hover Color', 'association' ),
							'subtitle'  => esc_html__('Pick a hover color for header links.', 'association' ),
							'default'   => '#0f73ad',
							'output'    => array(
								'color' => '#main-nav>.current-menu-item>a,#main-nav>li>a:hover',
							)
						),
						
						array(
                            'id'          => 'tmnf-sub-nav-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Top Menu + Sub-menus: Typography', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.nav li ul li>a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as navigation text.', 'association' ),
                            'default'     => array(
                                'color'       => '#fff',
                                'font-weight'  => '400',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '12px',
                                'line-height' => '13px'
                            ),
                        ),
						
                        array(
                            'id'       => 'tmnf-border-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Borders Color', 'association' ),
							'subtitle'  => esc_html__('Pick a color for sub-menus borders', 'association' ),
							'default'   => '#e5e5e5',
							'output'    => array(
								'border-color' => '.header-left,.header-hr',
								'background-color' => '#main-nav>li>a:before',
							)
						),

                        array(
                            'id'             => 'tmnf-width-header',
                            'type'           => 'dimensions',
                            'output'   => array( '.header-left' ),
                            'units'          => 'px', 
                            'units_extended' => 'true',  
                            'height'          => false, 
                            'title'          => esc_html__( 'Header Tilte/Logo Width Option', 'association' ),
                            'subtitle'       => esc_html__( 'Choose the width limitation for header logo.', 'association' ),
                            'default'        => array(
                                'width'  => 250,
                            )
                        ),

                        array(
                            'id'       => 'tmnf-spacing-header',
                            'type'     => 'spacing',
                            'output'   => array( '#titles' ),
                            'mode'     => 'padding',
                            'all'      => false,   
                            'units'         => 'px',      
                            'title'    => esc_html__( 'Header Title/Logo Margin', 'association' ),
                            'subtitle' => esc_html__( 'Choose the margin for header title/logo.', 'association' ),
                            'default'  => array(
                                'padding-top'    => '26px',
                                'padding-bottom' => '26px',
                                'padding-left'    => '10px',
                                'padding-right' => '10px',
                            )
                        ),


                        array(
                            'id'       => 'tmnf-spacing-navigation',
                            'type'     => 'spacing',
                            'output'   => array( '#navigation' ),
                            'mode'     => 'padding',
                            'right'         => false,    
                            'left'          => false, 
                            'all'      => false,   
                            'units'         => 'px',      
                            'title'    => esc_html__( 'Navigation Padding', 'association' ),
                            'subtitle' => esc_html__( 'Choose the margin for navigation.', 'association' ),
                            'default'  => array(
                                'padding-top'    => '8px',
                                'padding-bottom' => '8px',
                            )
                        ),

					// section end
                    )
                );
				// header styling THE END






                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer Styling', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end


						array(
                            'id'          => 'tmnf-footer-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Footer Typography', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '#footer' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as footer text.', 'association' ),
                            'default'     => array(
                                'color'       => '#c0c9d1',
                                'font-style'  => '500',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '26px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a background color for footer.', 'association' ),
							'default'   => '#2b2c33',
							'output'    => array(
								'background-color' => '#footer,.curtain,#footer .searchform input.s,.sticky,.sticky .item_inn.ghost,#footer h2.widget span'
							)
						),
						
						array(
							'id'        => 'tmnf-links-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Color', 'association' ),
							'subtitle'  => esc_html__('Pick a color for footer links.', 'association' ),
							'default'   => '#a3bed1',
							'output'    => array(
								'color' => '#footer a,#footer h3,#footer h2.description,#footer #serinfo-nav li a,.curtain,.curtain a,#footer .meta,#footer .meta a,#footer .searchform input.s,.sticky',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Hover Color', 'association' ),
							'subtitle'  => esc_html__('Pick a hover color for footer links.', 'association' ),
							'default'   => '#eaeeef',
							'output'    => array(
								'color' => '#footer a:hover,.sticky a,.sticky .meta,.sticky .meta a,#footer #serinfo-nav li.current a,#footer .foocol h2',
							)
						),
						
						
                        array(
                            'id'       => 'tmnf-footer-border',
							'type'      => 'color',
							'title'     => esc_html__('Footer Borders', 'association' ),
							'subtitle'  => esc_html__('Pick a color for footer borders.', 'association' ),
							'default'   => '#2e303a',
							'output'    => array(
								'border-color' => '.footerhead,#footer .foocol,#copyright,#footer .tagcloud a,#footer .p-border,.curtain ul.social-menu li a,#footer .searchform input.s,#footer .foocol ul li,#footer ul.social-menu li a',
							)
						),


					// section end
                    )
                );
				// footer styling THE END









                $this->sections[] = array(
                    'title'  => esc_html__( 'Typography', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-bold',
                    'fields' => array( // header end


						array(
                            'id'          => 'tmnf-h1',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H1', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h1,#titles h1' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H1.', 'association' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '32px',
                                'line-height' => '32px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-big',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Post Titles Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.flexinside h1,.flexinside h2,.event-title h2,h1.entry-title' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for post headings.', 'association' ),
                            'default'     => array(
                                'color'       => '#3e4451',
                                'font-weight'  => '600',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '40px',
                                'line-height' => '44px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H2 + Block Titles Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h2,#curtain .searchform input.s,.bottom-menu a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.', 'association' ),
                            'default'     => array(
                                'color'       => '#3e4451',
                                'font-weight'  => '600',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '26px',
                                'line-height' => '32px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-small',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Block Subtitles Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h2.block span.subtitle,.flexinside h3,.sep h3,.sep .h3,.sep-detail .single-date' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.', 'association' ),
                            'default'     => array(
                                'color'       => '#adadad',
                                'font-weight'  => '400',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '15px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h3',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H3 Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h3,.flexcarousel h2,.foliohead .description' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H3.', 'association' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '600',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '19px',
                                'line-height' => '24px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h4',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H4 Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h4' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H4.', 'association' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '500',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '18px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h5',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H5 + Buttons Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h5,.widgetable ul.menu a,a.mainbutton,#serinfo-nav li a,#submit,a.comment-reply-link,#foliosidebar,a.su-button' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H5.', 'association' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '600',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '14px'
                            ),
                        ),	
						
						array(
                            'id'          => 'tmnf-h6',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H6 Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h6,.widgetable .ad300 h2,h2.adblock,h2.tagline' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H6.', 'association' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '400',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '12px',
                                'line-height' => '17px'
                            ),
                        ),
						


					// section end
                    )
                );
				// typography styling THE END










                $this->sections[] = array(
                    'title'  => esc_html__( 'Other Styling', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end
						
	
						
						array(
                            'id'          => 'tmnf-meta',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Meta Sections - Font Style', 'association' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.meta,.meta_more,.meta a,.entry p.meta' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for meta sections.', 'association' ),
                            'default'     => array(
                                'color'       => '#878787',
                                'font-weight'  => '400',
                                'font-family' => 'Montserrat',
                                'google'      => true,
                                'font-size'   => '11px',
                                'line-height' => '14px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.', 'association' ),
							'default'   => '#f48460',
							'output'    => array(
								'background-color' => '.searchSubmit,.ribbon,.builder .sep-page article .date,.post-password-form p>input,li.special>a,a#navtrigger,.widgetable ul.menu>li.current-menu-item>a,.flex-direction-nav a,li.current a,.page-numbers.current,#woo-inn .page-numbers.current,a.mainbutton,a.morebutton,.blogger .format-quote,a.hoverstuff,.products li .button.add_to_cart_button,span.overrating,a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link,.wrapper .wp-review-show-total',
								'color' => '.likes a,.flexinside a,.slider-menu li a i',
								'border-color' => '.entry blockquote,.products li .button.add_to_cart_button,.flexinside h1,h2.archiv,#main-nav>li.current-menu-item>a,#main-nav>li>a:hover',
							)
						),
						
						array(
							'id'        => 'tmnf-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.', 'association' ),
							'default'   => '#fff',
							'output'    => array(
								'color' => '.searchSubmit,a.hoverstuff,.ribbon,.ribbon a,.builder .sep-page article .date,.post-password-form p>input,#header li.special>a,a#navtrigger,.widgetable ul.menu>li.current-menu-item>a,.flex-direction-nav a,#hometab li.current a,a.mainbutton,.blogger .format-quote,.blogger .format-quote a,.products li .button.add_to_cart_button,a.mainbutton,a.morebutton,#foliosidebar a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link,.wrapper .wp-review-show-total,#footer a.comment-reply-link',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Hover Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.', 'association' ),
							'default'   => '#7fe8d8',
							'output'    => array(
								'background-color' => '.searchSubmit:hover,a.hoverstuff:hover,.ribbon:hover,a.mainbutton:hover,a.morebutton:hover,a#navtrigger:hover,a#navtrigger.active,.flex-direction-nav a:hover'
							)
						),
						
						array(
							'id'        => 'tmnf-hover-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Hover Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.', 'association' ),
							'default'   => '#222',
							'output'    => array(
								'color' => '.searchSubmit:hover,.ribbon:hover,a.hoverstuff:hover,.ribbon a:hover,a.mainbutton:hover,a.morebutton:hover,a#navtrigger:hover,a#navtrigger.active,.flex-direction-nav a:hover',
							)
						),
						
						

						array(
							'id'        => 'tmnf-special-blocks-bg',
							'type'      => 'color',
							'title'     => esc_html__('Special blocks / widgets: Background Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom background color for special blocks and widgets.', 'association' ),
							'default'   => '#212233',
							'output'    => array(
								'background-color' => '.page-header,.spec-block,.tmnf_icon,.hrline:after,#post-nav>div,.flexcarousel .imgwrap',
							)
						),
						
						
						
						array(
							'id'        => 'tmnf-special-blocks-text',
							'type'      => 'color',
							'title'     => esc_html__('Special blocks / widgets: Text Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom text color for image texts', 'association' ),
							'default'   => '#fff',
							'output'    => array(
								'color' => '.spec-block h2,.page-header h1,.spec-block p,.spec-block .meta,.page-header .meta,.page-header p,#post-nav>div,.page-crumbs',
							)
						),
						
						array(
							'id'        => 'tmnf-special-blocks-links',
							'type'      => 'color',
							'title'     => esc_html__('Special blocks / widgets: Links Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom text color for links', 'association' ),
							'default'   => '#ccc',
							'output'    => array(
								'color' => '.spec-block a,.tmnf_icon,.page-header a,#post-nav>div a,.page-crumbs a',
							)
						),
						
						array(
							'id'        => 'tmnf-special-blocks-border',
							'type'      => 'color',
							'title'     => esc_html__('Special blocks / widgets: Borders Color', 'association' ),
							'subtitle'  => esc_html__('Pick a custom text color for links', 'association' ),
							'default'   => '#333',
							'output'    => array(
								'border-color' => '.spec-block ul.featured li',
							)
						),
						
						

					// section end
                    )
                );
				// other styling THE END









                $this->sections[] = array(
                    'type' => 'divide',
                );	



                
                $this->sections[] = array(
                    'title'  => esc_html__( 'Post Settings', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-edit',
                    'fields' => array( // header end
					

                        array(
                            'id'       => 'post-image-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Featured Image', 'association' ),
                            'subtitle' => esc_html__( 'Tick to disable featured image in single post page.', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
                        array(
                            'id'       => 'post-meta-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable "Meta" sections', 'association' ),
                            'subtitle' => esc_html__( 'Tick to disable post "inforamtions" - date, category etc. below post titles', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'post-author-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Author Info Section', 'association' ),
                            'subtitle' => esc_html__( 'Tick to disable author section in single post page.', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'post-nextprev-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Next/Previous Post Section', 'association' ),
                            'subtitle' => esc_html__( 'Tick to disable Next/Previous section in single post page.', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'post-related-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Related posts Section', 'association' ),
                            'subtitle' => esc_html__( 'Tick to disable related section in single post page.', 'association' ),
                            'desc'     => esc_html__( '', 'association' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
					
					
					// section end
                    )
                );
				// post settings THE END





                
 $this->sections[] = array(
                    'title'  => esc_html__( 'Social Networks','association'),
                    'icon'   => 'el el-share',
                    'fields' => array( // header end
					

                        array(
                            'id'       => 'tmnf-social-rss',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Rss Feed','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
                        array(
                            'id'       => 'tmnf-social-facebook',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Facebook','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-twitter',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Twitter','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-google',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Google+','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-pinterest',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Pinterest','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-instagram',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Instagram','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-youtube',
                            'type'     => 'text',
                            'title'    => esc_html__( 'You Tube','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-vimeo',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Vimeo','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-tumblr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Tumblr','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-500',
                            'type'     => 'text',
                            'title'    => esc_html__( '500px','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-flickr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Flickr','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-linkedin',
                            'type'     => 'text',
                            'title'    => esc_html__( 'LinkedIn','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-foursquare',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Foursquare','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-dribbble',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Dribbble','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-skype',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Skype','association'),
                            'subtitle' => esc_html__( 'Enter skype URL','association'),
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-stumbleupon',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Stumbleupon','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-github',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Github','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-soundcloud',
                            'type'     => 'text',
                            'title'    => esc_html__( 'SoundCloud','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-spotify',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Spotify','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-xing',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Xing','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-whatsapp',
                            'type'     => 'text',
                            'title'    => esc_html__( 'WhatsApp','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-vk',
                            'type'     => 'text',
                            'title'    => esc_html__( 'VK','association'),
                            'subtitle' => esc_html__( 'Enter full URL','association'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						

					// section end
                    )
                );
				// social networks THE END	
				
				
				
				
				
				
                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer', 'association' ),
                    'desc'   => esc_html__( '', 'association' ),
                    'icon'   => 'el el-website',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
					

                        array(
                            'id'       => 'footer-logo',
                            'type'     => 'media',
							'default'  => '',
                            'preview'  => true,
                            'title'    => esc_html__( 'Footer Logo', 'association' ),
                            'desc'     => esc_html__( 'Upload a footer logo for your theme.', 'association' ),
                        ),
			
						
						
						array(
                            'id'       => 'tmnf-footer-text',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Footer: Text (below logo)', 'association' ),
							'default'  => esc_html__( 'Association - Civic, Society, Community & Nonprofit WP theme', 'association' ),
                            'validate' => 'html',
						),
			
						
						
						array(
                            'id'       => 'tmnf-footer-editor',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Footer: Credits ', 'association' ),
							'default'  => '',
                            'validate' => 'html',
						),
				
				
				
				
					// section end
                    )
                );
				// custom footer THE END		
				
				

                $this->sections[] = array(
                    'title'  => esc_html__( 'Static Ads', 'association' ),
                    'desc'   => esc_html__( 'Note: Header ad section is disabled, when "Simple" theme layout is used!', 'association' ),
                    'icon'   => 'el el-website',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(

						
						array(
                            'id'       => 'postad-script',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Post Script Code', 'association' ),
                            'desc'     => esc_html__( 'Put your code here', 'association' ),
							'default'  => '',
						),

                        array(
                            'id'       => 'postad-image',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Post Ad - image', 'association' ),
                            'subtitle' => esc_html__( 'Enter full URL of your ad image (banner)', 'association' ),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'postad-target',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Post Ad - target URL', 'association' ),
                            'subtitle' => esc_html__( 'Enter full URL', 'association' ),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
				
				
				
				
					// section end
                    )
                );
				// custom footer THE END	

				

                $this->sections[] = array(
                    'type' => 'divide',
                );		

                

                $this->sections[] = array(
                    'title'  => esc_html__( 'Import / Export', 'association' ),
                    'desc'   => esc_html__( 'Import and Export your Redux Framework settings from file, text or URL.', 'association' ),
                    'icon'   => 'el el-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
                    ),
                );


            }
			
			

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => esc_html__( 'Theme Information 1', 'association' ),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'association' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => esc_html__( 'Theme Information 2', 'association' ),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'association' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'association' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'themnific_redux',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => esc_html__( 'Association - admin panel', 'association' ),
                    'page_title'           => esc_html__( 'Association admin panel', 'association' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'themnific-options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'el el-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.


                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'https://dannci.freshdesk.com/support/solutions/articles/5000167124-support-policy',
					'target'   => '_blank',
                    'title' => esc_html__( 'Support', 'association' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-extensions',
                    'href'   => 'http://themnific.com/',
					'target'   => '_blank',
                    'title' => esc_html__( 'Our themes', 'association' ),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://dannci.freshdesk.com/support/solutions/articles/5000167124-support-policy',
					'target'   => '_blank',
                    'title' => 'Support',
                    'icon'  => 'el el-wrench-alt'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://themnific.com/',
                    'title' => 'All our themes! ',
					'target'   => '_blank',
                    'icon'  => 'el el-fire'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( esc_html__( 'Hello in theme admin panel', 'association' ), $v );
                } else {
                    $this->args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'association' );
                }

                // Add content after the form.
                $this->args['footer_text'] = esc_html__( 'Redux & Dannci & Themnific', 'association' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public static function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_sample_config();
    } else {
        echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            $return['warning'] = $field;

            return $return;
        }
    endif;


// TMNF admin panel styling	
function addPanelCSS() {
    wp_register_style(
        'redux-tmnf-css',
        get_template_directory_uri() .'/redux-framework/assets/redux-themnific.css',
        array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
        time(),
        'all'
    ); 
    wp_enqueue_style('redux-tmnf-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/themnific_redux/enqueue', 'addPanelCSS' );


// remove redux notices
function association_remove_redux_notices() { 
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'association_remove_redux_notices');


