<?php
/**
 * Provides functions and filters related
 * to the UCF Section plugin
 */
namespace Diversity\Theme\Includes\Sections;


/**
 * Returns markup for all headings and items for courses
 * (sections with layout = 'courses')
 *
 * @author Cadie Stockman
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_course( $section ) {
	$retval = '';

	// Back out early if this section isn't courses, or is empty:
	if (
		get_field( 'section_layout', $section ) !== 'courses'
		|| ! have_rows( 'courses', $section )
	) {
		return $retval;
	}

	$course_num = 0;

	while( have_rows( 'courses', $section ) ) : $course = the_row();
		$course_num++;
		$course_title = get_sub_field( 'course_title' );
		$course_information = get_sub_field( 'course_information' );

		ob_start();
	?>
	<div class="card card-secondary">
		<div class="card-header" role="tab" id="courseHeading<?php echo $course_num; ?>">
			<h3 class="h5 mb-0">
				<a data-toggle="collapse" href="#courseCollapse<?php echo $course_num; ?>" aria-expanded="true" aria-controls="courseCollapse<?php echo $course_num; ?>">
				<?php echo $course_title; ?>
				</a>
			</h3>
			</div>
			<div id="courseCollapse<?php echo $course_num; ?>" class="collapse" role="tabpanel" aria-labelledby="courseHeading<?php echo $course_num; ?>" data-parent="#coursesAccordion">
			<div class="card-block">
				<?php echo $course_information; ?>
			</div>
		</div>
	</div>

	<?php
		$retval .= trim( ob_get_clean() );

	endwhile;

	return $retval;
}


/**
 * Returns opening markup for courses
 * (sections with layout = 'courses')
 *
 * @author Cadie Stockman
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_courses_before( $section ) {
	if ( get_field( 'section_layout', $section ) !== 'courses' ) {
		return '';
	}

	return '<div id="coursesAccordion" role="tablist">';
}


/**
 * Returns closing markup for courses
 * (sections with layout = 'courses')
 *
 * @author Cadie Stockman
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_courses_after( $section ) {
	if ( get_field( 'section_layout', $section ) !== 'courses' ) {
		return '';
	}

	return '</div>';
}


/**
 * Returns complete markup for courses (sections with layout = 'courses')
 *
 * @since 1.0.0
 * @author Cadie Stockman
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_courses( $section ) {
	ob_start();

	echo display_courses_before( $section );
	echo display_course( $section );
	echo display_courses_after( $section );

	return trim( ob_get_clean() );
}


/**
 * Returns markup for all headings and items in a timeline
 * (sections with layout = 'timeline')
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @author Jo Dickson: FinAid-Child-Theme
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_timeline_items( $section ) {
	$retval = '';

	// Back out early if this section isn't a timeline, or is empty:
	if (
		get_field( 'section_layout', $section ) !== 'timeline'
		|| ! have_rows( 'timeline_item', $section )
	) {
		return $retval;
	}

	while( have_rows( 'timeline_item', $section ) ) : $timeline_item = the_row();
		$heading = get_sub_field( 'heading' );
		$retval .= "<dt class=\"timeline-heading\">$heading</dt>";
		if ( have_rows( 'bullets' ) ) {
			while( have_rows( 'bullets' ) ) : $bullet_data = the_row();
				// Remove paragraphs from inner bullet contents
				$wpautop_priority = has_filter( 'the_content', 'wpautop' );
				remove_filter( 'the_content', 'wpautop', $wpautop_priority );
				$bullet = nl2br( get_sub_field( 'bullet' ) );
				add_filter( 'the_content', 'wpautop', $wpautop_priority );

				if ( $bullet ) {
					$retval .= "<dd class=\"timeline-content\">$bullet</dd>";
				}
			endwhile;
		}
	endwhile;

	return $retval;
}


/**
 * Returns opening markup for a timeline
 * (sections with layout = 'timeline')
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @author Jo Dickson: FinAid-Child-Theme
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_timeline_before( $section ) {
	if ( get_field( 'section_layout', $section ) !== 'timeline' ) {
		return '';
	}

	return '<dl class="timeline">';
}


/**
 * Returns closing markup for a timeline
 * (sections with layout = 'timeline')
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @author Jo Dickson: FinAid-Child-Theme
 * @since 1.0.0
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_timeline_after( $section ) {
	if ( get_field( 'section_layout', $section ) !== 'timeline' ) {
		return '';
	}

	return '</dl>';
}


/**
 * Returns complete markup for a timeline (sections with layout = 'timeline')
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param WP_Post $section Section object
 * @return string HTML markup
 */
function display_timeline( $section ) {
	ob_start();

	echo display_timeline_before( $section );
	echo display_timeline_items( $section );
	echo display_timeline_after( $section );

	return trim( ob_get_clean() );
}


/**
 * Returns opening markup around a section, depending on the
 * given section's layout.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param string $retval The unfiltered return value
 * @param WP_Post $section The section object
 * @param string $class The class to use when displaying the section
 * @param string $title The title the display
 * @param string $section_id The section id to use
 * @return string HTML markup
 */
function display_section_before( $retval, $section, $class, $title, $section_id ) {
	$layout = get_field( 'section_layout', $section );
	switch ( $layout ) {
		case 'courses':
			$retval = display_courses_before( $section );
			break;
		case 'timeline':
			$retval = display_timeline_before( $section );
			break;
		case 'default':
		default:
			$retval = \UCF_Section_Common::ucf_section_display_before( $section, $class, $title, $section_id );
			break;
	}

	return $retval;
}

add_filter( 'ucf_section_display_before', __NAMESPACE__ . '\display_section_before', 11, 5 );


/**
 * Returns inner section markup, depending on the given section's layout.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param string $retval The unfiltered return value
 * @param WP_Post $section The section object
 * @return string HTML markup
 */
function display_section_content( $retval, $section ) {
	$layout = get_field( 'section_layout', $section );
	switch ( $layout ) {
		case 'courses':
			$retval = display_course( $section );
			break;
		case 'timeline':
			$retval = display_timeline_items( $section );
			break;
		case 'default':
		default:
			$retval = \UCF_Section_Common::ucf_section_display( $section );
			break;
	}

	return $retval;
}

add_filter( 'ucf_section_display', __NAMESPACE__ . '\display_section_content', 11, 2 );


/**
 * Returns closing markup around a section, depending on the
 * given section's layout.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param string $retval The unfiltered return value
 * @param WP_Post $section The section object
 * @return string HTML markup
 */
function display_section_after( $retval, $section ) {
	$layout = get_field( 'section_layout', $section );
	switch ( $layout ) {
		case 'courses':
			$retval = display_courses_after( $section );
			break;
		case 'timeline':
			$retval = display_timeline_after( $section );
			break;
		case 'default':
		default:
			$retval = \UCF_Section_Common::ucf_section_display_after( $section );
			break;
	}

	return $retval;
}

add_filter( 'ucf_section_display_after', __NAMESPACE__ . '\display_section_after', 11, 2 );


/**
 * Adds helpful columns to the All Sections admin view.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param array $columns Column data
 * @return array Modified column data
 */
function add_columns( $columns ) {
	$columns['layout'] = 'Layout';
	return $columns;
}

add_filter( 'manage_ucf_section_posts_columns', __NAMESPACE__ . '\add_columns' );
add_filter( 'manage_edit-ucf_section_sortable_columns', __NAMESPACE__ . '\add_columns' );


/**
 * Adds data to columns in the All Sections admin view.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param string $column Column name
 * @param int $post_id Post ID
 * @return void
 */
function add_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'layout':
			$field = get_field_object( 'field_5d9239967f3ed' ); // section_layout key
			$layout = get_field( 'section_layout', $post_id ) ?: 'default';
			// For whatever reason the layout value is sometimes
			// an array; handle that here:
			if ( is_array( $layout ) ) {
				$layout = $layout[0];
			}
			echo $field['choices'][$layout];
			break;
	}
}

add_action( 'manage_ucf_section_posts_custom_column', __NAMESPACE__ . '\add_column_data', 10, 2 );


/**
 * Adds sorting capabilities to custom admin columns.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param array $vars Query vars
 * @return array Modified query vars
 */
function add_column_ordering( $vars ) {
	if (
		isset( $vars['post_type'] )
		&& $vars['post_type'] === 'ucf_section'
		&& isset( $vars['orderby'] )
		&& $vars['orderby'] === 'Layout'
	) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'section_layout',
			'orderby'  => 'meta_value'
		) );
	}

	return $vars;
}

add_filter( 'request', __NAMESPACE__ . '\add_column_ordering' );

