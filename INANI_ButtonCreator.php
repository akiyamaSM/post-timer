<?php


class INANI_ButtonCreator
{

    /**
     * Execute!
     *
     */
    public function run()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
    }

    /**
     * Add a new option in the post
     *
     */
    public function add_meta_box()
    {
        add_meta_box(
            'custom-box-for-check-timer',
            'Timer option',
            [$this, 'post_timer_option_display'],
            'post',
            'side',
            'high'
        );
    }

    /**
     * The block to render
     *
     */
    public function post_timer_option_display()
    {
        require_once(
            plugin_dir_path(__FILE__). 'views/checkbox.php'
        );
    }
}

(new INANI_ButtonCreator())->run();