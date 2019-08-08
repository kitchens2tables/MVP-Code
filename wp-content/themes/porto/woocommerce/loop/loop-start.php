<?php
/**
 * Product Loop Start
 *
 * @version     3.3.0
 */

global $porto_settings, $porto_layout, $woocommerce_loop, $porto_woocommerce_loop;
$cols         = $porto_settings['product-cols'];
$addlinks_pos = $porto_settings['category-addlinks-pos'];

if ( isset( $porto_woocommerce_loop['columns'] ) && $porto_woocommerce_loop['columns'] ) {
	$cols = $porto_woocommerce_loop['columns'];
} elseif ( isset( $woocommerce_loop['columns'] ) && $woocommerce_loop['columns'] ) {
	$cols = $woocommerce_loop['columns'];
}

$woocommerce_loop['product_loop'] = 0;
$woocommerce_loop['cat_loop']     = 0;

if ( in_array( $porto_layout, porto_options_sidebars() ) ) {
	if ( 8 == $cols || 7 == $cols ) {
		$cols = 6;
	}
}

$item_width = $cols;
if ( isset( $porto_woocommerce_loop['column_width'] ) && $porto_woocommerce_loop['column_width'] ) {
	$item_width = $porto_woocommerce_loop['column_width'];
} elseif ( isset( $woocommerce_loop['column_width'] ) && $woocommerce_loop['column_width'] ) {
	$item_width = $woocommerce_loop['column_width'];
}

$cols_arr = porto_generate_column_classes( $cols, true );
switch ( $cols ) {
	case 1:
		$cols_md = 1;
		$cols_xs = 1;
		$cols_ls = 1;
		break;
	case 2:
		$cols_md = 2;
		$cols_xs = 2;
		$cols_ls = 1;
		break;
	case 3:
		$cols_md = 3;
		$cols_xs = 2;
		$cols_ls = 1;
		break;
	case 4:
		$cols_md = 3;
		$cols_xs = 3;
		$cols_ls = 2;
		break;
	case 5:
		$cols_md = 4;
		$cols_xs = 3;
		$cols_ls = 2;
		break;
	case 6:
		$cols_md = 5;
		$cols_xs = 3;
		$cols_ls = 2;
		break;
	case 7:
		if ( porto_is_wide_layout( $porto_layout ) ) {
			$cols    = 6;
			$cols_xl = 7;
		}
		$cols_md = 5;
		$cols_xs = 3;
		$cols_ls = 2;
		break;
	case 8:
		if ( porto_is_wide_layout( $porto_layout ) ) {
			$cols    = 7;
			$cols_xl = 8;
		}
		$cols_md = 6;
		$cols_xs = 4;
		$cols_ls = 2;
		break;
	default:
		$cols    = 4;
		$cols_md = 3;
		$cols_xs = 2;
		$cols_ls = 1;
}

switch ( $item_width ) {
	case 1:
		$item_width_md = 1;
		$item_width_xs = 1;
		$item_width_ls = 1;
		break;
	case 2:
		$item_width_md = 2;
		$item_width_xs = 1;
		$item_width_ls = 1;
		break;
	case 3:
		$item_width_md = 3;
		$item_width_xs = 2;
		$item_width_ls = 1;
		break;
	case 4:
		$item_width_md = 3;
		$item_width_xs = 2;
		$item_width_ls = 1;
		break;
	case 5:
		$item_width_md = 4;
		if ( porto_is_wide_layout( $porto_layout ) ) {
			$item_width_xs = 3;
			$item_width_ls = 2;
		} else {
			$item_width_xs = 2;
			$item_width_ls = 1;
		}
		break;
	case 6:
		$item_width_md = 5;
		$item_width_xs = 3;
		$item_width_ls = 2;
		break;
	case 7:
		$item_width_md = 6;
		$item_width_xs = 3;
		$item_width_ls = 2;
		break;
	case 8:
		$item_width_md = 6;
		$item_width_xs = 3;
		$item_width_ls = 2;
		break;
	default:
		$item_width    = 4;
		$item_width_md = 3;
		$item_width_xs = 2;
		$item_width_ls = 1;
}

global $porto_shop_filter_layout;
if ( porto_is_ajax() && isset( $porto_shop_filter_layout ) && 'horizontal' === $porto_shop_filter_layout && isset( $_COOKIE['porto_horizontal_filter'] ) && 'opened' == $_COOKIE['porto_horizontal_filter'] ) {
	if ( $cols >= 2 ) {
		$cols--;
	}
	if ( $cols_md >= 2 ) {
		$cols_md--;
	}
	if ( $item_width >= 2 ) {
		$item_width--;
	}
	if ( $item_width_md >= 2 ) {
		$item_width_md--;
	}
}

if ( ! empty( $porto_woocommerce_loop['columns_mobile'] ) ) {
	$cols_ls = $porto_woocommerce_loop['columns_mobile'];
} elseif ( ! empty( $woocommerce_loop['columns_mobile'] ) ) {
	$cols_ls = $woocommerce_loop['columns_mobile'];
} elseif ( isset( $porto_settings['shop-product-cols-mobile'] ) && $porto_settings['shop-product-cols-mobile'] ) {
	$cols_ls = $porto_settings['shop-product-cols-mobile'];
}
if ( 1 === (int) $cols ) {
	$cols_ls = 1;
}

if ( ! isset( $woocommerce_loop['addlinks_pos'] ) || ! $woocommerce_loop['addlinks_pos'] ) {
	if ( isset( $porto_woocommerce_loop['addlinks_pos'] ) && $porto_woocommerce_loop['addlinks_pos'] ) {
		$woocommerce_loop['addlinks_pos'] = $porto_woocommerce_loop['addlinks_pos'];
	} else {
		$woocommerce_loop['addlinks_pos'] = $addlinks_pos;
	}
}

global $porto_products_cols_lg, $porto_products_cols_md, $porto_products_cols_xs, $porto_products_cols_ls;
$porto_products_cols_lg = $cols;
$porto_products_cols_md = $cols_md;
$porto_products_cols_xs = $cols_xs;
$porto_products_cols_ls = $cols_ls;

$classes = array( 'products', 'products-container' );
if ( isset( $porto_woocommerce_loop['widget'] ) && $porto_woocommerce_loop['widget'] ) {
	$classes[] = 'product_list_widget';
}

if ( isset( $porto_woocommerce_loop['view'] ) && $porto_woocommerce_loop['view'] ) {
	$classes[] = $porto_woocommerce_loop['view'];
	if ( 'products-slider' === $porto_woocommerce_loop['view'] ) {
		$classes[] = 'owl-carousel show-nav-title';
	}
}

if ( isset( $woocommerce_loop['category-view'] ) && $woocommerce_loop['category-view'] ) {
	$classes[] = $woocommerce_loop['category-view'];
}

if ( isset( $cols_xl ) ) {
	$classes[] = 'pcols-xl-' . $cols_xl;
}
$classes[] = 'pcols-lg-' . $cols;
$classes[] = 'pcols-md-' . $cols_md;
$classes[] = 'pcols-xs-' . $cols_xs;
$classes[] = 'pcols-ls-' . $cols_ls;
$classes[] = 'pwidth-lg-' . $item_width;
$classes[] = 'pwidth-md-' . $item_width_md;
$classes[] = 'pwidth-xs-' . $item_width_xs;
$classes[] = 'pwidth-ls-' . $item_width_ls;

$options                = array();
$options['themeConfig'] = true;
if ( isset( $porto_woocommerce_loop['view'] ) && 'products-slider' == $porto_woocommerce_loop['view'] ) {
	if ( isset( $cols_xl ) ) {
		$options['xl'] = (int) $cols_xl;
	}
	$options['lg'] = (int) $cols;
	$options['md'] = (int) $cols_md;
	$options['xs'] = (int) $cols_xs;
	$options['ls'] = (int) $cols_ls;
	if ( ! isset( $porto_woocommerce_loop['navigation'] ) || ( isset( $porto_woocommerce_loop['navigation'] ) && $porto_woocommerce_loop['navigation'] ) ) {
		$options['nav'] = true;
	}
	if ( isset( $porto_woocommerce_loop['pagination'] ) && $porto_woocommerce_loop['pagination'] ) {
		$options['dots'] = true;
	}
}
$options = json_encode( $options );

$attrs = '';
if ( wc_get_loop_prop( 'is_shortcode' ) && isset( $porto_settings['product-infinite'] ) && 'load_more' == $porto_settings['product-infinite'] ) {
	$cur_page  = absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] );
	$page_path = esc_url_raw( add_query_arg( 'product-page', '', false ) ) . '=';
	$attrs    .= ' data-cur_page="' . esc_attr( $cur_page ) . '" data-max_page="' . esc_attr( wc_get_loop_prop( 'total_pages' ) ) . '"';
} elseif ( porto_is_ajax() && isset( $porto_settings['product-infinite'] ) && $porto_settings['product-infinite'] ) {
	global $wp_rewrite, $wp_query;
	$page_num     = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$page_link    = get_pagenum_link();
	$page_max_num = $wp_query->max_num_pages;

	if ( ! $wp_rewrite->using_permalinks() || is_admin() || strpos( $page_link, '?' ) ) {
		if ( strpos( $page_link, '?' ) !== false ) {
			$page_path = apply_filters( 'get_pagenum_link', $page_link . '&amp;paged=pagenum' );
			$page_path = str_replace( 'paged=pagenum', 'paged=', $page_path );
		} else {
			$page_path = apply_filters( 'get_pagenum_link', $page_link . '?paged=' );
		}
	} else {
		$page_path = apply_filters( 'get_pagenum_link', $page_link . user_trailingslashit( $wp_rewrite->pagination_base . '/' ) );
	}
	$page_path = str_replace( '#038;', '&amp;', $page_path );
	$attrs    .= ' data-cur_page="' . esc_attr( $page_num ) . '" data-max_page="' . esc_attr( $page_max_num ) . '" data-page_path="' . esc_url( $page_path ) . '"';
}
?>
<ul class="<?php echo implode( ' ', $classes ); ?>"
	<?php if ( isset( $porto_woocommerce_loop['view'] ) && 'products-slider' == $porto_woocommerce_loop['view'] ) : ?>
	data-plugin-options="<?php echo esc_attr( $options ); ?>"<?php endif; ?><?php echo porto_filter_output( $attrs ); ?>>
