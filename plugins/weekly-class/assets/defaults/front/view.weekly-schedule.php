<?php
add_filter( 'wcs_view_css', 'wcs_view_css_weekly_schedule', 10, 3 );
add_filter( 'wcs_stop', 'wcs_default_stop_date_weekly_schedule' , 20, 2 );
add_filter( 'wcs_start', 'wcs_default_start_date_weekly_schedule' , 20, 2 );
add_filter( 'wcs_schedule_limit', 'wcs_default_limit_weekly_schedule', 20, 2 );

function wcs_default_limit_weekly_schedule( $limit, $data ){
  if( ! isset( $data['view'] ) ||  intval( $data['view'] ) !== 3 ) return $limit;
  return 0;
}

function wcs_default_start_date_weekly_schedule( $date, $data ){

  if( ! isset( $data['view'] ) ||  intval( $data['view'] ) !== 3 )
    return $date;

  $date = current_time('timestamp');

  $first_day = intval( get_option( 'start_of_week') );

  $days = array(
    0 => 'Sunday',
    1 => "Monday",
    2 => 'Tuesday',
    3 => 'wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday'
  );

  /* With past events */
  if( isset( $data['show_past_events'] ) && wp_validate_boolean( $data['show_past_events'] ) ){
    if( isset( $data['show_navigation'] ) && wp_validate_boolean( $data['show_navigation'] ) ){
      $date = strtotime("last {$days[$first_day]}", $date);
    }
  }

  /* Future events */
  else {
    $date = current_time('timestamp') + 1 * DAY_IN_SECONDS;

    if( isset( $data['show_navigation'] ) && wp_validate_boolean( $data['show_navigation'] ) ){
      $date = strtotime("last {$days[$first_day]}", $date);
    }

  }

  return $date;
}

function wcs_default_stop_date_weekly_schedule( $date, $data ){

  if( ! isset( $data['view'] ) ||  intval( $data['view'] ) !== 3 )
    return $date;

  $date = current_time('timestamp') + 6 * DAY_IN_SECONDS;

  $first_day = intval( get_option( 'start_of_week') );

  $days = array(
    0 => 'Sunday',
    1 => "Monday",
    2 => 'Tuesday',
    3 => 'wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday'
  );

  if( isset( $data['show_past_events'] ) && wp_validate_boolean( $data['show_past_events'] ) ){
    if( isset( $data['show_navigation'] ) && wp_validate_boolean( $data['show_navigation'] ) ){
      $date = strtotime("last {$days[$first_day]}", current_time('timestamp'));
      $date = $date + 6 * DAY_IN_SECONDS;
    }
  } else {
    $date = current_time('timestamp') + 7 * DAY_IN_SECONDS;

    if( isset( $data['show_navigation'] ) && wp_validate_boolean( $data['show_navigation'] ) ){
      $date = strtotime("last {$days[$first_day]}", current_time('timestamp'));
      $date = $date + 6 * DAY_IN_SECONDS;
    }
  }

  return $date;
}

function wcs_view_css_weekly_schedule( $css, $data, $schedule_id ){

  if( ! isset( $data['view'] ) ||  intval( $data['view'] ) !== 3 )
    return $css;

  /** Basic */
  $color_special = isset( $data['color_special'] ) && ! empty( $data['color_special'] ) && $data['color_special'] !== 'undefined' ? $data['color_special'] : '#BF392B';
  $css .= "
    .wcs-timetable--$schedule_id .wcs-timetable__week .wcs-class__duration{
      color: $color_special;
    }
    .wcs-timetable--$schedule_id .wcs-timetable__week .wcs-day__title{
      background-color: $color_special;
      color: " . CurlyWeeklyClassShortcodes::contrast( $color_special, 1, 0.75 ) . ";
    }
  ";

  /** Weekdays */
  $weekdays = array();
  for( $i= 1; $i <= 7; $i++){
    if( isset( $data['color_days_0' . $i] ) && ! empty( $data['color_days_0' . $i] ) && $data['color_days_0' . $i] !== 'undefined' ){
      $weekdays[$i === 7 ? 0 : $i] = $data['color_days_0' . $i];
    }
  }
  if( ! empty( $weekdays ) ){
    foreach( $weekdays as $key => $day_color ){
      $key  = $key === 0 ? 7 : $key;
      $css .= ! empty( $day_color ) ? "
        .wcs-timetable--$schedule_id .wcs-timetable--week .wcs-day--$key .wcs-class{
          background-color:{$day_color};
          color: " . CurlyWeeklyClassShortcodes::contrast( $day_color, 1, 0.75 ) . "
        }
        .wcs-timetable--$schedule_id .wcs-timetable--week .wcs-day--$key .wcs-class__title{
          color: " . CurlyWeeklyClassShortcodes::contrast( $day_color, 1, 0.75 ) . "
        }
      " : '';
    }
  }
  /** Terms */
  foreach( $data['terms_colors'] as $term_id => $term_color ){
    if( ! empty( $term_color ) && $term_color !== 'undefined' ){
      $css .= ".wcs-timetable--$schedule_id .wcs-timetable--week .wcs-day .wcs-class--term-id-$term_id{
        background-color:{$term_color};
        color: " . CurlyWeeklyClassShortcodes::contrast( $term_color, 1, 0.85 ) . "
      }
      .wcs-timetable--$schedule_id .wcs-timetable--week .wcs-day .wcs-class--term-id-$term_id .wcs-class__duration,
      .wcs-timetable--$schedule_id .wcs-timetable--week .wcs-day .wcs-class--term-id-$term_id .wcs-class__title{
        color: " . CurlyWeeklyClassShortcodes::contrast( $term_color, 1, 0.85 ) . "
      }";
    }
  }

  return $css;
}
?>
