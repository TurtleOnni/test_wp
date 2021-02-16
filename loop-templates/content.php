<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div>
		<?php
		$city = get_the_terms( $post->ID, 'city' );
		if ( ! empty( $city ) ) { ?>
            <a href="/city/<?php echo $city[0]->slug; ?>"><?php echo $city[0]->name; ?></a>&nbsp;
		<?php }
		$types = get_the_terms( $post->ID, 'type_building' );
		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) { ?>
                <a href="/type_building/<?php echo $type->slug; ?>"><?php echo $type->name; ?></a>&nbsp;
			<?php }
		} ?>
    </div>
    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>&nbsp;
			<?php ?></h2>
    </header><!-- .entry-header -->
    <div class="row mb-lg-5">
        <div class="col-8">
            <img src="<?php echo get_field( 'main_photo', $post->ID ); ?>"/>
        </div>

        <div class="entry-content col-4">

			<?php the_content(); ?>
            <ul class="mt-3">
                <li>Площадь: <?php echo get_field( 'square', $post->ID ); ?> м<sup>2</sup></li>
                <li>Цена: <?php echo get_field( 'price', $post->ID ); ?> руб.</li>
                <li>Адрес: <?php echo get_field( 'address', $post->ID ); ?> </li>
                <li>Жилая площадь: <?php echo get_field( 'l-square', $post->ID ); ?> м<sup>2</sup></li>
                <li>Этаж: <?php echo get_field( 'floor', $post->ID ); ?></li>
            </ul>
			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
					'after'  => '</div>',
				)
			);
			?>

        </div><!-- .entry-content -->
    </div>
    <footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->
