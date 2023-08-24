<?php

namespace ElementorCustomProduct\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use WP_Query;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor 
 *
 * Elementor widget for .
 *
 * @since 1.0.0
 */
class Custom_Products extends Widget_Base
{

	public function get_name()
	{
		return 'custom_product_grid_widget';
	}

	public function get_title()
	{
		return __('Custom Product Grid Widget', 'text-domain');
	}

	public function get_icon()
	{
		return 'eicon-product-grid';
	}

	public function get_categories()
	{
		return ['general'];
	}



	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_products_settings',
			[
				'label' => __('Products Settings', 'text-domain'),
			]
		);

		// Add a control for number of products per page
		$this->add_control(
			'products_per_page',
			[
				'label' => __('Products per Page', 'text-domain'),
				'type' => Controls_Manager::NUMBER,
				'default' => 6, // Default number of products per page
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		wp_enqueue_script('hello-world', plugin_dir_url(__FILE__) . 'assets/js/custom-product-grid-widget.js', array('jquery'), '1.0.0', true);

		$settings = $this->get_settings();
		$products_per_page = $settings['products_per_page'];

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => $products_per_page,
		);

		$query = new \WP_Query($args);

		// get the current currency symbol
		$currency_symbol = get_woocommerce_currency_symbol();

		if ($query->have_posts()) {
			echo '<div class="custom-product-grid">';

			while ($query->have_posts()) {
				$query->the_post();
				global $product;

				// Get the product ID
				$product_id = $product->get_id();
				$weight_price = get_post_meta($product_id, '_mia_cup_price_weight', true);
				$unit_price = get_post_meta($product_id, '_mia_cup_price_unit', true);
				$main_price = $product->get_price_html();

				// Inside the loop for product items
				echo '<div class="product-item" data-product-id="' . $product_id . '">';
				echo '<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '">';
				echo '<h2 class="product-price">' . get_the_title() . '</h2>';

				// First toggle switch
				echo '<div class="price-switch">';
				echo '<input type="range" class="slider" min="1" max="3">';
				echo '</div>';

				// Second toggle switch
				echo '<div class="price-switch">';
				echo '<input type="range" class="slider" min="1" max="3">';
				echo '</div>';

				// Price options
				echo '<div class="price-options">';
				echo '<div class="price-unit">' . $currency_symbol . ' ' . $unit_price . '</div>';
				echo '<div class="price-weight">' . $currency_symbol . ' ' . $weight_price . '</div>';
				echo '<div class="price-main">' . $currency_symbol . ' ' . $main_price . '</div>';
				echo '</div>';


				echo '<div class="product-hover">';
				echo '<div class="hover-overlay"></div>';
				echo '<div class="hover-content">';

				// Plus button
				echo '<button class="plus">+</button>';

				// Counter
				echo '<div class="counter">0</div>';

				// Minus button
				echo '<button class="minus">-</button>';

				// Toggle switch
				echo '<label class="switch">';
				echo '<input type="checkbox" class="price-toggle">';
				echo '<span class="slider"></span>';
				echo '</label>';

				echo '</div>';
				echo '<form class="cart" action="' . esc_url(wc_get_cart_url()) . '" method="post">';
				echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($product_id) . '" />';
				echo '<input type="number" class="quantity" name="quantity" value="1" />';
				echo '<button type="submit" class="single_add_to_cart_button button alt">Add to Cart</button>';
				echo '</form>';
				echo '</div>';
				echo '</div>';
			}

			echo '</div>';
		}

		wp_reset_postdata();
	}
}
