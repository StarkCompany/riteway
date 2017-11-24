			<footer class="footer wrap cf" role="contentinfo">

				<div id="inner-footer" class="cf">

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => '',                              // remove nav container
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

					<div class="m-all t-1of2 d-1of2 design-by">
                    	<a href="http://thenewmediagroup.ca" target="_blank">
                    		<span>Another Real Estate Website By: </span>
                    		<img src="<?php echo get_template_directory_uri(); ?>/library/images/new-media-group.gif" alt="The New Media Group" />
                    	</a>
                    </div>
                    <div class="m-all t-1of2 d-1of2 source-org copyright">
	                    <span>Copyright &copy; Riteway Signs <?php echo date('Y'); ?></span>
                    </div>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

    <?php  if(!empty($current_user->roles[0])){
        if((!$current_user->roles['0'] == 'aamrole_5410d7b003aa5') || (!$current_user->roles['0'] == 'realtor')){ ?>

     <script>
            $(document).ready(function() {
            //toggle `popup` / `inline` mode
            $.fn.editable.defaults.mode = 'popover';    

            $('.signs').editable({
                    type: 'select',
                    title: 'Select status',
                    placement: 'top',
                    source: [
                        {value: 'true', text: 'Charge'},
                        {value: 'false', text: 'No Charge'},
                    ]
                    ,url: '<?php echo get_template_directory_uri(); ?>/reports/post.php'
                });

        });
    </script>
    <?php }}?>
</html> <!-- end of site. what a ride! -->
