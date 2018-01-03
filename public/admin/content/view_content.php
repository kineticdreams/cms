<?php require_once '../../../private/initialize.php'; ?>

<?php
    require_login();
    check_if_timeout();
?>

<?php $page_title = "View Page"; ?>
<?php include SHARED_PATH . '/admin_header.php'; ?>

<?php
$id = $_GET['id'] ?? '';
$content = find_content_by_id($id);
date_default_timezone_set("Australia/Darwin");
var_dump($_SESSION['same_link']);
var_dump($_SESSION['l']);
var_dump($_SESSION['lid']);
unset($_SESSION['lid']);
unset($_SESSION['l']);
unset($_SESSION['same_link']);

?>

<section class="content">
    <h2 class="spacing">Page Details: <?php echo $user['sname']; ?></h2>
    <article class="view">
        <p><span>Title: </span><?php echo h($content['title']); ?></p>
        <p><span>Page Heading: </span><?php echo h($content['h1']); ?></p>
        <p><span>Link: </span><?php echo h($content['link']); ?></p>
        <p><span>Navigation Bar Text: </span><?php echo h($content['navBarText']); ?></p>
        <p><span>Navigation Bar Display: </span><?php echo h($content['navBarDisplay']); ?></p>
        <p><span>Navigation Bar Order: </span><?php echo h($content['navBarOrder']); ?></p>
        <p><span>Privilege Level: </span><?php echo h($content['priv']); ?></p>
        <p><span>Visible Page? </span><?php echo h($content['active']); ?></p>
        <p><span>Filename: </span><?php echo h($content['includes']) ?? 'None'; ?></p>
        <p><span>Updated On: </span><?php echo date('d/m/Y H:i:s', h($content['dtg'])); ?></p>
        <p><span>Content: </span><?php echo h($content['content']); ?></p>
    </article>
</section>

<?php include SHARED_PATH . '/admin_footer.php'; ?>
