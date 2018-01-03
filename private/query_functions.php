<?php
// USERS queries
function find_all_users()
{
    global $db;
    $query = "SELECT * FROM users";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    return $result;
}

function count_all_users()
{
    global $db;
    $query = "SELECT count(*) FROM users";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    return $result;
}

function search_user($user)
{
    global $db;
    if (!empty($user)) {
        $priv = $_SESSION['priv_level'];
        $query = "SELECT * FROM users WHERE ";
        $query .= "(lower(fname) LIKE '%" . db_escape($db, $user) . "%' OR ";
        $query .= "lower(sname) LIKE '%" . db_escape($db, $user) . "%' OR ";
        $query .= "lower(email) LIKE '%" . db_escape($db, $user) . "%') ";
        $query .= "AND priv <= '". db_escape($db, $priv) ."'";
        $result = mysqli_query($db, $query);
        confirm_result($result);
        // $search_result = mysqli_fetch_assoc($result);
        return $result;
    }
}

function find_user_by_id($id, $return_array = true)
{
    global $db;
    $query = "SELECT * FROM users WHERE id= '" . db_escape($db, $id) . "'";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    if ($return_array) {
        $user = mysqli_fetch_assoc($result);
        return $user;
    } else {
        return $result;
    }
}

function find_user_by_email($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email = '" . db_escape($db, $email) . "'";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function count_users_by_privilege($privilege_level)
{
    global $db;

    $query = "SELECT count(priv) FROM users ";
    $query .= "GROUP BY priv HAVING priv = '" . db_escape($db, $privilege_level) . "'";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    $total = mysqli_fetch_row($result)[0];
    return $total;
}


function validate_user($user, $options = [])
{
    $password_required = $options['password_required'] ?? true;
    $email_is_already_taken = $options['email_is_already_taken'];

    // FIRST NAME
    if (is_empty($user['fname'])) {
        $errors[] = "First Name cannot be blank.";
    } elseif (strlen($user['fname']) < 2 || strlen($user['fname']) > 255) {
        $errors[] = "First Name must be between 2 and 255 characters.";
    }

    // LAST NAME
    if (is_empty($user['sname'])) {
        $errors[] = "Last Name cannot be blank.";
    } elseif (strlen($user['sname']) < 2 || strlen($user['sname']) > 255) {
        $errors[] = "Last Name must be between 2 and 255 characters.";
    }

    // EMAIL
    if (is_empty($user['email'])) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email($user['email'])) {
        $errors[] = "Email must be a valid format.";
    } elseif ($email_is_already_taken) {
        $errors[] = "Email is already taken.";
    }

    // PASSWORD
    if ($password_required) {
        if (is_empty($user['password'])) {
            $errors[] = "Password cannot be blank.";
        } elseif (strlen($user['password']) <= 4 || strlen($user['password']) >= 255) {
            $errors[] = "Password must be between 4 and 255 characters.";
        } elseif (!preg_match('/[A-Z]/', $user['password'])) {
            $errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $user['password'])) {
            $errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $user['password'])) {
            $errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $user['password'])) {
            $errors[] = "Password must contain at least 1 symbol";
        }
        // CONFIRM PASSWORD
        if (is_empty($user['confirm_password'])) {
            $errors[] = "Confirm password cannot be blank.";
        } elseif ($user['password'] !== $user['confirm_password']) {
            $errors[] = "Password and confirm password must match.";
        }
    }

    return $errors;
}

function create_new_user($user, $options = [])
{
    global $db;
    $email_is_already_taken = $options['email_is_already_taken'];
    $errors = validate_user($user, ["email_is_already_taken" => $email_is_already_taken]);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    $insert = "INSERT INTO users ";
    $insert .= "(fname, sname, email, pw, priv, active) ";
    $insert .= "VALUES (";
    $insert .= "'" . db_escape($db, $user['fname']) . "',";
    $insert .= "'" . db_escape($db, $user['sname']) . "',";
    $insert .= "'" . db_escape($db, $user['email']) . "',";
    $insert .= "'" . db_escape($db, $hashed_password) . "',";
    $insert .= "'" . db_escape($db, $user['priv']) . "',";
    $insert .= "'" . db_escape($db, $user['active']) . "'";
    $insert .= ")";
    $result = mysqli_query($db, $insert);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function edit_user($user, $options = [])
{
    global $db;

    $password_required = !is_empty($user['password']);
    $email_is_already_taken = $options['email_is_already_taken'];

    $errors = validate_user($user, ['password_required' => $password_required, "email_is_already_taken" => $email_is_already_taken]);
    if (!empty($errors)) {
        return $errors;
    }
    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    $edit = "UPDATE users SET ";
    $edit .= "fname = '" . db_escape($db, $user['fname']) . "',";
    $edit .= "sname = '" . db_escape($db, $user['sname']) . "',";
    $edit .= "email= '" . db_escape($db, $user['email']) . "',";
    if ($password_required) {
        $edit .= "pw = '" . db_escape($db, $hashed_password) . "',";
    }
    if (has_priv_level(2)) {
        $edit .= "priv = '" . db_escape($db, $user['priv']) . "',";
    }
    $edit .= "active = '" . db_escape($db, $user['active']) . "' ";
    $edit .= "WHERE id = '" . db_escape($db, $user['id']) . "'";

    $result = mysqli_query($db, $edit);
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo "Update failed: " . mysqli_errno($db);
        db_disconnect($db);
        exit;
    }
}

function delete_user($id)
{
    global $db;
    if (has_priv_level(2) || $_SESSION['user_id'] = $id) {
        $delete_request = "DELETE FROM users WHERE id = '" . db_escape($db, $id) . "' LIMIT 1";
    }
    $result = mysqli_query($db, $delete_request);
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_errno($db);
        db_disconnect($db);
        exit;
    }
}

//
// CONTENT queries
//


function find_all_content()
{
    global $db;
    $query = "SELECT * FROM content";
    $result = mysqli_query($db, $query);
    // echo $result;
    confirm_result($result);
    return $result;
}

function find_content_by_id($id)
{
    global $db;
    $query = "SELECT * FROM content WHERE id ='" . db_escape($db, $id) . "';";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    $content = mysqli_fetch_assoc($result);
    // mysqli_free_result($content);
    return $content; // returns an assoc array
}

function find_content_by_link($link)
{
    global $db;
    $query = "SELECT * FROM content WHERE link ='" . db_escape($db, $link) . "';";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    $content = mysqli_fetch_assoc($result);
    // mysqli_free_result($content);
    return $content; // returns an assoc array
}

function validate_page($page, $options = [])
{
    global $db;

    $link_is_already_taken = $options['link_is_already_taken'];

    // title
    if (is_empty($page['title'])) {
        $errors[] = "Title cannot be blank.";
    } elseif (strlen($page['title']) < 2 || strlen(strlen($page['title'])) > 255) {
        $errors[] = "Title must be between 2 and 255 characters.";
    }

    // h1
    if (is_empty($page['h1'])) {
        $errors[] = "Heading (h1) cannot be blank.";
    } elseif (strlen($page['h1']) < 2 || strlen(strlen($page['h1'])) > 255) {
        $errors[] = "Heading (h1) must be between 2 and 255 characters.";
    }

    // link
    if (is_empty($page['link'])) {
        $errors[] = "Link cannot be blank.";
    } elseif (strlen($page['link']) < 2 || strlen(strlen($page['link'])) > 255) {
        $errors[] = "Link must be between 2 and 255 characters.";
    } elseif ($link_is_already_taken) {
//        if (link_is_not_unique($page['link'])) {
            $errors[] = "Link must be unique.";
//        }
    }

    // navBarText
    if (is_empty($page['navBarText'])) {
        $errors[] = "Navigation Text cannot be blank.";
    } elseif (strlen($page['navBarText']) < 2 || strlen(strlen($page['navBarText'])) > 100) {
        $errors[] = "Title must be between 2 and 99 characters.";
    }

    // content
    if (is_empty($page['content'])) {
        $errors[] = "Content cannot be blank.";
    }

    return $errors;
}

function create_new_content($page, $options = [])
{
    global $db;

    $link_is_already_taken = $options['link_is_already_taken'];
    $errors = validate_page($page, ['link_is_already_taken' => $link_is_already_taken]);
    if (!empty($errors)) {
        return $errors;
    }

    $insert = "INSERT INTO content ";
    $insert .= "(title, h1, link, navBarText, navBarDisplay, navBarOrder, content, includes, dtg, priv, active) ";
    $insert .= "VALUES (";
    $insert .= "'" . db_escape($db, $page['title']) . "',";
    $insert .= "'" . db_escape($db, $page['h1']) . "',";
    $insert .= "'" . db_escape($db, $page['link']) . "',";
    $insert .= "'" . db_escape($db, $page['navBarText']) . "',";
    $insert .= "'" . db_escape($db, $page['navBarDisplay']) . "',";
    $insert .= "'" . db_escape($db, $page['navBarOrder']) . "',";
    $insert .= "'" . db_escape($db, $page['content']) . "',";
    $insert .= "'" . db_escape($db, $page['includes']) . "',";
    $insert .= "'" . db_escape($db, $page['dtg']) . "',";
    $insert .= "'" . db_escape($db, $page['priv']) . "',";
    $insert .= "'" . db_escape($db, $page['active']) . "'";
    $insert .= ")";
    $result = mysqli_query($db, $insert);

    if ($result) {
        return true;
    } else {
        // INSERT new content failed
        echo mysqli_errno($db);
        db_disconnect($db);
        exit;
    }
}

function edit_page($page, $options = [])
{
    global $db;

    $link_is_already_taken = $options['link_is_already_taken'];

    $errors = validate_page($page, ["link_is_already_taken" => $link_is_already_taken]);
    if (!empty($errors)) {
        return $errors;
    }
    
    $edit = "UPDATE content SET ";
    $edit .= "title = '" . db_escape($db, $page['title']) . "',";
    $edit .= "h1 = '" . db_escape($db, $page['h1']) . "',";
//    if ($same_link === true) {
        $edit .= "link = '" . db_escape($db, $page['link']) . "',";
//    }
    $edit .= "navBarText = '" . db_escape($db, $page['navBarText']) . "',";
    $edit .= "navBarDisplay = '" . db_escape($db, $page['navBarDisplay']) . "',";
    $edit .= "navBarOrder = '" . db_escape($db, $page['navBarOrder']) . "',";
    $edit .= "content = '" . db_escape($db, $page['content']) . "',";
    $edit .= "includes = '" . db_escape($db, $page['includes']) . "',";
    $edit .= "dtg = '" . db_escape($db, $page['dtg']) . "',";
    $edit .= "priv = '" . db_escape($db, $page['priv']) . "',";
    $edit .= "active = '" . db_escape($db, $page['active']) . "'";
    $edit .= "WHERE id = '" . db_escape($db, $page['id']) . "'";

    $result = mysqli_query($db, $edit);
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_errno($db);
        db_disconnect($db);
        exit;
    }
}


function delete_page($id)
{
    global $db;

    if (has_priv_level(2)) {
        $delete_request = "DELETE FROM content WHERE id = '" . db_escape($db, $id) . "' LIMIT 1";
    }
    $result = mysqli_query($db, $delete_request);
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_errno($db);
        db_disconnect($db);
        exit;
    }
}

function sort_menu_items()
{
    global $db;

    $query = "SELECT * FROM content ORDER BY navBarOrder ASC";
    $result = mysqli_query($db, $query);
    confirm_result($result);
    return $result;
}
