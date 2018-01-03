<?php require_once '../../../private/initialize.php'; ?>

<?php include SHARED_PATH . '/admin_header.php'; ?>

<?php
    require_login();
    check_if_timeout();
?>


<section class="content">
    <?php $result = find_all_content(); ?>
           <button class="menuItem add_link bigbold text_shadow"><a href="<?php echo url('admin/content/new_content.php'); ?>" title="Add new Page">Add New Page</a></button>


           <form class="form" action="<?php echo url('/admin/content/index.php?id=' . h(u($_POST['id']))); ?>" method="post" autocomplete="off">
                <p type="Select a Page: ">
                 <select name="page">
                        <?php
                        while ($content = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$content['link']}'>{$content['title']}</option>";
                        }
                            ?>
                 </select>
                </p>
                <button type="submit" name="submit" value="submit">Submit</button>
            </form>

    <?php if (is_post_request()) {
        $selected_page = $_POST['page'];
        $result_page = find_content_by_link($selected_page);
        display_page_table($result_page);
} ?>



</section>



<?php include SHARED_PATH . '/admin_footer.php'; ?>
