
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Increon Users')?> <a class="add-new-h2"
                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=increon_users');?>"><?php _e('Züruck')?></a>
    </h2>
    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>
    <form id="increon_user_form" method="POST" >
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('user_form')?>"/>
            <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
                <div class="form2bc">
                        <p>			
                            <label for="login_name"><?php _e('Benutzername:')?>*</label>
                            <br>	
                            <input id="login_name" name="login_name" type="text" value="<?php echo esc_attr($item['login_name'])?>" >
                        </p>

                        <p>			
                            <label for="password"><?php _e('Passwort:')?>*</label>
                            <br>	
                            <input id="password" name="password" type="password" value="<?php echo esc_attr($item['password'])?>"  >
                        </p>
                       
                    </div>
                    
                    <div class="form2bc">
                        <p>			
                            <label for="first_name"><?php _e('Vorname:')?>*</label>
                            <br>	
                            <input id="first_name" name="first_name" type="text" value="<?php echo esc_attr($item['first_name'])?>"  >
                        </p>
                        <p>			
                            <label for="last_name"><?php _e('Nachname:')?>*</label>
                            <br>	
                            <input id="last_name" name="last_name" type="text" value="<?php echo esc_attr($item['last_name'])?>"  >
                        </p>
                       
                    </div>	
                    <div class="form2bc">
                        <p>			
                            <label for="email_address"><?php _e('E-Mail-Adresse:')?>*</label>
                            <br>	
                            <input id="email_address" name="email_address" type="text" value="<?php echo esc_attr($item['email_address'])?>"  >
                        </p>
                        <p>			
                            <label for="phone"><?php _e('Telefonnummer:')?></label>
                            <br>	
                            <input id="phone" name="phone" type="text" value="<?php echo esc_attr($item['phone'])?>"  >
                        </p>
                        
                    </div>
                    <div class="form2bc">
                        <p>			
                            <label for="address"><?php _e('Straße & Hausnummer:')?></label>
                            <br>	
                            <input id="address" name="address" type="text" value="<?php echo esc_attr($item['address'])?>"  >
                        </p>
                        <p>			
                            <label for="post_code"><?php _e('PLZ:')?></label>
                            <br>	
                            <input id="post_code" name="post_code" type="text" value="<?php echo esc_attr($item['post_code'])?>"  >
                        </p>
        
                       
                    </div>
                    <div class="form2bc">
                        <p>			
                            <label for="city"><?php _e('Ort:')?></label>
                            <br>	
                            <input id="city" name="city" type="text" value="<?php echo esc_attr($item['city'])?>"  >
                        </p>
                        <p>			
                            <label for="country"><?php _e('Land:')?></label>
                            <br>	
                            <input id="country" name="country" type="text" value="<?php echo esc_attr($item['country'])?>"  >
                        </p>
        
                       
                    </div>
                    
                    
            <input type="submit" value="<?php _e('Speichern')?>" id="submit" class="button-primary" name="submit">
    </form>
</div>
