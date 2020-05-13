<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://malok.dev/
 * @since      1.0.0
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php $items = get_post_meta($atts['id'], $this->plugin_name . '_items', true); ?>

<div class="mpcr-todo" data-todo-id="<?php echo $atts['id']; ?>">
  <div class="mpcr-todo__new">

    <div class="mpcr-todo__item">
      <div class="mpcr-todo__status">
        <input type="checkbox" disabled />
      </div>
      <div class="mpcr-todo__label">
        <input type="text" placeholder="Enter new task here" />
      </div>
    </div>

  </div>
  <div class=" mpcr-todo__items">
    <?php if ($fields = json_decode($items)) : ?>
      <?php foreach ($fields as $key => $field) : ?>

        <div class="mpcr-todo__item" data-row="<?php echo $key; ?>">
          <div class="mpcr-todo__status">
            <input name="status" type="checkbox" <?php echo property_exists($field, 'status') && $field->status ? 'checked' : ''; ?> />
          </div>
          <div class="mpcr-todo__label">
            <input name="label" type="text" value="<?php echo property_exists($field, 'label') && $field->label ? $field->label : ''; ?>" data-row="<?php echo $key; ?>" />
          </div>
        </div>

      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</div>