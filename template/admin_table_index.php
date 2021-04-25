<div class="wrap">
    <h2>
    <?= _e('Increon Users')?> 
            <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=increon_user_form');?>"><?php _e('Neu Hinzufügen')?></a>
    </h2>

    <?php require_once $this->plugin_dir_path.'template/users_table.php'; ?>
</div>
