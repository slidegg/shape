<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class ShopKit_Ot_Metabox {

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {

			add_action( 'admin_init', __CLASS__ . '::settings', 2 );

			if ( class_exists( 'RevSlider' ) ) {
				add_action( 'add_meta_boxes', __CLASS__ . '::remove_default_revslider_metabox' );
			}
		}

		public static function remove_default_revslider_metabox() {

			remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
			remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
			remove_meta_box( 'mymetabox_revslider_0', 'product', 'normal' );
			remove_meta_box( 'mymetabox_revslider_0', 'shop_coupon', 'normal' );

		}

		public static function settings() {

			$settings = array();

			$settings['_shopkit_page_title'] = array(
				'id'          => '_shopkit_page_title',
				'label'       => esc_html__( 'Page Title', 'shopkit' ),
				'desc'        => esc_html__( 'Set the page title appearance.', 'shopkit' ),
				'std'         => '',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => '',
						'label'       => esc_html__( 'Default From Theme Settings', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'none',
						'label'       => esc_html__( 'Hide', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'content',
						'label'       => esc_html__( 'Above Page Content', 'shopkit' ),
						'src'         => ''
					),
				)
			);

			$sidebars_cl = array_values( ShopKit_Ot_Settings::get_settings( 'general', 'sidebars', array() ) );

			$sidebar_layouts = array(
				array(
					'value' => 'default',
					'label' => esc_html__( 'Default Sidebar Layout', 'shopkit' ),
					'src'   => ''
				),
				array(
					'value' => 'none',
					'label' => esc_html__( 'Without Sidebars', 'shopkit' ),
					'src'   => ''
				),
			);

			foreach( $sidebars_cl as $k => $custom_sidebar ) {

				$name = $custom_sidebar['title'];
				$id = 'shopkit-cl-' . sanitize_title( $custom_sidebar['title'] );

				$sidebar_layouts[] = array(
					'value' => $k,
					'label' => $name,
					'src'   => ''
				);

			}

			$settings['_shopkit_sidebar_layout'] = array(
				'id'          => '_shopkit_sidebar_layout',
				'label'       => esc_html__( 'Sidebar Layout', 'shopkit' ),
				'desc'        => esc_html__( 'Set the page title appearance.', 'shopkit' ),
				'std'         => 'default',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $sidebar_layouts
			);

			$settings['_shopkit_short_description'] = array(
				'id'          => '_shopkit_short_description',
				'label'       => esc_html__( 'Short Description', 'shopkit' ),
				'desc'        => esc_html__( 'Enter short description.', 'shopkit' ),
				'std'         => '',
				'type'        => 'textarea'
			);

			if ( class_exists( 'RevSlider' ) ) {

				global $wpdb;

				$get_sliders = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders' );

				$revsliders = array (
					array(
						'value' => '',
						'label' => esc_html__( 'No Slider Template', 'shopkit' ),
						'src' => ''
					)
				);

				if( $get_sliders ) {
					foreach( $get_sliders as $slider ) {

						$revsliders[] = array(
							'value' => $slider->alias,
							'label' => $slider->alias,
							'src' => ''
						);
					}
				}

				$settings['_shopkit_revolution_1'] = array(
					'id'          => '_shopkit_revolution_1',
					'label'       => esc_html__( 'Revolution Slider Absolute Top', 'shopkit' ),
					'desc'        => esc_html__( 'Add Revolution Slider template to the absolute top position.', 'shopkit' ),
					'std'         => '',
					'type'        => 'select',
					'choices'     => $revsliders
				);

				$settings['_shopkit_revolution_2'] = array(
					'id'          => '_shopkit_revolution_2',
					'label'       => esc_html__( 'Revolution Slider After Header', 'shopkit' ),
					'desc'        => esc_html__( 'Add Revolution Slider template after header.', 'shopkit' ),
					'std'         => '',
					'type'        => 'select',
					'choices'     => $revsliders
				);

				$settings['_shopkit_revolution_3'] = array(
					'id'          => '_shopkit_revolution_3',
					'label'       => esc_html__( 'Revolution Slider Before Footer', 'shopkit' ),
					'desc'        => esc_html__( 'Add Revolution Slider template before footer.', 'shopkit' ),
					'std'         => '',
					'type'        => 'select',
					'choices'     => $revsliders
				);

				$settings['_shopkit_revolution_4'] = array(
					'id'          => '_shopkit_revolution_4',
					'label'       => esc_html__( 'Revolution Slider Absolute Bottom', 'shopkit' ),
					'desc'        => esc_html__( 'Add Revolution Slider template to the absolute bottom position.', 'shopkit' ),
					'std'         => '',
					'type'        => 'select',
					'choices'     => $revsliders
				);

			}

			$meta_box_page = array(
				'id'        => 'shopkit_page_meta',
				'title'     => esc_html__( 'ShopKit Page', 'shopkit' ),
				'desc'      => esc_html__( 'Setup custom page options.', 'shopkit' ),
				'pages'     => array( 'page' ),
				'context'   => 'normal',
				'priority'  => 'high',
				'fields'    => $settings
			);

			ot_register_meta_box( $meta_box_page );

			unset( $settings['_shopkit_page_title'], $settings['_shopkit_revolution_1'], $settings['_shopkit_revolution_2'], $settings['_shopkit_revolution_3'], $settings['_shopkit_revolution_4'] );

			$settings['_shopkit_post_gallery'] = array(
				'id'          => '_shopkit_post_gallery',
				'label'       => esc_html__( 'Gallery Post', 'shopkit' ),
				'desc'        => esc_html__( 'Enter gallery shortcode to use. [gallery]', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);
			$settings['_shopkit_post_video_mp4'] = array(
				'id'          => '_shopkit_post_video_mp4',
				'label'       => esc_html__( 'Video Post MP4 URL', 'shopkit' ),
				'desc'        => esc_html__( 'Enter URL of the .mp4 video.', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);
			$settings['_shopkit_post_video_ogg'] = array(
				'id'          => '_shopkit_post_video_ogg',
				'label'       => esc_html__( 'Video Post OGG URL', 'shopkit' ),
				'desc'        => esc_html__( 'Enter URL of the .ogg video.', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);
			$settings['_shopkit_post_video'] = array(
				'id'          => '_shopkit_post_video',
				'label'       => esc_html__( 'Video Post EMBED', 'shopkit' ),
				'desc'        => esc_html__( 'Enter embed code for the video.', 'shopkit' ),
				'std'         => '',
				'type'        => 'textarea-simple'
			);

			$settings['_shopkit_post_audio_mpeg'] = array(
				'id'          => '_shopkit_post_audio_mpeg',
				'label'       => esc_html__( 'Audio Post MPEG URL', 'shopkit' ),
				'desc'        => esc_html__( 'Enter URL of the .mp3/.mp4 audio.', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);
			$settings['_shopkit_post_audio_ogg'] = array(
				'id'          => '_shopkit_post_audio_ogg',
				'label'       => esc_html__( 'Audio Post OGG URL', 'shopkit' ),
				'desc'        => esc_html__( 'Enter URL of the .ogg audio.', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);
			$settings['_shopkit_post_audio'] = array(
				'id'          => '_shopkit_post_audio',
				'label'       => esc_html__( 'Audio Post EMBED', 'shopkit' ),
				'desc'        => esc_html__( 'Enter embed code for the audio.', 'shopkit' ),
				'std'         => '',
				'type'        => 'textarea-simple'
			);

			$settings['_shopkit_post_link'] = array(
				'id'          => '_shopkit_post_link',
				'label'       => esc_html__( 'Link Post', 'shopkit' ),
				'desc'        => esc_html__( 'Enter URL for the link post.', 'shopkit' ),
				'std'         => '',
				'type'        => 'text'
			);

			$settings['_shopkit_post_quote'] = array(
				'id'          => '_shopkit_post_quote',
				'label'       => esc_html__( 'Quote Post', 'shopkit' ),
				'desc'        => esc_html__( 'Enter quote.', 'shopkit' ),
				'std'         => '',
				'type'        => 'textarea-simple'
			);

			$meta_box_post = array(
				'id'        => 'shopkit_post_meta',
				'title'     => esc_html__( 'Post Settings', 'shopkit' ),
				'desc'      => esc_html__( 'Setup custom post options.', 'shopkit' ),
				'pages'     => array( 'post' ),
				'context'   => 'normal',
				'priority'  => 'high',
				'fields'    => $settings
			);

			ot_register_meta_box( $meta_box_post );

		}
	}

	add_action( 'admin_init', array( 'ShopKit_Ot_Metabox', 'init' ), 1 );

?>