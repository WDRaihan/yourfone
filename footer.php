<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package YourFone
 */

?>

	<footer id="site-footer" class="site-footer">
		<div class="footer-widgets">
			<div class="container">
				<div class="footer-top">
					<div class="row">
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-top-1' ) ) {
								dynamic_sidebar('footer-top-1');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-top-2' ) ) {
								dynamic_sidebar('footer-top-2');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-top-3' ) ) {
								dynamic_sidebar('footer-top-3');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-top-4' ) ) {
								dynamic_sidebar('footer-top-4');
							}
							?>
						</div>
					</div>
				</div>
				<div class="footer-bottom">
					<div class="row">
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-bottom-1' ) ) {
								dynamic_sidebar('footer-bottom-1');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-bottom-2' ) ) {
								dynamic_sidebar('footer-bottom-2');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-bottom-3' ) ) {
								dynamic_sidebar('footer-bottom-3');
							}
							?>
						</div>
						<div class="col-3">
							<?php 
							if ( is_active_sidebar( 'footer-bottom-4' ) ) {
								dynamic_sidebar('footer-bottom-4');
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-6">
						<?php 
						if ( is_active_sidebar( 'footer-copyright-1' ) ) {
							dynamic_sidebar('footer-copyright-1');
						}
						?>
						<div class="copyright-text"><?php echo '© Copyright '.date('Y').'. All rights reserved.'; ?></div>
					</div>
					<div class="col-6">
						<?php 
						if ( is_active_sidebar( 'footer-copyright-2' ) ) {
							dynamic_sidebar('footer-copyright-2');
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
