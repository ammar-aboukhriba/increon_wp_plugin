<?php 
class IncreonUserPlugin{

     function __construct($plugin_dir_path){
       $this->plugin_dir_path = $plugin_dir_path;
    }
    
    function activate(){
        flush_rewrite_rules();
       

    }
    function deactivate(){
        flush_rewrite_rules();
    }
    function register(){
       add_action('admin_menu', [$this,'add_admin_menu']);
       add_action('admin_enqueue_scripts',[$this,'enqueue']);
       add_action('wp_enqueue_scripts',[$this,'enqueue']);
       //add_action( 'admin_footer', [$this,'data_table_javascript'] ); 
       add_action( 'wp_ajax_get_data_ajax', [$this,'get_data_ajax'] );
       add_shortcode( 'increon_users_shortcode', [$this,'user_table_shortcode'] );
    }
    function data_table_javascript(){
        require_once $this->plugin_dir_path.'template/admin_data_table_javascript.php';
    }
    function get_data_ajax(){
        $response = [
            'data'=>[]
        ];
        $users = get_users();
        foreach($users as $user){
            $user_meta = get_user_meta($user->ID);
            $user_data=[];
            if(is_admin()){
               array_push($user_data, '<a href="'.get_admin_url(get_current_blog_id(), 'admin.php?page=increon_user_form&id='.$user->ID).'">'.$user->user_login.'</a>');
            }else{
             array_push($user_data,$user->user_login);
            }
            array_push($user_data, (isset($user_meta['first_name'][0]) ? $user_meta['first_name'][0]:'') );
            array_push($user_data, (isset($user_meta['last_name'][0]) ? $user_meta['last_name'][0]:'') );
            array_push($user_data, (isset($user_meta['address'][0]) ? $user_meta['address'][0]:'') );
            array_push($user_data, (isset($user_meta['phone'][0]) ? $user_meta['phone'][0]:'') );
            
            array_push($response['data'],$user_data);
            
        }
        echo json_encode($response);
        wp_die();
    }
    function enqueue(){
        wp_enqueue_style('increonDataTableStyle1',plugins_url('/DataTables/datatables.min.css',__FILE__));
        wp_enqueue_script('increonDataTableScript1',plugins_url('/DataTables/jquery-3.3.1.min.js',__FILE__));
        wp_enqueue_script('increonDataTableScript3',plugins_url('/DataTables/datatables.min.js',__FILE__));
        wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
        wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    }
    
    function add_admin_menu()
    {
        add_menu_page(__('Increon Users'), __('Increon Users'), 'activate_plugins', 'increon_users', [$this,'user_table_index'] );
        add_submenu_page('increon_users', __('Users List'), __('Liste'), 'activate_plugins', 'increon_users', [$this,'user_table_index'] );
   
        add_submenu_page('increon_users', __('Neu Hinzuf??gen'), __('Neu Hinzuf??gen'), 'activate_plugins', 'increon_user_form', [$this,'user_form'] );
    }
    
    function user_table_index(){
        require_once $this->plugin_dir_path.'template/admin_table_index.php';
    }
    function user_table_shortcode(){
        $users = get_users();
        require_once $this->plugin_dir_path.'template/users_table.php';
    }
    function user_form(){
        $item = array(
            'id' => 0,
            'login_name'      => '',
            'password'      => '',
            'first_name'  => '',
            'last_name'     => '',
            'email_address'       => '', 
            'phone' => '',
            'address'     => '',
            'post_code'   => '',
            'city'       => '',  
            'country' => '',   
            
        );

        
        if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'user_form')) {
            $error = false;
            $item = shortcode_atts($item, $_REQUEST);     
           
            $item_valid = $this->validate_data($item);
            if ($item_valid === true) {
                if ($item['id'] == 0) {
                    $user_id = wp_create_user( $item['login_name'], $item['password'], $item['email_address'] );
                    $user = new WP_User( $user_id );
                    $user->set_role( 'author' );
                    
                    if(!$user)
                        $error = true;
                }else{
                    $user_id =  $_POST['id'];
                    if(!empty($item['password'])){
                        wp_update_user([
                            'ID'=>$user_id,
                            'user_login'=>$item['login_name'],
                            'user_pass'=>$item['password'],
                            'user_email'=>$item['email_address'],
                        ]);
                    }else{
                        wp_update_user([
                            'ID'=>$user_id,
                            'user_email'=>$item['email_address'],
                        ]);
                    }
                    $user = new WP_User( $user_id );
                    $item['login_name']=$user->user_login;

                    if(!$user)
                        $error = true;
                }
            
                if ($error===false) {
                    update_user_meta( $user_id,'first_name',$item['first_name']);
                    update_user_meta( $user_id,'last_name',$item['last_name']);
                    update_user_meta( $user_id,'address',$item['address']);
                    update_user_meta( $user_id,'post_code',$item['post_code']);
                    update_user_meta( $user_id,'city',$item['city']);
                    update_user_meta( $user_id,'country',$item['country']);
                    update_user_meta( $user_id,'phone',$item['phone']);

                    $message = __('Benutzer wurde erfolgreich gespeichert');
                } else {
                    $notice = __('Beim Speichern des Benutzers ist ein Fehler aufgetreten');
                }
                
            }else{
                $notice = $item_valid;
            }
    
        }elseif(isset($_GET['id']) && !empty($_GET['id'])){
            $user = new WP_User( $_GET['id'] );
            $user_meta = get_user_meta($user->ID);
            $item['id']=$user->ID;
            $item['login_name']=$user->user_login;
            $item['email_address']=$user->user_email;
            $item['first_name']=isset($user_meta['first_name'][0])?$user_meta['first_name'][0]:'';
            $item['last_name']=isset($user_meta['last_name'][0])?$user_meta['last_name'][0]:'';
            $item['address']=isset($user_meta['address'][0])?$user_meta['address'][0]:'';
            $item['first_name']=isset($user_meta['first_name'][0])?$user_meta['first_name'][0]:'';
            $item['post_code']=isset($user_meta['post_code'][0])?$user_meta['post_code'][0]:'';
            $item['city']=isset($user_meta['city'][0])?$user_meta['city'][0]:'';
            $item['country']=isset($user_meta['country'][0])?$user_meta['country'][0]:'';
            $item['phone']=isset($user_meta['phone'][0])?$user_meta['phone'][0]:'';
        
        }
        require_once $this->plugin_dir_path.'template/admin_user_form.php';
    }
    function validate_data($item)
    {
        $messages = array();
        if (empty($item['login_name']) && $item['id']===0) $messages[] = __('der Benutzername ist erforderlich');
        if(username_exists( $item['login_name']) && $item['id']===0)  $messages[] = __('Dieser Benutzername ist schon vergeben.');
        
        if (empty($item['password']) && $item['id']===0) $messages[] = __('das Passwort ist erforderlich');
        if (empty($item['first_name'])) $messages[] = __('der Vorname  ist erforderlich');
        if (empty($item['last_name'])) $messages[] = __('der Nachname  ist erforderlich');
       /* if (empty($item['email_address'])) $messages[] = __('der E-Mail-Adresse ist erforderlich');
        elseif (!is_email($item['email_address'])) $messages[] = __('die E-Mail-Adresse ist nicht g??ltig');*/
        if (empty($item['phone'])) $messages[] = __('der Telefonnummer ist erforderlich');
        elseif(!empty($item['phone']) && !absint(intval($item['phone'])) && !preg_match('/[0-9]+/', $item['phone']))  $messages[] = __('die Telefonnummer ist nicht g??ltig');
        

        if (empty($messages)) return true;
        return implode('<br />', $messages);
    }
   


}