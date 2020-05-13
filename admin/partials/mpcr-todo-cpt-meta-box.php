<?php
wp_nonce_field($this->plugin_name . '_list_meta_box', $this->plugin_name . '_list_meta_box_nonce');

$items = get_post_meta($post->ID, $this->plugin_name . '_items', true);

?>

<div class="mpcr-shortcode">
  <code>[mpcr-todo id="<?php echo $post->ID; ?>"]</code>
</div>

<div id="mpcr-todo" class="mpcr-todo">

  <div class="mpcr-todo-items">
    <?php if ($fields = json_decode($items)) : ?>

      <?php foreach ($fields as $key => $field) : ?>
        <div class="mpcr-todo-item" data-row="<?php echo $key; ?>">
          <div class="mpcr-todo-item__remove">
            <button type="button" data-remove="<?php echo $key; ?>">&times;</button>
          </div>

          <div class="mpcr-todo-item__fields">
            <div class="mpcr-todo-item__field">
              <label for="<?php printf('mpcr_%s_label', $key) ?>">To-Do item</label>
              <input id="<?php printf('mpcr_%s_label', $key) ?>" name="<?php printf('mpcr[%s][label]', $key) ?>" type="text" value="<?php echo property_exists($field, 'label') && $field->label ? $field->label : ''; ?>" required />
            </div><!-- /.mpcr-todo-item__field -->
            <div class="mpcr-todo-item__field">
              <label for="<?php printf('mpcr_%s_status', $key) ?>">Status</label>
              <input id="<?php printf('mpcr_%s_status', $key) ?>" name="<?php printf('mpcr[%s][status]', $key) ?>" type="checkbox" value="1" <?php echo property_exists($field, 'status') && $field->status ? 'checked' : ''; ?> />
            </div><!-- /.mpcr-todo-item__field -->
          </div><!-- /.mpcr-todo-item__fields -->
        </div><!-- /.mpcr-todo-item -->
      <?php endforeach; ?>

    <?php endif; ?>
  </div>
  <div class="mpcr-todo-addnew">
    <input id="mpcr-todo-addnew" class="button-primary" type="button" name="mpcr-todo-addnew" value="<?php esc_attr_e('Dodaj pozycję'); ?>" />
  </div>
</div>


<script id="template-mpcr-todo" type="text/template">
  <div class="mpcr-todo-item" data-row="{{ todoRowIndex }}">
    <div class="mpcr-todo-item__remove">
      <button type="button" data-remove="{{ todoRowIndex }}">&times;</button>
    </div>
    <div class="mpcr-todo-item__fields">
      <div class="mpcr-todo-item__field">
        <label for="">To-Do item</label>
        <input id="mpcr_{{ todoRowIndex }}_label" name="mpcr[{{ todoRowIndex }}][label]" type="text" required/>
      </div><!-- /.mpcr-todo-item__field -->
      <div class="mpcr-todo-item__field">
        <label for="">Status</label>
        <input id="mpcr_{{ todoRowIndex }}_status" name="mpcr[{{ todoRowIndex }}][status]" type="checkbox" value="1" />
      </div><!-- /.mpcr-todo-item__field -->
    </div><!-- /.mpcr-todo-item__fields -->
  </div><!-- /.mpcr-todo-item -->
</script>