<p>
    <label for="<?= $instance->get_field_id('title'); ?>"><?= _e('Title:'); ?></label>
    <input class="widefat" id="<?= $instance->get_field_id('title'); ?>" name="<?= $instance->get_field_name('title'); ?>" type="text" value="<?= esc_attr($title); ?>" /><br />
</p>
