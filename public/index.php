<?php require_once '../private/initialize.php'; ?>

<?php include SHARED_PATH . '/main_header.php'; ?>



<?php
if (isset($_GET['link'])) {
    $link = $_GET['link'];
    $content = find_content_by_link($link);
    echo $content['content'];
} else {
    echo find_content_by_link('home')['content'];
}
    ?>


<?php include SHARED_PATH . '/main_footer.php';
