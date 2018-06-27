<?php
add_shortcode('share_buttons', 'share_buttons_render');
function share_buttons_render($attrs) {
  extract(shortcode_atts (array(
    'print_icon' => 1
  ), $attrs));

  ob_start();
    $context                = Timber::get_context();
    $context['permalink']   = urlencode(get_the_permalink());
    $context['title']       = urlencode(get_the_title());
    $context['print_icon']  = $print_icon;
    try {
    Timber::render( array( 'social-detail.twig'), $context );
    } catch (Exception $e) {
      echo 'Could not find a twig file for Shortcode Name: social-detail.twig';
    }
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}

// --> Disable term format shortcode
add_shortcode( 'customtax', 'create_customtax' );
function create_customtax($attrs) {
  extract(shortcode_atts (array(
    'tax_name' => ''
  ), $attrs));
  ob_start();
    taxvalue($tax = $tax_name); // This function in theme-init.php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

// Time bby Locate
add_shortcode( 'time_by_locate', 'create_time_by_locate' );
function create_time_by_locate($attrs) {
  extract(shortcode_atts (array(
    'tax_name' => ''
  ), $attrs));
  ob_start();
    // Get IP address
    $ip_address = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');

    // Get JSON object
    $jsondata = file_get_contents("http://timezoneapi.io/api/ip/?" . $ip_address);

    // Decode
    $data = json_decode($jsondata, true);

    print_r($data);
    /*// Request OK?
    if($data['meta']['code'] == '200'){

      // Example: Get the city parameter
      echo "City: " . $data['data']['city'] . "<br>";

      // Example: Get the users time
      echo "Time: " . $data['data']['datetime']['date_time_txt'] . "<br>";

    }*/
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
