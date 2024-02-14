<?php

namespace JakooTopBar;

require_once 'constants.php';
require_once 'function_helper.php';

class JakooTopBar {
    function __construct()
    {
        add_filter('plugin_action_links', [$this, 'add_action_links'], 10, 2);
        add_action('admin_menu', [$this, 'jakoo_topbar_create_menus']);
        add_action('admin_init', [$this, 'jakoo_topbar_option_group_settings']);
        // Add code after opening body tag.

        add_action( 'wp_body_open', [$this, 'jakoo_add_prepend_topbar_html_to_body_tag']);
        add_action( 'wp_enqueue_scripts', [$this, 'jakoo_front_end_script']);
    }

    function jakoo_front_end_script() {
        wp_enqueue_script( 'jakoo-topbar-frontend', plugins_url('/frontend.js', __FILE__), array('jquery'), true, true);
    }

    private function getRandomQoute() {
        $endpoint = 'https://api.quotable.io/quotes/random?tags=famous-quotes';
        $data = json_decode(wp_remote_get($endpoint)['body'], true);
        $result = 'Unable to fetch random quote at the moment';
        if(!empty($data[0]) && !empty($data[0]['content']) && !empty($data[0]['author'])) {
            $result = '"' . $data[0]['content'] . '" - <i><small>' . $data[0]['author'] . '</small></i>';
        }
        return $result;
    }

    function add_action_links ( $links, $file ) {
        $thisFile = basename(__FILE__);
        if ('JakooTopBar.php' == $thisFile) {
            $l = '<a href="' . admin_url("options-general.php?page=jakoo-topbar") . '">Settings</a>';
            array_unshift($links, $l);
        }
        return $links;
    }

    function jakoo_add_prepend_topbar_html_to_body_tag() {
        $type = get_option('jakoo_topbar_type') ?: 'free_text';
        $text = get_option('jakoo_topbar_text');
        $bg_color = get_option('jakoo_topbar_bg_color') ?: '#000000';
        $text_color = get_option('jakoo_topbar_text_color') ?: '#FFFFFF';
        $font_size = get_option('jakoo_topbar_text_size') ?: 12;
        $padding = get_option('jakoo_topbar_padding') ?: 10;

        $topbar_final_text = ($type == 'random_quotes') ? $this->getRandomQoute() : $text;

        if(current_user_can('administrator')){
            $topbar_final_text .= ' &nbsp; <a style="color: ' . $text_color . '; font-size: 11px;" href="' . admin_url('admin.php?page=jakoo-topbar') . '" target="_blank">Edit Topbar</a>';
        }

        echo '
                <style type="text/css">
                    .jakoo-topbar-fe{ 
                        padding: ' . $padding . 'px; 
                        background-color: ' . $bg_color . '; 
                        color: ' . $text_color . '; 
                        text-align: center; 
                        font-size: ' . $font_size . 'px; 
                    }
                </style> 
                <script type="text/javascript">
                    window[\'jakooTopbarType\'] = \'' . $type . '\';
                    window[\'jakooTopBarFinalText\'] = \'' . $topbar_final_text . '\';
                </script>
                <div class="jakoo-topbar-fe"></div>';
    }

    function jakoo_topbar_option_group_settings() {
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_type' );
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_text' );
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_text_size' );
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_bg_color' );
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_text_color' );
        register_setting( 'jakoo_topbar_option_group', 'jakoo_topbar_padding' );
    }

    function jakoo_topbar_create_menus() {
        add_menu_page(PLUGIN_MENU_TITLE, PLUGIN_MENU_TITLE, PLUGIN_ROLE, PLUGIN_SLUG, [$this, 'jakoo_topbar_create_page'], PLUGIN_ICON, PLUGIN_POSITION);
    }

    private function loadTemplate($name) {
        if(file_exists(dirname(__FILE__) . '/templates/' . $name . '.php')) {
            require_once dirname(__FILE__) . '/templates/' . $name . '.php';
        } else {
            add_action('admin_notices', [$this, static::throw_err('Template was not found.')]);
        }
    }

    function jakoo_topbar_create_page() {
        wp_register_script( 'my_plugin_script', plugins_url('/settings.js', __FILE__), array('jquery'));
        wp_enqueue_script( 'my_plugin_script' );

        $this->loadTemplate('plugin_settings');

    }

    protected static function throw_err($message) {
        ?>
        <div class="notice notice-error">
            <p><?php echo $message; ?></p>
        </div>
        <?php
    }
}

new JakooTopBar();