<?php
    require_once('../../../private/initialize.php');
    require_login();
    if(is_post_request()) {
        $page = [];
        $page['topic_id'] = $_POST['topic_id'] ?? '';
        $page['menu_name'] = $_POST['menu_name'] ?? '';
        $page['position'] = $_POST['position'] ?? '';
        $page['visible'] = $_POST['visible'] ?? '';
        $page['capability_name'] = $_POST['capability_name'] ?? '';
        $page['capability_subject'] = $_POST['capability_subject'] ?? '';
        $page['capability_task1'] = $_POST['capability_task1'] ?? '';
        $page['capability_task2'] = $_POST['capability_task2'] ?? '';
        $page['capability_task3'] = $_POST['capability_task3'] ?? '';
        $page['capability_task4'] = $_POST['capability_task4'] ?? '';
        $page['capability_task5'] = $_POST['capability_task5'] ?? '';
        $page['capability_task6'] = $_POST['capability_task6'] ?? '';
        $page['capability2_subject'] = $_POST['capability2_subject'] ?? '';
        $page['capability2_task1'] = $_POST['capability2_task1'] ?? '';
        $page['capability2_task2'] = $_POST['capability2_task2'] ?? '';
        $page['capability2_task3'] = $_POST['capability2_task3'] ?? '';
        $page['capability2_task4'] = $_POST['capability2_task4'] ?? '';
        $page['capability2_task5'] = $_POST['capability2_task5'] ?? '';
        $page['capability2_task6'] = $_POST['capability2_task6'] ?? '';
        $page['capability3_subject'] = $_POST['capability3_subject'] ?? '';
        $page['capability3_task1'] = $_POST['capability3_task1'] ?? '';
        $page['capability3_task2'] = $_POST['capability3_task2'] ?? '';
        $page['capability3_task3'] = $_POST['capability3_task3'] ?? '';
        $page['capability3_task4'] = $_POST['capability3_task4'] ?? '';
        $page['capability3_task5'] = $_POST['capability3_task5'] ?? '';
        $page['capability3_task6'] = $_POST['capability3_task6'] ?? '';
        $page['capability4_subject'] = $_POST['capability4_subject'] ?? '';
        $page['capability4_task1'] = $_POST['capability4_task1'] ?? '';
        $page['capability4_task2'] = $_POST['capability4_task2'] ?? '';
        $page['capability4_task3'] = $_POST['capability4_task3'] ?? '';
        $page['capability4_task4'] = $_POST['capability4_task4'] ?? '';
        $page['capability4_task5'] = $_POST['capability4_task5'] ?? '';
        $page['capability4_task6'] = $_POST['capability4_task6'] ?? '';
        $page['video'] = $_FILES['video']['name'] ?? '';
        $page['audio'] = $_FILES['audio']['name'] ?? '';
        $page['content'] = $_POST['content'] ?? '';
        $result = insert_page($page);
        if(!isset($_POST['topic_id'])) {
            $_POST['topic_id'] = [];
        }
        if($result === true) {
            $new_id = mysqli_insert_id($db);
            $_SESSION['message'] = 'The page was created successfully.';
            redirect_to(url_for('/content/content_pages/show.php?id=' . $new_id));
        } else {
            $errors = $result;
        }
    } else {
        $page = [];
        $page['topic_id'] = $_GET['topic_id'] ?? '1';
        $page['menu_name'] = '';
        $page['position'] = '';
        $page['visible'] = '';
        $page['capability_name'] = '';
        $page['capability_subject'] = '';
        $page['capability_task1'] = '';
        $page['capability_task2'] = '';
        $page['capability_task3'] = '';
        $page['capability_task4'] = '';
        $page['capability_task5'] = '';
        $page['capability_task6'] = '';
        $page['capability2_subject'] = '';
        $page['capability2_task1'] = '';
        $page['capability2_task2'] = '';
        $page['capability2_task3'] = '';
        $page['capability2_task4'] = '';
        $page['capability2_task5'] = '';
        $page['capability2_task6'] = '';
        $page['capability3_subject'] = '';
        $page['capability3_task1'] = '';
        $page['capability3_task2'] = '';
        $page['capability3_task3'] = '';
        $page['capability3_task4'] = '';
        $page['capability3_task5'] = '';
        $page['capability3_task6'] = '';
        $page['capability4_subject'] = '';
        $page['capability4_task1'] = '';
        $page['capability4_task2'] = '';
        $page['capability4_task3'] = '';
        $page['capability4_task4'] = '';
        $page['capability4_task5'] = '';
        $page['capability4_task6'] = '';
        $page['video']['name'] = '';
        $page['audio']['name'] = '';
        $page['content'] = '';
    }
    $page_count = count_pages_by_topic_id($page['topic_id']) + 1;
    $page_title = 'Create Page';
    include (SHARED_PATH . '/admin_header.php');
?>

<div id="content">
    <?php include(SHARED_PATH. './admin_nav.php') ?>
    <a class="back-link" href="<?php echo url_for('/content/content_pages/index.php'); ?>">&laquo; Return to Pages List</a>
    <div class="page new">
        <h1>Create Page</h1>
        <?php echo display_errors($errors); ?>
        <form action="<?php echo url_for('/content/content_pages/new.php'); ?>" method="post" enctype="multipart/form-data">
            <dl>
                <dt>Parent Topic:</dt>
                <dd>
                    <select name="topic_id[]" multiple="multiple" id="select">
                    <!-- <select name="topic_id"> -->
                        <?php
                            $topic_set = find_all_topics();
                            while($topic = mysqli_fetch_assoc($topic_set)) {
                                foreach($topic_set as $topic) {
                                    echo "<option value=\"" . $topic['id'] . "\"";
                                    if($page['topic_id'] == $topic['id']) {
                                        echo " selected";
                                    }
                                    echo ">" . $topic['menu_name'] . "</option>";
                                }
                            }
                            mysqli_free_result();
                        ?>
                    </select>
                    <br>
                    <span class="alert">* Use Cmd click or Ctrll click to select multiple topics.</span>
                    <?php
                        // $topic_set = find_all_topics();
                        // while($topic = mysqli_fetch_assoc($topic_set)) {
                        //     foreach($topic_set as $topic) {
                        //         echo "<input type=\"checkbox\" name=\"topic_id[]\" value=\"" . h($topic['id']) . "\"";
                        //         if($page['topic_id'] == $topic['id']) {
                        //             echo " checked";
                        //         }
                        //         echo ">";
                        //         echo "<label>" . h($topic['menu_name']) . "</label>";
                        //     }
                        // }
                    ?>
                </dd>
            </dl>
            <dl>
                <dt>Page Name:</dt>
                <dd>
                    <input type="text" name="menu_name" value="<?php echo $page['menu_name']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Position:</dt>
                <dd>
                    <select name="position">
                        <?php
                            for($i = 1; $i <= $page_count; $i++) {
                                echo "<option value=\"{$i}\"";
                                if($page['position'] == $i) {
                                    echo " selected";
                                }
                                echo ">{$i}</option>";
                            }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Published:</dt>
                <dd>
                    <input type="hidden" name="visible" value="0">
                    <input type="checkbox" name="visible" value="1"<?php if($page['topic_id'] == "1") { echo " checked"; } ?>>
                </dd>
            </dl>
            <dl>
                <dt>Capability Title:</dt>
                <dd>
                    <input type="text" name="capability_name" value="<?php echo $page['capability_name']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Capability 1 Subject:</dt>
                <dd>
                    <input type="text" name="capability_subject" value="<?php echo $page['capability_subject']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Capability 1 Tasks:</dt>
                <dd>
                    <input type="text" name="capability_task1" value="<?php echo $page['capability_task1']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability_task2" value="<?php echo $page['capability_task2']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability_task3" value="<?php echo $page['capability_task3']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability_task4" value="<?php echo $page['capability_task4']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability_task5" value="<?php echo $page['capability_task5']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability_task6" value="<?php echo $page['capability_task6']; ?>">
                </dd>
            </dl>
            <hr>
            <dl>
                <dt>Capability 2 Subject:</dt>
                <dd>
                    <input type="text" name="capability2_subject" value="<?php echo $page['capability2_subject']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Capability 2 Tasks:</dt>
                <dd>
                    <input type="text" name="capability2_task1" value="<?php echo $page['capability2_task1']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability2_task2" value="<?php echo $page['capability2_task2']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability2_task3" value="<?php echo $page['capability2_task3']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability2_task4" value="<?php echo $page['capability2_task4']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability2_task5" value="<?php echo $page['capability2_task5']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability2_task6" value="<?php echo $page['capability2_task6']; ?>">
                </dd>
            </dl>
            <hr>
            <dl>
                <dt>Capability 3 Subject:</dt>
                <dd>
                    <input type="text" name="capability3_subject" value="<?php echo $page['capability3_subject']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Capability 3 Tasks:</dt>
                <dd>
                    <input type="text" name="capability3_task1" value="<?php echo $page['capability3_task1']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability3_task2" value="<?php echo $page['capability3_task2']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability3_task3" value="<?php echo $page['capability3_task3']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability3_task4" value="<?php echo $page['capability3_task4']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability3_task5" value="<?php echo $page['capability3_task5']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability3_task6" value="<?php echo $page['capability3_task6']; ?>">
                </dd>
            </dl>
            <hr>
            <dl>
                <dt>Capability 4 Subject:</dt>
                <dd>
                    <input type="text" name="capability4_subject" value="<?php echo $page['capability4_subject']; ?>">
                </dd>
            </dl>
            <dl>
                <dt>Capability 4 Tasks:</dt>
                <dd>
                    <input type="text" name="capability4_task1" value="<?php echo $page['capability4_task1']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability4_task2" value="<?php echo $page['capability4_task2']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability4_task3" value="<?php echo $page['capability4_task3']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability4_task4" value="<?php echo $page['capability4_task4']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability4_task5" value="<?php echo $page['capability4_task5']; ?>">
                </dd>
                <dd>
                    <input type="text" name="capability4_task6" value="<?php echo $page['capability4_task6']; ?>">
                </dd>
            </dl>
            <hr>

            <dl>
                <dt>Content:</dt>
                <dd>
                    <textarea name="content" cols="60" rows="10"><?php echo $page['content']; ?></textarea>
                </dd>
            </dl>
            <dl>
                <dt>Video:</dt>
                <dd>
                    <input type="file" name="video" accept="video/*" value="<?php echo $page['video']; ?>">
                    <div class="alert">* Allowed file types, .mp4, .mov, .mpeg.</div>
                </dd>
            </dl>
            <dl>
                <dt>Audio:</dt>
                <dd>
                    <input type="file" name="audio" accept="audio/*" value="<?php echo $page['audio']; ?>">
                    <div class="alert">* Allowed file types, .mp3, .wav.</div>
                </dd>
            </dl>
            <div id="operations">
                <input class="btn btn-green" type="submit" name="submit" value="Create Page">
            </div>
        </form>
    </div>
</div>
<script>
    var select = document.getElementById('select');
    select.size = select.length;
</script>
<?php include(SHARED_PATH . '/admin_footer.php'); ?>
