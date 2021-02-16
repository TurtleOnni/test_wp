<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );

	// Removes the parent themes stylesheet and scripts from inc/enqueue.php
}

add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'add_child_theme_textdomain' );


function understrap_register_taxonomy_city() {
	/**
	 * Taxonomy Type: Города.
	 */

	register_taxonomy( 'city',
		array(
			'building'
		),
		array(
			'hierarchical' => true,
			'labels'       => array(
				'name'              => _x( 'Города', 'taxonomy general name' ),
				'singular_name'     => _x( 'Город', 'taxonomy singular name' ),
				'search_items'      => __( 'Найти' ),
				'all_items'         => __( 'Все города' ),
				'parent_item'       => __( 'Город' ), // родительская таксономия
				'parent_item_colon' => __( 'Родитель' ),
				'edit_item'         => __( 'Редактировать город' ),
				'update_item'       => __( 'Обновить город' ),
				'add_new_item'      => __( 'Добавить новый город' ),
				'new_item_name'     => __( 'Новый город' ),
				'menu_name'         => __( 'Города' ),
			),
			'rewrite'      => array(
				'slug'         => 'city',
				'with_front'   => false,
				'hierarchical' => true
			),
			'show_in_rest' => false,
		) );
}

if ( ! taxonomy_exists( 'city' ) ) {
	add_action( 'init', 'understrap_register_taxonomy_city', 0 );
}

function understrap_register_taxonomy_type_building() {
	/**
	 * Taxonomy Type: Тип недвижимости.
	 */

	register_taxonomy( 'type_building',
		array(
			'building'
		),
		array(
			'hierarchical' => true,
			'labels'       => array(
				'name'              => _x( 'Тип', 'taxonomy general name' ),
				'singular_name'     => _x( 'Тип', 'taxonomy singular name' ),
				'search_items'      => __( 'Найти' ),
				'all_items'         => __( 'Все типы' ),
				'parent_item'       => __( 'Тип' ), // родительская таксономия
				'parent_item_colon' => __( 'Родитель' ),
				'edit_item'         => __( 'Редактировать тип' ),
				'update_item'       => __( 'Обновить тип' ),
				'add_new_item'      => __( 'Добавить новый тип' ),
				'new_item_name'     => __( 'Новый тип' ),
				'menu_name'         => __( 'Тип объекта' ),
			),
			'rewrite'      => array(
				'slug'         => 'type_building',
				'with_front'   => false,
				'hierarchical' => true
			),
			'show_in_rest' => false,
		) );
}

if ( ! taxonomy_exists( 'type_building' ) ) {
	add_action( 'init', 'understrap_register_taxonomy_type_building', 0 );
}


function understrap_post_type_building() {
	/**
	 * Post Type: Объекты.
	 */

	$labels = [
		"name"                     => __( "Объекты", "understrap-child" ),
		"singular_name"            => __( "Объект", "understrap-child" ),
		"menu_name"                => __( "Недвижимость", "understrap-child" ),
		"all_items"                => __( "Все объекты", "understrap-child" ),
		"add_new"                  => __( "Добавить объект", "understrap-child" ),
		"add_new_item"             => __( "Добавить новый объект", "understrap-child" ),
		"edit_item"                => __( "Изменить объект", "understrap-child" ),
		"new_item"                 => __( "Новый объект", "understrap-child" ),
		"view_item"                => __( "Просмотреть объект", "understrap-child" ),
		"view_items"               => __( "Просмотреть объекты", "understrap-child" ),
		"search_items"             => __( "Искать объект", "understrap-child" ),
		"not_found"                => __( "Объект не найден", "understrap-child" ),
		"not_found_in_trash"       => __( "No Недвижимости found in bin", "understrap-child" ),
		"parent"                   => __( "Parent Недвижимость:", "understrap-child" ),
		"featured_image"           => __( "Главное фото объекта", "understrap-child" ),
		"set_featured_image"       => __( "Set featured image for this Недвижимость", "understrap-child" ),
		"remove_featured_image"    => __( "Remove featured image for this Недвижимость", "understrap-child" ),
		"use_featured_image"       => __( "Use as featured image for this Недвижимость", "understrap-child" ),
		"archives"                 => __( "Недвижимость archives", "understrap-child" ),
		"insert_into_item"         => __( "Вставить в объект", "understrap-child" ),
		"uploaded_to_this_item"    => __( "Upload to this Недвижимость", "understrap-child" ),
		"filter_items_list"        => __( "Filter Недвижимости list", "understrap-child" ),
		"items_list_navigation"    => __( "Недвижимости list navigation", "understrap-child" ),
		"items_list"               => __( "Недвижимости list", "understrap-child" ),
		"attributes"               => __( "Недвижимости attributes", "understrap-child" ),
		"name_admin_bar"           => __( "Недвижимость", "understrap-child" ),
		"item_published"           => __( "Недвижимость published", "understrap-child" ),
		"item_published_privately" => __( "Недвижимость published privately.", "understrap-child" ),
		"item_reverted_to_draft"   => __( "Недвижимость reverted to draft.", "understrap-child" ),
		"item_scheduled"           => __( "Недвижимость scheduled", "understrap-child" ),
		"item_updated"             => __( "Недвижимость updated.", "understrap-child" ),
		"parent_item_colon"        => __( "Parent Недвижимость:", "understrap-child" ),
	];

	$args = [
		"label"                 => __( "Объекты", "understrap-child" ),
		"labels"                => $labels,
		"description"           => "",
		"public"                => true,
		"publicly_queryable"    => true,
		"show_ui"               => true,
		"show_in_rest"          => true,
		"rest_base"             => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive"           => false,
		"show_in_menu"          => true,
		"show_in_nav_menus"     => true,
		"delete_with_user"      => false,
		"exclude_from_search"   => false,
		"capability_type"       => "post",
		"map_meta_cap"          => true,
		"hierarchical"          => false,
		"rewrite"               => array( "slug" => "building", "with_front" => true ),
		"query_var"             => true,
		"supports"              => array( "title", "editor", "thumbnail", "excerpt", "custom-fields" ),
		"taxonomies"            => array( "city", "type_building" )
	];

	register_post_type( "building", $args );
}

function understrap_register_taxonomies_for_post_type_building() {
	register_taxonomy_for_object_type( 'city', 'building' );
	register_taxonomy_for_object_type( 'type_building', 'building' );
}

if ( ! post_type_exists( 'building' ) ) {
	add_action( 'init', 'understrap_post_type_building' );
	add_action( 'init', 'understrap_register_taxonomies_for_post_type_building' );
}

/**
 *  Add image to city
 */
if ( is_admin() && ! class_exists( 'Term_Meta_Image' ) ) {

	// init
	add_action( 'admin_init', 'Term_Meta_Image_init' );
	function Term_Meta_Image_init() {
		$GLOBALS['Term_Meta_Image'] = new Term_Meta_Image();
	}

	class Term_Meta_Image {

		static $taxes = array( 'city' ); // пример: array('category', 'post_tag');

		static $meta_key = '_thumbnail_id';
		static $attach_term_meta_key = 'img_term';

		static $add_img_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

		public function __construct() {
			// once
			if ( isset( $GLOBALS['Term_Meta_Image'] ) ) {
				return $GLOBALS['Term_Meta_Image'];
			}

			$taxes = self::$taxes ? self::$taxes : get_taxonomies( [ 'public' => true ], 'names' );

			foreach ( $taxes as $taxname ) {
				add_action( "{$taxname}_add_form_fields", [ $this, 'add_term_image' ], 10, 2 );
				add_action( "{$taxname}_edit_form_fields", [ $this, 'update_term_image' ], 10, 2 );
				add_action( "created_{$taxname}", [ $this, 'save_term_image' ], 10, 2 );
				add_action( "edited_{$taxname}", [ $this, 'updated_term_image' ], 10, 2 );

				add_filter( "manage_edit-{$taxname}_columns", [ $this, 'add_image_column' ] );
				add_filter( "manage_{$taxname}_custom_column", [ $this, 'fill_image_column' ], 10, 3 );
			}
		}

		public function add_term_image( $taxonomy ) {
			wp_enqueue_media();

			add_action( 'admin_print_footer_scripts', [ $this, 'add_script' ], 99 );
			$this->css();
			?>
            <div class="form-field term-group">
                <label><?php _e( 'Image', 'default' ); ?></label>
                <div class="term__image__wrapper">
                    <a class="termeta_img_button" href="#">
                        <img src="<?php echo self::$add_img_url ?>" alt="">
                    </a>
                    <input type="button" class="button button-secondary termeta_img_remove"
                           value="<?php _e( 'Remove', 'default' ); ?>"/>
                </div>

                <input type="hidden" id="term_imgid" name="term_imgid" value="">
            </div>
			<?php
		}

		public function update_term_image( $term, $taxonomy ) {
			wp_enqueue_media();

			add_action( 'admin_print_footer_scripts', [ $this, 'add_script' ], 99 );

			$image_id  = get_term_meta( $term->term_id, self::$meta_key, true );
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : self::$add_img_url;
			$this->css();
			?>
            <tr class="form-field term-group-wrap">
                <th scope="row"><?php _e( 'Image', 'default' ); ?></th>
                <td>
                    <div class="term__image__wrapper">
                        <a class="termeta_img_button" href="#">
							<?php echo '<img src="' . $image_url . '" alt="">'; ?>
                        </a>
                        <input type="button" class="button button-secondary termeta_img_remove"
                               value="<?php _e( 'Remove', 'default' ); ?>"/>
                    </div>

                    <input type="hidden" id="term_imgid" name="term_imgid" value="<?php echo $image_id; ?>">
                </td>
            </tr>
			<?php
		}

		public function css() {
			?>
            <style>
                .termeta_img_button {
                    display: inline-block;
                    margin-right: 1em;
                }

                .termeta_img_button img {
                    display: block;
                    float: left;
                    margin: 0;
                    padding: 0;
                    min-width: 100px;
                    max-width: 150px;
                    height: auto;
                    background: rgba(0, 0, 0, .07);
                }

                .termeta_img_button:hover img {
                    opacity: .8;
                }

                .termeta_img_button:after {
                    content: '';
                    display: table;
                    clear: both;
                }
            </style>
			<?php
		}

		public function add_script() {
			$title      = __( 'Изображение', 'default' );
			$button_txt = __( 'Установить изображение', 'default' );
			?>
            <script>
                jQuery(document).ready(function ($) {
                    var frame,
                        $imgwrap = $('.term__image__wrapper'),
                        $imgid = $('#term_imgid');

                    $('.termeta_img_button').click(function (ev) {
                        ev.preventDefault();

                        if (frame) {
                            frame.open();
                            return;
                        }

                        frame = wp.media.frames.questImgAdd = wp.media({
                            states: [
                                new wp.media.controller.Library({
                                    title: '<?php echo $title ?>',
                                    library: wp.media.query({type: 'image'}),
                                    multiple: false,
                                    //date:   false
                                })
                            ],
                            button: {
                                text: '<?php echo $button_txt ?>', // Set the text of the button.
                            }
                        });

                        frame.on('select', function () {
                            var selected = frame.state().get('selection').first().toJSON();
                            if (selected) {
                                $imgid.val(selected.id);
                                $imgwrap.find('img').attr('src', selected.sizes.thumbnail.url);
                            }
                        });

                        frame.on('open', function () {
                            if ($imgid.val()) frame.state().get('selection').add(wp.media.attachment($imgid.val()));
                        });

                        frame.open();
                    });

                    $('.termeta_img_remove').click(function () {
                        $imgid.val('');
                        $imgwrap.find('img').attr('src', '<?php echo self::$add_img_url ?>');
                    });
                });
            </script>

			<?php
		}

		public function add_image_column( $columns ) {

			add_action( 'admin_notices', function () {
				echo '<style>.column-image{ width:50px; text-align:center; }</style>';
			} );

			return array_slice( $columns, 0, 1 ) + [ 'image' => '' ] + $columns;
		}

		public function fill_image_column( $string, $column_name, $term_id ) {

			if ( 'image' === $column_name && $image_id = get_term_meta( $term_id, self::$meta_key, 1 ) ) {
				$string = '<img src="' . wp_get_attachment_image_url( $image_id, 'thumbnail' ) . '" width="50" height="50" alt="" style="border-radius:4px;" />';
			}

			return $string;
		}

		public function save_term_image( $term_id, $tt_id ) {
			if ( isset( $_POST['term_imgid'] ) && $attach_id = (int) $_POST['term_imgid'] ) {
				update_term_meta( $term_id, self::$meta_key, $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );
			}
		}

		public function updated_term_image( $term_id, $tt_id ) {
			if ( ! isset( $_POST['term_imgid'] ) ) {
				return;
			}

			$cur_term_attach_id = (int) get_term_meta( $term_id, self::$meta_key, 1 );

			if ( $attach_id = (int) $_POST['term_imgid'] ) {
				update_term_meta( $term_id, self::$meta_key, $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );

				if ( $cur_term_attach_id != $attach_id ) {
					wp_delete_attachment( $cur_term_attach_id );
				}
			} else {
				if ( $cur_term_attach_id ) {
					wp_delete_attachment( $cur_term_attach_id );
				}

				delete_term_meta( $term_id, self::$meta_key );
			}
		}

	}
}

/*
* Replace posts at home
*/

function understrap_add_building_to_query( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'building' ) );
	}

	return $query;
}

add_action( 'pre_get_posts', 'understrap_add_building_to_query' );

/**
 * Add script for slick slider
 */
function understrap_load_js_script_slick() {
	if ( is_single() ) {
		wp_enqueue_style( 'slick', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );
		wp_enqueue_style( 'slick-theme', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css' );
		wp_enqueue_script( 'slickjs', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js' );
		wp_enqueue_script( 'slick-init-js', get_stylesheet_directory_uri() . '/js/slick-init.js' );
	}
}

add_action( 'wp_enqueue_scripts', 'understrap_load_js_script_slick' );
