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
        $('#increon_users_table').DataTable({
            ajax:{
                url:my_ajax_object.ajax_url,
                type:'POST',
                data:{
                    'action':'get_data_ajax'
                }
            }
        });
    } );
</script>