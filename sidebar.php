<?php
/**
 * The sidebar containing the widget area on blog pages.
 *
 * @package GT Next
 */

// Check if Sidebar should be displayed.
if ( gt_next_has_sidebar() ) : ?>

	<section id="secondary" class="sidebar widget-area" role="complementary">

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</section><!-- #secondary -->

	<?php
endif;
