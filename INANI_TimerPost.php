<?php

class Inani_TimerPost extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = [
            'classname' => 'my_custom_timer_post',
            'description' => 'A widget to show Time reading for specific post',
        ];
        parent::__construct('my_custom_timer_post', 'Timer Post', $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {

        if(is_single() && $this->timerWidgetAllowed(get_the_ID()))
        {
            extract($args);
            extract($instance);
            echo $before_widget;
                echo $before_title;
                    echo $title;
                echo $after_title;
                echo $this->read_time(get_the_title(), get_the_content());
            echo $after_widget;
        }
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     * @return string|void
     */
    public function form($instance)
    {
        extract($instance);
        ?>
        <p>
            <label for="<?php echo ($titleID =$this->get_field_id('title')); ?>">Title: </label>
            <input
                type="text"
                class="widefat"
                id="<?php echo $titleID; ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo !isset($title)?"": esc_attr($title); ?>"
            />
        </p>
        <?php
    }

    /**
     * Calculate The time needed to read the post
     *
     * @param $title
     * @param $content
     * @return string
     * @internal param $text
     */
    private function read_time($title, $content){
        $words = str_word_count(strip_tags($content));
        $words  = $words + str_word_count(strip_tags($title));
        $min = ceil($words / 200);
        return $min . ' min read';
    }

    /**
     * check if its allowed to display the widget
     *
     * @param $post_id
     * @return bool
     */
    private function timerWidgetAllowed($post_id)
    {
        return (int)get_post_meta($post_id, 'inani_show_timer', true) == 1;
    }
}

// register TimerPost widget
function register_timer_post()
{
    register_widget('Inani_TimerPost');
}

add_action('widgets_init', 'register_timer_post');