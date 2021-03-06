<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class SendPress_View_Emails_Header extends SendPress_View_Emails {
	
	function save(){
        //$this->security_check();
		$saveid = SPNL()->validate->_int( 'templateID' );
        if( $saveid > 0 ){
            update_post_meta( $saveid, '_header_content', SPNL()->validate->_html('header-content') );
       
            SendPress_Admin::redirect('Emails_Header',array('templateID' => $saveid));
            }
        }
   
   function html() { 
    global $sendpress_html_templates;

       
    $templateID = SPNL()->validate->_int( 'templateID' );
    $postdata = get_post(  $templateID  );


        //print_r( $postdata );
    ?>
    <form method="post" name="post" >
    <input type="hidden" value="<?php echo  $templateID;  ?>" name="templateID" />
     
   	<div class="pull-right">
     <a href="<?php echo SendPress_Admin::link('Emails_Tempstyle', array('templateID' =>  $templateID   ) ); ?>"><?php _e('Back to Template','sendpress'); ?></a>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary " type="submit" value="save" name="submit"><i class="icon-white icon-ok"></i> <?php echo __('Save','sendpress'); ?></button>
   	</div>
   <h2><?php echo $postdata->post_title; ?> <?php _e('Template Header','sendpress'); ?></h2><br>
     <div class="tab-pane fade in active" id="home"><?php wp_editor( get_post_meta( $postdata->ID , '_header_content' , true) , 'header-content'); ?></div>
     <div></div>
		<?php SendPress_Data::nonce_field(); ?>
         <br><br>
     Default Content
    <textarea class="form-control" readonly rows="3"><?php echo SendPress_Tag_Header_Content::content(); ?></textarea>
     </form>

<?php

$this->popup();
}

}

SendPress_Admin::add_cap('Emails_Tempstyle','sendpress_email');