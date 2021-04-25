<table id="increon_users_table" class="wp-list-table widefat fixed striped table-view-list" style="width:100%">
    <thead>
        <tr>
            <th>Benutzer Name</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Addresse</th>
            <th>Telefonnummer</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($users as $user):
            $user_meta = get_user_meta($user->ID);
        ?>
        <tr>
            <td><?='<a href="'.get_admin_url(get_current_blog_id(), 'admin.php?page=increon_user_form&id='.$user->ID).'">'.$user->user_login.'</a>'?></td>
            <td><?php echo (isset($user_meta['first_name'][0]) ? $user_meta['first_name'][0] :'' )?></td>
            <td><?php echo (isset($user_meta['last_name'][0]) ? $user_meta['last_name'][0] :'' )?></td>
            <td><?php echo (isset($user_meta['address'][0]) ? $user_meta['address'][0] :'' )?></td>
            <td><?php echo (isset($user_meta['phone'][0]) ? $user_meta['phone'][0] :'' )?></td>
        </tr>
        <?php
        endforeach;
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th>Benutzer Name</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Addresse</th>
            <th>Telefonnummer</th>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('#increon_users_table').DataTable();
    } );
</script>