<?php
/*
Plugin Name: Affsquare
Description: Customize the header by changing the site logo.
Version: 1.0
Author: Abanoub
Author URI: https://abanoub.co/
*/

function affsquare_logo_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('affsquare_logo_section'); ?>
            <?php do_settings_sections('affsquare_logo_page'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function affsquare_logo_section_callback() {
    echo '<p>' . __('Choose your custom logo below:', 'affsquare') . '</p>';
}

function affsquare_logo_callback() {
    $logo_id = get_option('affsquare_logo_url', '');
    echo '<input type="text" id="affsquare_logo_url" name="affsquare_logo_url" value="' . $logo_id . '" style="width: 35%;"/>';
    echo '<button class="button" id="affsquare_logo_upload_button">Upload or choose from Media Library</button>';
    if ($logo_id) {
        echo '<br/><br/><img class="view_logo" src="' . $logo_id . '" alt="Current Logo" style="max-width: 300px; height: auto;" />';
    }
}

function affsquare_settings_page() {
    add_menu_page(
        'Affsquare Logo',
        'Affsquare Logo',
        'manage_options',
        'affsquare_logo',
        'affsquare_logo_page',
        'dashicons-welcome-write-blog'
    );

    add_action('admin_init', 'affsquare_settings');
}

function affsquare_settings() {
    register_setting(
        'affsquare_logo_section',
        'affsquare_logo_url',
        array(
            'type' => 'string',
            'sanitize_callback' => null,
        )
    );

    add_settings_section(
        'affsquare_logo_section',
        'Logo Settings',
        'affsquare_logo_section_callback',
        'affsquare_logo_page'
    );

    add_settings_field(
        'affsquare_logo_url',
        'Logo Image',
        'affsquare_logo_callback',
        'affsquare_logo_page',
        'affsquare_logo_section'
    );
}

add_action('admin_menu', 'affsquare_settings_page');


function affsquare_enqueue_media_library_modal_script() {
    wp_enqueue_media();
    wp_enqueue_script('affsquare-media-library-modal', plugins_url('media-library-modal.js', __FILE__), array('jquery'), '1.0', true);
}

add_action('admin_enqueue_scripts', 'affsquare_enqueue_media_library_modal_script');


function affsquare_display_custom_logo() {
    $logo_id = get_option('affsquare_logo_url', '');

    if (!empty($logo_id)) {
?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            jQuery(document).ready(function ($) {
                $('.et_pb_menu__logo img').attr({
                    src: '<?= $logo_id ?>',
                    srcset: '<?= $logo_id ?>' 
                })
            })
        </script>
<?php
    }
}

add_action('wp_head', 'affsquare_display_custom_logo');
