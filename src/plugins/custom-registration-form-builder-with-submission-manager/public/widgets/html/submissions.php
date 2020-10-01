<?php
if (!defined('WPINC')) {
    die('Closed');
}
foreach ($submissions as $index => $submission) {
    $submission_id= $submission->submission_id; 
    ?>
    <div class="rm-submission-card">
        <div class="rm-submission-card-title dbfl">
            <a href="<?php echo esc_url(add_query_arg('submission_id', $submission_id, get_permalink(get_option('rm_option_front_sub_page_id')))); ?>" class="difl"><?php echo $submission->form_name; ?> </a>
        </div>
        <div class="rm-submission-card-content dbfl">
            <div class="rm-submission-details difl"><?php echo RM_UI_Strings::get('LABEL_SUBMITTED_ON'); ?> <?php echo $submission->submitted_on; ?></div>
        </div>
    </div>
<?php } ?>