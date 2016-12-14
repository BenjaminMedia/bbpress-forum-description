<?php

namespace bbPress\ForumDescription\Admin;

use bbPress\ForumDescription;

class PostMetaBox
{

    const SETTING_KEY = 'bbp_forum_description';
    /**
     * Registers the bbp forum description
     *
     * @return void.
     */
    public static function register_meta_box()
    {

        add_action('do_meta_boxes', function(){
            add_meta_box('_bbp_forum_description', 'Forum Description', [__CLASS__, 'meta_box_content'], 'forum','normal','high');
        });

        add_action('save_post', [__CLASS__, 'save_meta_box_settings']);
    }

    public static function save_meta_box_settings() {

        if(isset($_POST[self::SETTING_KEY])) {
            update_post_meta(
                get_the_ID(),
                self::SETTING_KEY,
                $_POST[self::SETTING_KEY]
            );
        }

    }

    public static function meta_box_content() {

        $DescriptionOptionValue = self::get_setting(self::SETTING_KEY);
        $forumDescriptionLabel = ForumDescription\Plugin::instance()->settingsLabel;

        $fieldOutput =  "<p>";
        $fieldOutput .= "<textarea name='bbp_forum_description' class='large-text' placeholder='$forumDescriptionLabel'>$DescriptionOptionValue</textarea>";
        $fieldOutput .= "</p>";

        print $fieldOutput;
    }

    public static function get_setting($option) {
        return get_post_meta(get_the_ID(), $option, true);
    }

}