<?php

extract(
	shortcode_atts(
		array(
			'filter_areas' => '',
			'price_range'  => '',
			'hide_empty'   => '',
			'query_type'   => 'or',
			'submit_class' => '',
			'submit_value' => '',
			'el_class'     => '',
		),
		$atts
	)
);

$el_class = porto_shortcode_extract_class( $el_class );

if ( ! $filter_areas ) {
	return;
}

echo '<form action="' . wc_get_page_permalink( 'shop' ) . '" method="get" class="porto_products_filter_form">';

$filter_areas = explode( ',', $filter_areas );
foreach ( $filter_areas as $area ) {
	$area = trim( $area );
	if ( 'category' == $area ) {
		wc_product_dropdown_categories(
			apply_filters(
				'porto_products_filter_categories_dropdown_args',
				array(
					'show_count'         => true,
					'hierarchical'       => true,
					'hide_empty'         => $hide_empty ? true : false,
					'show_uncategorized' => 0,
				)
			)
		);
	} elseif ( 'price' == $area && class_exists( 'Porto_WC_Widget_Price_Filter' ) ) {
		$steps = array();
		if ( $price_range ) {
			$price_range = explode( ',', trim( $price_range ) );
			foreach ( $price_range as $range ) {
				$range = explode( '-', trim( $range ) );
				if ( 1 === count( $range ) ) {
					$steps[] = array( trim( $range[0] ) );
				} elseif ( 2 === count( $range ) ) {
					if ( trim( $range[1] ) ) {
						$steps[] = array( trim( $range[0] ), trim( $range[1] ) );
					} else {
						$steps[] = array( trim( $range[0] ) );
					}
				}
			}
		}
		if ( empty( $steps ) ) {
			$prices = Porto_WC_Widget_Price_Filter::get_instance()->get_filtered_price();
			if ( $prices->min_price < 1 ) {
				$min = 0;
			} else {
				$min_base = pow( 10, strlen( floor( $prices->min_price ) ) );
				$min      = ceil( $prices->min_price / $min_base ) * $min_base / 10;
			}
			if ( $prices->max_price < 1 ) {
				$max = 1;
			} else {
				$max_base = pow( 10, strlen( floor( $prices->max_price ) ) );
				$max      = ceil( $prices->max_price / $max_base ) * $max_base;
			}
			for( $step = $min; $step < $max; $step = $step * 10 ) {
				$steps[] = array( $step, $step * 10 );
			}
		}
		$steps = apply_filters( 'porto_products_filter_price_range', $steps );
		echo '<select class="porto_dropdown_price_range" name="min_price">';
			echo '<option value="">' . esc_html__( 'Price Range', 'porto-functionality' ) . '</option>';
			foreach( $steps as $step ) {
				echo '<option value="'. esc_attr( $step[0] ) . '"' . ( isset( $step[1] ) ? ' data-maxprice="' . esc_attr( $step[1] ) . '"' : '' ) . '>' . apply_filters( 'porto_products_filter_price_range_html', esc_attr( $step[0] ) . ' - ' . ( isset( $step[1] ) ? esc_attr( $step[1] ) : '' ), $step ) . '</option>';
			}
		echo '</select>';
	} else {
		$taxonomy = wc_attribute_taxonomy_name( $area );
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}
		$get_terms_args = array();
		if ( $hide_empty ) {
			$get_terms_args['hide_empty'] = '1';
		}

		$orderby = wc_attribute_orderby( $taxonomy );

		switch ( $orderby ) {
			case 'name':
				$get_terms_args['orderby']    = 'name';
				$get_terms_args['menu_order'] = false;
				break;
			case 'id':
				$get_terms_args['orderby']    = 'id';
				$get_terms_args['order']      = 'ASC';
				$get_terms_args['menu_order'] = false;
				break;
			case 'menu_order':
				$get_terms_args['menu_order'] = 'ASC';
				break;
		}

		$terms = get_terms( $taxonomy, $get_terms_args );

		if ( 0 === count( $terms ) ) {
			continue;
		}

		switch ( $orderby ) {
			case 'name_num':
				usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
				break;
			case 'parent':
				usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
				break;
		}

		echo '<select class="porto_dropdown_product_attributes" name="filter_' . esc_attr( $area ) . '">';
			echo '<option value="">' . sprintf( esc_html__( 'By %s', 'porto-functionality' ), esc_html( $area ) ) . '</option>';
		foreach ( $terms as $term ) {
			$option_is_set = false;
			echo '<option data-url="' . esc_url( get_term_link( $term ) ) . '" value="' . esc_attr( urldecode( $term->slug ) ) . '" ' . selected( $option_is_set, true, false ) . '>' . esc_html( $term->name ) . '</option>';
		}
		echo '</select>';
	}
}

echo '<button type="button" class="btn-submit' . ( $submit_class ? ' ' . esc_attr( trim( $submit_class ) ) : '' ) . '">' . esc_html( $submit_value ? $submit_value : __( 'Submit', 'porto-functionality' ) ) . '</button>';

echo '</form>';
