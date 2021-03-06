<?php

$banner_title              = $banner_desc = $banner_image = $banner_link = $banner_style = $el_class = '';
$banner_title_font_size    = '';
$banner_title_style_inline = $banner_desc_style_inline = $banner_color_bg = $banner_color_title = $banner_color_desc = $banner_title_bg = '';

$animation_type     = '';
$animation_delay    = '';
$animation_duration = '';

$image_opacity = $image_opacity_on_hover = $target = $link_title  = $rel = '';
extract(
	shortcode_atts(
		array(
			'banner_title'           => '',
			'banner_desc'            => '',
			'banner_image'           => '',
			'lazyload'               => '',
			'image_opacity'          => '1',
			'image_opacity_on_hover' => '1',
			'banner_style'           => '',
			'banner_title_font_size' => '',
			'banner_color_bg'        => '',
			'banner_color_title'     => '',
			'banner_color_desc'      => '',
			'banner_title_bg'        => '',
			'banner_link'            => '',
			'el_class'               => '',
			'css_ibanner'            => '',
			'className'              => '',
			'animation_type'         => '',
			'animation_duration'     => 1000,
			'animation_delay'        => 0,
		),
		$atts
	)
);

if ( $className ) {
	if ( $el_class ) {
		$el_class .= ' ' . $className;
	} else {
		$el_class = $className;
	}
}
if ( ( ! isset( $content ) || empty( $content ) ) && isset( $atts['content'] ) && ! empty( $atts['content'] ) ) {
	$content = $atts['content'];
}

$css_ib_styles = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_ibanner, ' ' ), 'porto_interactive_banner', $atts );
$css_ib_styles = esc_attr( $css_ib_styles );

$output = $target = $link = $banner_style_inline = $title_bg = $img_style = $target = '';

if ( $banner_title_bg && 'style2' == $banner_style ) {
	$title_bg .= 'background:' . esc_attr( $banner_title_bg ) . ';';
}

$img = '';
if ( $image_opacity && '1' != $image_opacity ) {
	$img_style .= 'opacity:' . esc_attr( $image_opacity ) . ';';
}
if ( $banner_image ) {
	global $porto_carousel_lazyload;
	$img_attr = array();
	if ( 'enable' === $lazyload || $lazyload ) {
		if ( isset( $porto_carousel_lazyload ) && true === $porto_carousel_lazyload ) {
			$img_attr['class'] = 'porto-ibanner-img owl-lazy';
		} else {
			wp_enqueue_script( 'jquery-lazyload' );

			$img_attr['class'] = 'porto-ibanner-img porto-lazyload';
		}
	} else {
		$img_attr['class'] = 'porto-ibanner-img';
	}
	if ( $img_style ) {
		$img_attr['style'] = $img_style;
	}
	if ( is_numeric( $banner_image ) ) {
		if ( 'enable' === $lazyload || $lazyload ) {
			$img_data = wp_get_attachment_image_src( $banner_image, 'full' );
			if ( $img_data ) {
				$placeholder               = porto_generate_placeholder( $img_data[1] . 'x' . $img_data[2] );
				$img_attr['src']           = esc_url( $placeholder[0] );
				$img_attr['data-original'] = esc_url( $img_data[0] );
			}
		}
		$img = wp_get_attachment_image( $banner_image, 'full', false, $img_attr );
	} else {
		if ( 'enable' === $lazyload || $lazyload ) {
			$placeholder               = porto_generate_placeholder( '1x1' );
			$img_attr['src']           = esc_url( $placeholder[0] );
			$img_attr['data-original'] = esc_url( $banner_image );
		} else {
			$img_attr['src'] = esc_url( $banner_image );
		}
		$img_attr_html = '';
		foreach ( $img_attr as $name => $value ) {
			$img_attr_html .= " $name=" . '"' . $value . '"';
		}
		$img = '<img alt=""' . $img_attr_html . ' />';
	}
}

if ( $banner_link ) {
	$href = vc_build_link( $banner_link );
	if ( ! empty( $href['url'] ) ) {
		$link       = ( isset( $href['url'] ) && $href['url'] ) ? $href['url'] : '';
		$target     = ( isset( $href['target'] ) && $href['target'] ) ? "target='" . esc_attr( trim( $href['target'] ) ) . "'" : '';
		$link_title = ( isset( $href['title'] ) && $href['title'] ) ? "title='" . esc_attr( $href['title'] ) . "'" : '';
		$rel        = ( isset( $href['rel'] ) && $href['rel'] ) ? "rel='" . esc_attr( $href['rel'] ) . "'" : '';
	} else {
		$link = $banner_link;
	}
} else {
	$link = '#';
}

if ( ! is_numeric( $banner_title_font_size ) ) {
	$banner_title_font_size = preg_replace( '/[^0-9]/', '', $banner_title_font_size );
}
if ( $banner_title_font_size ) {
	$banner_title_style_inline .= 'font-size: ' . esc_attr( $banner_title_font_size ) . 'px;';
}

$interactive_banner_id = 'interactive-banner-wrap-' . rand( 1000, 9999 );

if ( $banner_color_bg ) {
	$banner_style_inline .= 'background:' . esc_attr( $banner_color_bg ) . ';';
}

if ( $banner_color_title ) {
	$banner_title_style_inline .= 'color:' . esc_attr( $banner_color_title ) . ';';
}

if ( $banner_color_desc ) {
	$banner_desc_style_inline .= 'color:' . esc_attr( $banner_color_desc ) . ';';
}

if ( '#' !== $link ) {
	$href = 'href="' . esc_url( $link ) . '"';
} else {
	$href = '';
}

$heading_tag = 'h2';

$opacity_attr = '';
if ( $image_opacity != $image_opacity_on_hover ) {
	$opacity_attr .= ' data-opacity="' . esc_attr( $image_opacity ) . '" data-hover-opacity="' . esc_attr( $image_opacity_on_hover ) . '"';
}
if ( $animation_type ) {
	$opacity_attr .= ' data-appear-animation="' . esc_attr( $animation_type ) . '"';
	if ( $animation_delay ) {
		$opacity_attr .= ' data-appear-animation-delay="' . esc_attr( $animation_delay ) . '"';
	}
	if ( $animation_duration && 1000 != $animation_duration ) {
		$opacity_attr .= ' data-appear-animation-duration="' . esc_attr( $animation_duration ) . '"';
	}
}

$output .= '<div class="porto-ibanner ' . ( $banner_style ? 'porto-ibanner-effect-' . esc_attr( $banner_style ) : '' ) . ' ' . esc_attr( $el_class ) . ' ' . esc_attr( $css_ib_styles ) . '" style="' . esc_attr( $banner_style_inline ) . '"' . $opacity_attr . '>';
if ( $img ) {
	$output .= $img;
}
if ( $banner_title || $banner_desc || $content ) {
	$output .= '<div id="' . esc_attr( $interactive_banner_id ) . '" class="porto-ibanner-desc" style="' . esc_attr( $title_bg ) . '">';
	if ( $banner_title ) {
		$output .= '<' . $heading_tag . ' class="porto-ibanner-title" style="' . esc_attr( $banner_title_style_inline ) . '">' . do_shortcode( $banner_title ) . '</' . $heading_tag . '>';
	}
	$output .= '<div class="porto-ibanner-content" style="' . esc_attr( $banner_desc_style_inline ) . '">' . do_shortcode( $banner_desc ? $banner_desc : $content ) . '</div>';
	$output .= '</div>';
}
if ( $href ) {
	$output .= '<a class="porto-ibanner-link" ' . $href . ' ' . $target . ' ' . $link_title . ' ' . $rel . '></a>';
}
$output .= '</div>';

echo porto_filter_output( $output );
