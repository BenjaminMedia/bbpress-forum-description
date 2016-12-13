<?php

namespace bbPress\ForumDescription\Admin;

use bbPress\ForumDescription;

class PostMetaBox
{

    const UNLOCK_SETTING_KEY = 'bbp_forum_description';

    /**
     * Registers the Bp wa oauth locked content meta box.
     *
     * @return void.
     */
    public static function register_meta_box()
    {
        add_action('do_meta_boxes', function(){
            add_meta_box('_bbp_forum_description', 'Forum Description', [__CLASS__, 'meta_box_content'], 'reply','side','high');
        });

        add_action('save_post', [__CLASS__, 'save_meta_box_settings']);
    }

    public static function save_meta_box_settings() {

        if(isset($_POST[self::UNLOCK_SETTING_KEY])) {
            update_post_meta(
                get_the_ID(),
                self::UNLOCK_SETTING_KEY,
                sanitize_text_field($_POST[self::UNLOCK_SETTING_KEY])
            );
        }

    }

    public static function get_setting($option) {
        return get_post_meta(get_the_ID(), $option, true);
    }

}