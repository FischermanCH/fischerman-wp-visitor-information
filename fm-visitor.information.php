<?php
/*
Plugin Name: FM-Visitor-Information
Description: Shows visitor information.Use "[visitor_info]" shortcode in your WordPress content to display visitor information. There is also a Widget available and you can even configure it ;-)
Version: 1.0
Author: Fischerman.ch
Author URI: https://www.fischerman.ch
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/

// Shortcode function to display visitor information
function display_visitor_information() {
    $visitorInfo = array(
        'IP Address' => $_SERVER['REMOTE_ADDR'],
        'User Agent' => $_SERVER['HTTP_USER_AGENT'],
        'Screen Size' => $_SERVER['HTTP_SCREEN_SIZE'],
        'Language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
        'Referring URL' => $_SERVER['HTTP_REFERER'],
        'Current Page URL' => $_SERVER['REQUEST_URI'],
        'Platform' => "<script>document.write(navigator.platform);</script>",
        'Cookie Enabled' => "<script>document.write(navigator.cookieEnabled);</script>",
        'Browser Code Name' => "<script>document.write(navigator.appCodeName);</script>",
        'Browser Name' => "<script>document.write(navigator.appName);</script>",
        'Browser Version' => "<script>document.write(navigator.appVersion);</script>",
        'Browser Language' => "<script>document.write(navigator.language);</script>",
        'Browser Online' => "<script>document.write(navigator.onLine);</script>",
        'Java Enabled' => "<script>document.write(navigator.javaEnabled());</script>",
        'Screen Color Depth' => "<script>document.write(screen.colorDepth);</script>",
        'Screen Pixel Depth' => "<script>document.write(screen.pixelDepth);</script>",
        'Screen Width' => "<script>document.write(screen.width);</script>",
        'Screen Height' => "<script>document.write(screen.height);</script>",
        'Window Width' => "<script>document.write(window.innerWidth);</script>",
        'Window Height' => "<script>document.write(window.innerHeight);</script>"
    );

    $output = '<div id="visitor-info">';
    $output .= '<table class="visitor-info-table">';
    foreach ($visitorInfo as $key => $value) {
        $output .= '<tr>';
        $output .= '<td>' . $key . '</td>';
        $output .= '<td>' . $value . '</td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '</div>';

    return $output;
}
add_shortcode('visitor_info', 'display_visitor_information');

// Widget class for FM Visitor Information
class FM_Visitor_Information_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'fm_visitor_information_widget',
            'FM Visitor Information',
            array('description' => 'Displays visitor information')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
        $selectedInfo = $instance['info'];
        $visitorInfo = array(
            'IP Address' => $_SERVER['REMOTE_ADDR'],
            'User Agent' => $_SERVER['HTTP_USER_AGENT'],
            'Screen Size' => $_SERVER['HTTP_SCREEN_SIZE'],
            'Language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
            'Referring URL' => $_SERVER['HTTP_REFERER'],
            'Current Page URL' => $_SERVER['REQUEST_URI'],
            'Platform' => "<script>document.write(navigator.platform);</script>",
            'Cookie Enabled' => "<script>document.write(navigator.cookieEnabled);</script>",
            'Browser Code Name' => "<script>document.write(navigator.appCodeName);</script>",
            'Browser Name' => "<script>document.write(navigator.appName);</script>",
            'Browser Version' => "<script>document.write(navigator.appVersion);</script>",
            'Browser Language' => "<script>document.write(navigator.language);</script>",
            'Browser Online' => "<script>document.write(navigator.onLine);</script>",
            'Java Enabled' => "<script>document.write(navigator.javaEnabled());</script>",
            'Screen Color Depth' => "<script>document.write(screen.colorDepth);</script>",
            'Screen Pixel Depth' => "<script>document.write(screen.pixelDepth);</script>",
            'Screen Width' => "<script>document.write(screen.width);</script>",
            'Screen Height' => "<script>document.write(screen.height);</script>",
            'Window Width' => "<script>document.write(window.innerWidth);</script>",
            'Window Height' => "<script>document.write(window.innerHeight);</script>"
        );
        ?>
        <div id="visitor-info">
            <table class="visitor-info-table">
                <?php foreach ($visitorInfo as $key => $value) : ?>
                    <?php if (in_array($key, $selectedInfo)) : ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $selectedInfo = isset($instance['info']) ? $instance['info'] : array();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label>Information:</label><br>
            <?php
            $visitorInfo = array(
                'IP Address' => 'IP Address',
                'User Agent' => 'User Agent',
                'Screen Size' => 'Screen Size',
                'Language' => 'Language',
                'Referring URL' => 'Referring URL',
                'Current Page URL' => 'Current Page URL',
                'Platform' => 'Platform',
                'Cookie Enabled' => 'Cookie Enabled',
                'Browser Code Name' => 'Browser Code Name',
                'Browser Name' => 'Browser Name',
                'Browser Version' => 'Browser Version',
                'Browser Language' => 'Browser Language',
                'Browser Online' => 'Browser Online',
                'Java Enabled' => 'Java Enabled',
                'Screen Color Depth' => 'Screen Color Depth',
                'Screen Pixel Depth' => 'Screen Pixel Depth',
                'Screen Width' => 'Screen Width',
                'Screen Height' => 'Screen Height',
                'Window Width' => 'Window Width',
                'Window Height' => 'Window Height'
            );
            foreach ($visitorInfo as $key => $label) :
                $checked = in_array($key, $selectedInfo) ? 'checked' : '';
                ?>
                <input type="checkbox" id="<?php echo $this->get_field_id('info'); ?>" name="<?php echo $this->get_field_name('info'); ?>[]" value="<?php echo esc_attr($key); ?>" <?php echo $checked; ?>>
                <label for="<?php echo $this->get_field_id('info'); ?>"><?php echo $label; ?></label><br>
            <?php endforeach; ?>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['info'] = isset($new_instance['info']) ? array_map('sanitize_text_field', $new_instance['info']) : array();

        return $instance;
    }
}

// Register FM Visitor Information Widget
function fm_register_visitor_information_widget() {
    register_widget('FM_Visitor_Information_Widget');
}
add_action('widgets_init', 'fm_register_visitor_information_widget');
