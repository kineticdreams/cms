<?php require_once '../../../private/initialize.php'; ?>

<?php
    require_login();
    check_if_timeout();
?>

<?php
if (is_post_request()) {
    $content = [];
    $content['title'] = $_POST['title'] ?? "";
    $content['h1'] = $_POST['h1'] ?? "";
    $content['link'] = $_POST['link'] ?? "";
    $content['navBarText'] = $_POST['navBarText'] ?? "";
    $content['navBarDisplay'] = $_POST['navBarDisplay'] ?? "";
    $content['navBarOrder'] = $_POST['navBarOrder'] ?? "";
    $content['content'] = $_POST['content'] ?? "";
    $content['includes'] = $_POST['includes'] ?? "";
    $content['dtg'] = time() ?? "";
    $content['priv'] = $_POST['priv'] ?? "";
    $content['active'] = $_POST['active'] ?? "";

    $link_is_already_taken =  find_content_by_link($_POST['link'])['link'] === $_POST['link'];

    $result = create_new_content($content, ['link_is_already_taken' => $link_is_already_taken]);
    if ($result === true) {
        $newId = mysqli_insert_id($db);
        redirect_to(url('/admin/content/view_content.php?id=' . $newId));
    } else {
        $errors = $result;
    }
} else {
    // display the blank form
    $content = [];
    $content['title'] = "";
    $content['h1'] = "";
    $content['link'] = "";
    $content['navBarText'] = "";
    $content['navBarDisplay'] = "";
    $content['navBarOrder'] = "";
    $content['content'] = "";
    $content['includes'] = "";
    $content['dtg'] = "";
    $content['priv'] = "";
    $content['active'] = "";
}
?>
<?php $page_title = "Add New Page"; ?>
<?php include SHARED_PATH . '/admin_header.php'; ?>
<section class="content">
    <!-- <h2 class="spacing"></h2>
    <article> -->
        <?php echo display_errors($errors); ?>
        <form class="form" action="<?php echo url('/admin/content/new_content.php'); ?>" method="post"
              autocomplete="off">
            <h1 class="formTitle">Add New Page</h2>
                <p type="Title:"><input type="text" name="title" placeholder="Type page title"/></p>
                <p type="Page Heading:"><input type="text" name="h1" placeholder="Type page heading"/></p>
                <p type="Link:"><input type="text" name="link" placeholder="Type page link"/></p>
                <p type="Navigation Bar Text:"><input type="text" name="navBarText" placeholder="Type Navigation Bar Text"/></p>
                <p type="Navigation Bar Order:"><input type="number" name="navBarOrder" placeholder="Select Navigation Bar Order"/></p>
                <p type="Privilege Level:">
                    <select name="priv">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </p>
                <label for="active">
                    Dysplay in Navigation Bar?
                    <input type="hidden" name="active" value="n"/>
                    <input type="checkbox" name="active" value="y"/>
                </label>
                <label for="active">
                    Visible Page?
                    <input type="hidden" name="active" value="n"/>
                    <input type="checkbox" name="active" value="y"/>
                </label>
                <p type="Filename:"><input type="text" name="includes" placeholder="Type the filename"/></p>
                <p type="Content:">
                    <textarea name="content"></textarea>
                </p>

                <button type="submit" name="submit">Submit</button>
        </form>
    <!-- </article> -->

</section>


<?php include SHARED_PATH . '/admin_footer.php'; ?>
