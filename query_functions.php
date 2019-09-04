<?php
    // TOPICS
    function find_all_topics($options=[]) {
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM topics ";
        if($visible) {
            $sql .= "WHERE visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_topic_by_id($id, $options=[]) {
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM topics ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true";
        }
        // echo $sql;
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $topic = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $topic; // returns an assoc. array
    }

    function validate_topic($topic) {
        $errors = [];
        // menu_name
        if(is_blank($topic['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        } elseif(!has_length($topic['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }
        // position
        // make sure we are working with an integer
        $position_int = (int) $topic['position'];
        if($position_int <= 0) {
            $errors[] = "Position must be greater than 0.";
        }
        if($position_int > 999) {
            $errors[] = "Position must be less than 999.";
        }
        // visible
        // make sure we are working with a string
        $visible_str = (string) $topic['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])) {
            $errors[] = "Visible must be true or false.";
        }
        return $errors;
    }

    function insert_topic($topic) {
      global $db;
      $errors = validate_topic($topic);
      if(!empty($errors)) {
          return $errors;
      }
      shift_topic_position(0, $topic['position']);
      $sql = "INSERT INTO topics ";
      $sql .= "(menu_name, position, visible) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $topic['menu_name']) . "',";
      $sql .= "'" . db_escape($db, $topic['position']) . "',";
      $sql .= "'" . db_escape($db, $topic['visible']) . "'";
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

    function update_topic($topic) {
        global $db;
        $errors = validate_topic($topic);
        if(!empty($errors)) {
            return $errors;
        }
        $old_topic = find_topic_by_id($topic['id']);
        $old_position = $old_topic['position'];
        shift_topic_position($old_position, $topic['position'], $topic['id']);
        $sql = "UPDATE topics SET ";
        $sql .= "menu_name='" . db_escape($db, $topic['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db, $topic['position']) . "', ";
        $sql .= "visible='" . db_escape($db, $topic['visible']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $topic['id']) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        if($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_topic($id) {
        global $db;
        $old_topic = find_topic_by_id($id);
        $old_position = $old_topic['position'];
        shift_topic_position($old_position, 0, $id);
        $sql = "DELETE FROM topics ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        if($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function shift_topic_position($start_pos, $end_pos, $current_id=0) {
        global $db;
        if($start_pos == $end_pos) { return; }
        $sql = "UPDATE topics ";
        if($start_pos == 0) {
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif ($end_pos == 0) {
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif ($start_pos < $end_pos) {
            $sql .= "SET position = position - 1 " ;
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
        } elseif ($start_pos > $end_pos) {
            $sql .= "SET position = position - 1 " ;
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }
        $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
        $result = mysqli_query($db, $sql);
        if($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    // PAGES
    function find_all_pages() {
        global $db;
        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY topic_id ASC, position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_page_by_id($id, $options=[]) {
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page; // returns an assoc. array
    }

    function validate_page($page) {
        $errors = [];
        // topic_id
        if(is_blank(implode(' ', $page['topic_id']))) {
        $errors[] = "Topic cannot be blank.";
        }
        // menu_name
        if(is_blank($page['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        } elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }
        // position
        // Make sure we are working with an integer
        $postion_int = (int) $page['position'];
        if($postion_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        if($postion_int > 999) {
            $errors[] = "Position must be less than 999.";
        }
        // visible
        // Make sure we are working with a string
        $visible_str = (string) $page['visible'];
            if(!has_inclusion_of($visible_str, ["0","1"])) {
        $errors[] = "Visible must be true or false.";
        }
        // image
        // if(is_blank($page['page_image'])) {
        //     $errors[] = "Page must include the converstation diagram.";
        // }
        // content
        if(is_blank($page['content'])) {
            $errors[] = "Content cannot be blank.";
        }
        return $errors;
    }

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

    function update_page($page) {
        global $db;
        $errors = validate_page($page);
        if(!empty($errors)) {
            return $errors;
        }
        $old_page = find_page_by_id($page['id']);
        $old_position = $old_page['position'];
        shift_page_positions($old_position, $page['position'], $page['topic_id'], $page['id']);
        $sql = "UPDATE pages SET ";
        $sql .= "topic_id='" . db_escape($db, $page['topic_id']) . "', ";
        $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db, $page['position']) . "', ";
        $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
        $sql .= "capability_name='" . db_escape($db, $page['capability_name']) . "', ";
        $sql .= "capability_subject='" . db_escape($db, $page['capability_subject']) . "', ";
        $sql .= "capability_task1='" . db_escape($db, $page['capability_task1']) . "', ";
        $sql .= "capability_task2='" . db_escape($db, $page['capability_task2']) . "', ";
        $sql .= "capability_task3='" . db_escape($db, $page['capability_task3']) . "', ";
        $sql .= "capability_task4='" . db_escape($db, $page['capability_task4']) . "', ";
        $sql .= "capability_task5='" . db_escape($db, $page['capability_task5']) . "', ";
        $sql .= "capability_task6='" . db_escape($db, $page['capability_task6']) . "', ";
        $sql .= "capability2_subject='" . db_escape($db, $page['capability2_subject']) . "', ";
        $sql .= "capability2_task1='" . db_escape($db, $page['capability2_task1']) . "', ";
        $sql .= "capability2_task2='" . db_escape($db, $page['capability2_task2']) . "', ";
        $sql .= "capability2_task3='" . db_escape($db, $page['capability2_task3']) . "', ";
        $sql .= "capability2_task4='" . db_escape($db, $page['capability2_task4']) . "', ";
        $sql .= "capability2_task5='" . db_escape($db, $page['capability2_task5']) . "', ";
        $sql .= "capability2_task6='" . db_escape($db, $page['capability2_task6']) . "', ";
        $sql .= "capability3_subject='" . db_escape($db, $page['capability3_subject']) . "', ";
        $sql .= "capability3_task1='" . db_escape($db, $page['capability3_task1']) . "', ";
        $sql .= "capability3_task2='" . db_escape($db, $page['capability3_task2']) . "', ";
        $sql .= "capability3_task3='" . db_escape($db, $page['capability3_task3']) . "', ";
        $sql .= "capability3_task4='" . db_escape($db, $page['capability3_task4']) . "', ";
        $sql .= "capability3_task5='" . db_escape($db, $page['capability3_task5']) . "', ";
        $sql .= "capability3_task6='" . db_escape($db, $page['capability3_task6']) . "', ";
        $sql .= "capability4_subject='" . db_escape($db, $page['capability4_subject']) . "', ";
        $sql .= "capability4_task1='" . db_escape($db,  $page['capability4_task1']) . "', ";
        $sql .= "capability4_task2='" . db_escape($db,  $page['capability4_task2']) . "', ";
        $sql .= "capability4_task3='" . db_escape($db,  $page['capability4_task3']) . "', ";
        $sql .= "capability4_task4='" . db_escape($db,  $page['capability4_task4']) . "', ";
        $sql .= "capability4_task5='" . db_escape($db,  $page['capability4_task5']) . "', ";
        $sql .= "capability4_task6='" . db_escape($db,  $page['capability4_task6']) . "', ";
        $sql .= "video='" . db_escape($db, $page['video']) . "', ";
        $sql .= "audio='" . db_escape($db, $page['audio']) . "', ";
        $sql .= "content='" . db_escape($db, $page['content']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_page($id) {
        global $db;
        $old_page = find_page_by_id($id);
        $old_position = $old_page['position'];
        shift_page_positions($old_position, 0, $old_page['topic_id'], $id);
        $sql = "DELETE FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        // For DELETE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function find_pages_by_topic_id($topic_id, $options=[]) {
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE topic_id='" . db_escape($db, $topic_id) . "' ";
        if($visible) {
            $sql .= "AND visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function count_pages_by_topic_id($topic_id, $options=[]) {
        global $db;
        $visible = $options['visible'] ?? false;
        if(isset($_GET['topic_id'])) {
            $sql = "SELECT COUNT(id) FROM pages ";
            $sql .= "WHERE topic_id='" . db_escape($db, implode(', ', $topic_id)) . "' ";
            // $sql .= "WHERE topic_id='" . db_escape($db, $topic_id) . "' ";
            if($visible) {
                $sql .= "AND visible = true ";
            }
            $sql .= "ORDER BY position ASC";
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);
            $row = mysqli_fetch_row($result);
            mysqli_free_result($result);
            $count = $row[0];
            return $count;
        } else if(!isset($_GET['topic_id'])) {
            $sql = "SELECT COUNT(id) FROM pages ";
            $sql .= "WHERE topic_id='" . db_escape($db, $topic_id) . "' ";
            if($visible) {
                $sql .= "AND visible = true ";
            }
            $sql .= "ORDER BY position ASC";
            $result = mysqli_query($db, $sql);
            confirm_result_set($result);
            $row = mysqli_fetch_row($result);
            mysqli_free_result($result);
            $count = $row[0];
            return $count;
        }
    }

    function shift_page_positions($start_pos, $end_pos, $topic_id, $current_id=0) {
        global $db;
        if($start_pos == $end_pos) { return; }
            $sql = "UPDATE pages ";
        if($start_pos == 0) {
            // new item, +1 to items greater than $end_pos
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
        } elseif($end_pos == 0) {
            // delete item, -1 from items greater than $start_pos
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
        } elseif($start_pos < $end_pos) {
            // move later, -1 from items between (including $end_pos)
            $sql .= "SET position = position - 1 ";
            $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
            $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
        } elseif($start_pos > $end_pos) {
            // move earlier, +1 to items between (including $end_pos)
            $sql .= "SET position = position + 1 ";
            $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
            $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
        }
        // Exclude the current_id in the SQL WHERE clause
        $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
        $sql .= "AND topic_id = '" . db_escape($db, $topic_id) . "'";
        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    // ADMIN
    // Find all users, ordered last_name, first_name
    function find_all_users() {
        global $db;
        $sql = "SELECT * FROM admin ";
        $sql .= "ORDER BY last_name ASC, first_name ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_users_by_id($id) {
        global $db;
        $sql = "SELECT * FROM admin ";
        $sql .="WHERE id='" .  db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin;
    }

    function find_user_by_username($username) {
        global $db;
        $sql = "SELECT * FROM admin ";
        $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result); // find first
        mysqli_free_result($result);
        return $admin; // returns an assoc. array
    }

    function validate_user($admin, $options=[]) {
        $password_required = $options['password_required'] ?? true;
        $errors = [];
        if(is_blank($admin['first_name'])) {
            $errors[] = "First name cannot be blank.";
        } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
            $errors[] = "First name must be between 2 and 255 characters.";
        }
        if(is_blank($admin['last_name'])) {
            $errors[] = "Last name cannot be blank.";
        } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
            $errors[] = "Last name must be between 2 and 255 characters.";
        }
        if(is_blank($admin['email'])) {
            $errors[] = "Email cannot be blank.";
        } elseif (!has_length($admin['email'], array('max' => 255))) {
            $errors[] = "Last name must less than 255 characters.";
        } elseif (!has_valid_email_format($admin['email'])) {
            $errors[] = "Email must be a valid format.";
        }
        if(is_blank($admin['username'])) {
            $errors[] = "Username cannot be blank.";
        } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
            $errors[] = "Username must be between 8 and 255 characters.";
        } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
            $errors[] = "Username not allowed. Try another.";
        }
        if($password_required) {
            if(is_blank($admin['password'])) {
                $errors[] = "Password cannot be blank.";
            } elseif (!has_length($admin['password'], array('min' => 8))) {
                $errors[] = "Password must be at least contain 8 characters";
            }
            if(is_blank($admin['confirm_password'])) {
                $errors[] = "Confirm password cannot be blank.";
            } elseif ($admin['password'] !== $admin['confirm_password']) {
                $errors[] = "Password and confirm password must match.";
            }
        }
        return $errors;
    }

    function insert_user($admin) {
        global $db;
        $errors = validate_user($admin);
        if(!empty($errors)) {
            return $errors;
        }
        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO admin ";
        $sql .= "(first_name, last_name, email, username, hashed_password) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
        $sql .= "'" . db_escape($db, $admin['email']) . "',";
        $sql .= "'" . db_escape($db, $admin['username']) . "',";
        $sql .= "'" . db_escape($db, $hashed_password) . "'";
        $sql .= ")";
        $result = mysqli_query($db, $sql);
        if($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_user($admin) {
        global $db;
        $password_sent = !is_blank($admin['password']);
        $errors = validate_user($admin, ['password_required' => $password_sent]);
        if(!empty($errors)) {
            return $errors;
        }
        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE admin SET ";
        $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
        $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
        $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
        if($password_sent) {
            $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
        }
        $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        if($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_user($admin) {
        global $db;
        $sql = "DELETE FROM admin ";
        $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
        $sql .= "LIMIT 1;";
        $result = mysqli_query($db, $sql);
        // For DELETE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
?>
