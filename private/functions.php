<?php
function url($path)
{
    // add the leading / if missing
    if ($path[0] !== "/") {
        $path = "/" . $path;
    }
    return WWW_ROOT . $path;
}

function u($string = "")
{
    return urlencode($string);
}

function h($string = "")
{
    return htmlspecialchars($string);
}

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function redirect_to($location)
{
    return header("Location: " . $location);
}

function is_empty($data)
{
    return !isset($data) || trim($data) === "";
}

function is_not_empty($data)
{
    return !is_empty($data);
}

function log_in($user)
{
    // session_regenerate_id — Update the current session id with a newly generated one to prevent session fixation
    session_regenerate_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $user['fname'];
    $_SESSION['priv_level'] = $user['priv'];
    return true;
}

function log_out()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
    unset($_SESSION['priv_level']);
    // session_destroy();
    return true;
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login()
{
    if (!is_logged_in()) {
        redirect_to(url('login.php'));
    }
}

function has_valid_email($email)
{
    $sanitize = filter_var($email, FILTER_SANITIZE_EMAIL);
    $validate = filter_var($sanitize, FILTER_VALIDATE_EMAIL);
    return $validate;
}

function has_priv_level($priv_level = 0)
{
    return $_SESSION['priv_level'] >= $priv_level ? true : false;
}

function check_if_timeout($timeout = 300)
{
    if ((time() - $_SESSION['last_login']) > $timeout) { //subtract new timestamp from the old one
        ?>
        <script>alert("<?php echo 'Your ' . gmdate("i:s", $timeout) . ' minutes session has expired.'; ?>");</script>
        <?php
        log_out();
    } else {
        $_SESSION['last_login'] = time(); //set new timestamp
    }
}

function display_table($result = [])
{
    if (!empty($result)) {
        ?>

        <table border="1">
            <thead>
            <tr>
                <th>Id</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Priv</th>
                <th>Active</th>
                <th colspan="2"></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($user = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo h($user['id']); ?></td>
                    <td><?php echo h($user['sname']); ?></td>
                    <td><?php echo h($user['fname']); ?></td>
                    <td><?php echo h($user['email']); ?></td>
                    <td><?php echo h($user['priv']); ?></td>
                    <td><?php echo h($user['active']) == "y" ? "Yes" : "No"; ?></td>
<!--                    <td><button><a href="--><?php //echo url('admin/users/view_user.php?id=' . h(u($user['id']))); ?><!--">View</a></button>-->
<!--                    </td>-->
                    <?php if ($_SESSION['priv_level'] === "1" || $user['priv'] <= $_SESSION['priv_level'] - 1 || $_SESSION['user_id'] == $user['id']) { ?>
                        <td><button><a href="<?php
                                echo url('admin/users/edit_user.php?id=' . h(u($user['id'])));
                                ?>">Edit</a></button>
                        </td>
                        <td><button><a href="<?php echo url('admin/users/delete_user.php?id=' . h(u($user['id']))); ?>">Delete</a></button>
                        </td>
                    <?php } ?>
                </tr>
                <?php
} ?>
            </tbody>
        </table>
        <?php
    }
}

function display_page_table($content = [])
{
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Link</th>
                <th>navBarDisplay</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            <?php // while ($content = mysqli_fetch_assoc($result)) {
                // var_dump($content['link']);
                ?>
                <tr>
                    <td><?php echo h($content['id']); ?></td>
                    <td><?php echo h($content['title']); ?></td>
                    <td><?php echo h($content['link']); ?></td>
                    <td><?php echo h($content['navBarDisplay']); ?></td>
                    <td><button><a href="<?php echo url('admin/content/view_content.php?id='.h(u($content['id']))); ?>">View</a></button></td>
                    <td><button><a href="<?php echo url('admin/content/edit_content.php?id='.h(u($content['id']))); ?>">Edit</a></button></td>
                    <td><button><a href="<?php echo url('admin/content/delete_content.php?id='.h(u($content['id']))); ?>">Delete</a></button></td>
                </tr>
                <?php
                // }          ?>
            </tbody>
        </table>
        <?php
}

function display_errors($errors)
{
    $output = "";
    $plural = count($errors) === 1 ? "error" : "errors";
    if (!empty($errors)) {
        $output = "<div class='error'>";
        $output .= "<span>Please correct the following {$plural}:</span>";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li>" . $error . "</li>";
        }
        $output .= "</ul></div>";
    }
    return $output;
}
