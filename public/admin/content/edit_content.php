<?php require_once '../../../private/initialize.php'; ?>

<?php
    require_login();
    check_if_timeout();
?>

<?php
if (!isset($_GET['id'])) {
    redirect_to(url('/admin/content/index.php'));
}

$id = $_GET['id'];
?>
<?php
if (is_post_request()) {
//    $content_link = find_content_by_id($id);
    $content = [];
    $content['id'] = $id;
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

//	$link_is_already_taken =  find_content_by_id($id)['link'] !== find_content_by_link($_POST['link'])['link'];
    $link_is_already_taken =  find_content_by_id($id)['link'] !== find_content_by_link($_POST['link'])['link'] && find_content_by_link($_POST['link'])['link'];
//	$link_is_already_taken =  find_content_by_link($_POST['link'])['link'] !== $_POST['link'];
//    var_dump($link_is_already_taken);
//    if ($_POST['link'] === $content_link['link']) {
//        $same_link = true;
//    } else {
//        $same_link = false;
//    }
    $_SESSION['same_link'] = $link_is_already_taken;
    $_SESSION['l'] = find_content_by_link($_POST['link'])['link'];
    $_SESSION['lid'] = find_content_by_id($id)['link'];

    var_dump($_SESSION['same_link']);
    var_dump($_SESSION['l']);
    var_dump($_SESSION['lid']);

//	unset($_SESSION['same_link']);
    $result = edit_page($content, ["link_is_already_taken" => $link_is_already_taken]);
    if ($result === true) {
        redirect_to(url('/admin/content/view_content.php?id=' . h(u($id))));
    } else {
        $errors = $result;
    }
} else {
    $content = find_content_by_id($id);
}
?>
<?php $page_title = "Add New Page"; ?>
<?php include SHARED_PATH . '/admin_header.php'; ?>
<section class="content">
        <?php echo display_errors($errors); ?>
        <form class="form" action="<?php echo url('/admin/content/edit_content.php?id='.h(u($id))); ?>" method="post"
              autocomplete="off">
            <h1 class="formTitle">Edit Page</h2>
                <p type="Title:"><input type="text" name="title" placeholder="Type page title" value="<?php echo h($content['title']); ?>"/></p>
                <p type="Page Heading:"><input type="text" name="h1" placeholder="Type page heading" value="<?php echo h($content['h1']); ?>"/> </p>
                <p type="Link:"><input type="text" name="link" placeholder="Type page link" value="<?php echo h($content['link']); ?>"/></p>
                <p type="Navigation Bar Text:"><input type="text" name="navBarText" placeholder="Type Navigation Bar Text" value="<?php echo h($content['navBarText']); ?>"/></p>
                <p type="Display in Navigation Bar?">
                    <input type="hidden" name="navBarDisplay" value="n"/>
                    <input type="checkbox" name="navBarDisplay" value="y" <?php if ($content['navBarDisplay'] == 'y') {
                        echo "checked";
} ?>/>
                </p>
                <p type="Navigation Bar Order:"><input type="number" name="navBarOrder" placeholder="Select Navigation Bar Order"/></p>
                <p type="Privilege Level:">
                    <select name="priv">
                        <?php
                        for ($i=0; $i < 4; $i++) {
                            echo "<option value='{$i}' ";
                            if ($i === $content[priv]) {
                                echo " selected";
                            }
                            echo ">{$i}</option>";
                        }
                            ?>
                    </select>
                </p>
                <p type="Visible Page?">
                    <input type="hidden" name="active" value="n"/>
                    <input type="checkbox" name="active" value="y" <?php if ($content[active] == "y") {
                        echo "checked";
} ?>/>
                </p>
                <p type="Filename:"><input type="text" name="includes" placeholder="Type the filename" value="<?php echo h($content['includes']); ?>"/></p>
                <p type="Content:">
                    <textarea name="content"><?php echo h($content['content']); ?></textarea>
                </p>

                <button type="submit" name="submit">Submit</button>
        </form>

</section>


<?php include SHARED_PATH . '/admin_footer.php'; ?>
