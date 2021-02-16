<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta">

			<?php understrap_posted_on(); ?>

        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->

    <img src="<?php echo get_field( 'main_photo', $post->ID ); ?>"/>

    <ul class="mt-3">
        <li>Площадь: <?php echo get_field( 'square', $post->ID ); ?> м<sup>2</sup></li>
        <li>Цена: <?php echo get_field( 'price', $post->ID ); ?> руб.</li>
        <li>Адрес: <?php echo get_field( 'address', $post->ID ); ?> </li>
        <li>Жилая площадь: <?php echo get_field( 'l-square', $post->ID ); ?> м<sup>2</sup></li>
        <li>Этаж: <?php echo get_field( 'floor', $post->ID ); ?></li>
    </ul>
	<?php if ( have_rows( 'photos' ) ): ?>
        <div class="slider">
			<?php while ( have_rows( 'photos' ) ): the_row();
				$image = get_sub_field( 'photo' );
				?>
                <img src="<?php echo $image; ?>"/>
			<?php endwhile; ?>
        </div>
	<?php endif; ?>
    <div class="entry-content mt-3">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

    </div><!-- .entry-content -->

    <footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
