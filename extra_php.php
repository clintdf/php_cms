<?php
// prepared statement code
function insert_page($page) {
    global $db;
    $errors = validate_page($page);
    if(!empty($errors)) {
        return $errors;
    }
    shift_page_positions(0, $page['position'], $page['topic_id']);
    $params['topic_id'] = $page['topic_id'];
    $params['menu_name'] = $page['menu_name'];
    $params['position'] = $page['position'];
    $params['visible'] = $page['visible'];
    $params['capability_name'] = $page['capability_name'];
    $params['capability_subject'] = $page['capability_subject'];
    $params['capability_task1'] = $page['capability_task1'];
    $params['capability_task2'] = $page['capability_task2'];
    $params['capability_task3'] = $page['capability_task3'];
    $params['capability_task4'] = $page['capability_task4'];
    $params['capability_task5'] = $page['capability_task5'];
    $params['capability_task6'] = $page['capability_task6'];
    $params['capability2_subject'] = $page['capability2_subject'];
    $params['capability2_task1'] = $page['capability2_task1'];
    $params['capability2_task2'] = $page['capability2_task2'];
    $params['capability2_task3'] = $page['capability2_task3'];
    $params['capability2_task4'] = $page['capability2_task4'];
    $params['capability2_task5'] = $page['capability2_task5'];
    $params['capability2_task6'] = $page['capability2_task6'];
    $params['capability3_subject'] = $page['capability3_subject'];
    $params['capability3_task1'] = $page['capability3_task1'];
    $params['capability3_task2'] = $page['capability3_task2'];
    $params['capability3_task3'] = $page['capability3_task3'];
    $params['capability3_task4'] = $page['capability3_task4'];
    $params['capability3_task5'] = $page['capability3_task5'];
    $params['capability3_task6'] = $page['capability3_task6'];
    $params['capability4_subject'] = $page['capability4_subject'];
    $params['capability4_task1'] = $page['capability4_task1'];
    $params['capability4_task2'] = $page['capability4_task2'];
    $params['capability4_task3'] = $page['capability4_task3'];
    $params['capability4_task4'] = $page['capability4_task4'];
    $params['capability4_task5'] = $page['capability4_task5'];
    $params['capability4_task6'] = $page['capability4_task6'];
    $params['video'] = $page['video'];
    $params['audio'] = $page['audio'];
    $params['content'] = $page['content'];
    $stmt = $mysqli->prepare('INSERT INTO pages (topic_id, menu_name, position, visible, capabity_name, capability_subject, capability_task1, capability_task2, capability_task3, capability_task4, capability_task5, capability_task6, capability2_subject, capability2_task1, capability2_task2, capability2_task3, capability2_task4, capability2_task5, capability2_task6, capability3_subject, capability3_task1, capability3_task2, capability3_task3, capability3_task4, capability3_task5, capability3_task6, capability4_subject, capability4_task1, capability4_task2, capability4_task3, capability4_task4, capability4_task5, capability4_task6, video, audio, content) VALUES (:id, :menu_name, :position, :visible, :capabity_name, :capability_subject, :capability_task1, :capability_task2, :capability_task3, :capability_task4, :capability_task5, :capability_task6, :capability2_subject, :capability2_task1, :capability2_task2, :capability2_task3, :capability2_task4, :capability2_task5, :capability2_task6, :capability3_subject, :capability3_task1, :capability3_task2, :capability3_task3, :capability3_task4, :capability3_task5, :capability3_task6, :capability4_subject, :capability4_task1, :capability4_task2, :capability4_task3, :capability4_task4, :capability4_task5, :capability4_task6, :video, :audio, :content)');
    foreach($_POST['topic_id'] as $id) {
        $params['id'] = $id;
        $stmt->execute($params);
    }
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}
// corresponing errors from the above code
// Warning: mysqli_real_escape_string() expects parameter 2 to be string, array given in C:\xampp\htdocs\db_project\private\database.php on line 14
// Notice: Undefined variable: mysqli in C:\xampp\htdocs\db_project\private\query_functions.php on line 263
// Fatal error: Uncaught Error: Call to a member function prepare() on null in C:\xampp\htdocs\db_project\private\query_functions.php:263 Stack trace: #0 C:\xampp\htdocs\db_project\public\content\content_pages\new.php(42): insert_page(Array) #1 {main} thrown in C:\xampp\htdocs\db_project\private\query_functions.php on line 263


// non-prepared statement code
function insert_page($page) {
    global $db;
    $errors = validate_page($page);
    if(!empty($errors)) {
        return $errors;
    }
    shift_page_positions(0, $page['position'], $page['topic_id']);
    if(is_array($_POST['topic_id'])) {
        foreach($_POST['topic_id'] as $post_t_id) {
            $post_t_ids[] = (int) $post_t_id;
        }
        $post_t_ids = $page['topic_id'];
        $content = $page['menu_name'];
        $content = $page['position'];
        $content = $page['visible'];
        $content = $page['capability_name'];
        $content = $page['capability_subject'];
        $content = $page['capability_task1'];
        $content = $page['capability_task2'];
        $content = $page['capability_task3'];
        $content = $page['capability_task4'];
        $content = $page['capability_task5'];
        $content = $page['capability_task6'];
        $content = $page['capability2_subject'];
        $content = $page['capability2_task1'];
        $content = $page['capability2_task2'];
        $content = $page['capability2_task3'];
        $content = $page['capability2_task4'];
        $content = $page['capability2_task5'];
        $content = $page['capability2_task6'];
        $content = $page['capability3_subject'];
        $content = $page['capability3_task1'];
        $content = $page['capability3_task2'];
        $content = $page['capability3_task3'];
        $content = $page['capability3_task4'];
        $content = $page['capability3_task5'];
        $content = $page['capability3_task6'];
        $content = $page['capability4_subject'];
        $content = $page['capability4_task1'];
        $content = $page['capability4_task2'];
        $content = $page['capability4_task3'];
        $content = $page['capability4_task4'];
        $content = $page['capability4_task5'];
        $content= $page['capability4_task6'];
        $content = $page['video'];
        $content = $page['audio'];
        $content = $page['content'];
        $makeValues = function($id) use ($content) {
            return "($id, '$content')";
        };
        $post_t_id_joined = implode(', ', array_map($makeValues, $post_t_ids));
        $sql = "INSERT INTO pages ";
        $sql .= "(topic_id, menu_name, position, visible, capabity_name, capability_subject, capability_task1, capability_task2, capability_task3, capability_task4, capability_task5, capability_task6, capability2_subject, capability2_task1, capability2_task2, capability2_task3, capability2_task4, capability2_task5, capability2_task6, capability3_subject, capability3_task1, capability3_task2, capability3_task3, capability3_task4, capability3_task5, capability3_task6, capability4_subject, capability4_task1, capability4_task2, capability4_task3, capability4_task4, capability4_task5, capability4_task6, video, audio, content) ";
        $sql .= "VALUES $post_t_id_joined";
        $result = mysqli_query($db, $sql);
        // For INSERT statements, $result is true/false
        if($result) {
            return true;
        } else {
            // INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
}
// corresponding $errors from the above code
// Warning: mysqli_real_escape_string() expects parameter 2 to be string, array given in C:\xampp\htdocs\db_project\private\database.php on line 14
// Column count doesn't match value count at row 1


// my initial code - no errors but will not post/save to db multiple values
function insert_page($page) {
    global $db;
    $errors = validate_page($page);
    if(!empty($errors)) {
        return $errors;
    }
    shift_page_positions(0, $page['position'], $page['topic_id']);
    foreach($_POST['topic_id'] as $post_t_id) {
        $post_t_ids[] = (int) $post_t_id;
    }
    $post_t_id_joined = implode(', ', $post_t_ids);
    $sql = "INSERT INTO pages ";
    $sql .= "(topic_id, menu_name, position, visible, capability_name, capability_subject, capability_task1, capability_task2, capability_task3, capability_task4, capability_task5, capability_task6, capability2_subject, capability2_task1, capability2_task2, capability2_task3, capability2_task4, capability2_task5, capability2_task6, capability3_subject, capability3_task1, capability3_task2, capability3_task3, capability3_task4, capability3_task5, capability3_task6, capability4_subject, capability4_task1, capability4_task2, capability4_task3, capability4_task4, capability4_task5, capability4_task6, video, audio, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $post_t_id_joined) . "',";
    $sql .= "'" . db_escape($db, $page['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $page['position']) . "',";
    $sql .= "'" . db_escape($db, $page['visible']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_name']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_subject']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task1']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task2']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task3']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task4']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task5']) . "',";
    $sql .= "'" . db_escape($db, $page['capability_task6']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_subject']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task1']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task2']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task3']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task4']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task5']) . "',";
    $sql .= "'" . db_escape($db, $page['capability2_task6']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_subject']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task1']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task2']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task3']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task4']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task5']) . "',";
    $sql .= "'" . db_escape($db, $page['capability3_task6']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_subject']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task1']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task2']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task3']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task4']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task5']) . "',";
    $sql .= "'" . db_escape($db, $page['capability4_task6']) . "',";
    $sql .= "'" . db_escape($db, $page['video']) . "',";
    $sql .= "'" . db_escape($db, $page['audio']) . "',";
    $sql .= "'" . db_escape($db, $page['content']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// other code
// if(is_array($_POST['topic_id'])) {
//     for($i = 0; $topic['id'] = count($_POST['topic_id']), $i < $topic['id']; $i++) {
//         $_POST['topic_id'] = implode(', ', $_POST['topic_id']);
// $post_t_ids = array();
//     }
// }
?>
