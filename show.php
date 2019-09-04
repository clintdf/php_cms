<?php
    require_once('../../../private/initialize.php');
    require_login();
    $id = $_GET['id'] ?? '1';
    $page = find_page_by_id($id);
    $topic = find_topic_by_id($page['topic_id']);
    $page_title = "Show Page";
    include(SHARED_PATH . '/admin_header.php');
?>
<div id="content">
    <?php include(SHARED_PATH. './admin_nav.php') ?>
    <a class="back-link" href="<?php echo url_for('/content/content_pages/index.php'); ?>"> &laquo; Return to Pages List</a>
    <div class="page show">
        <h1>Page: <?php echo h($page['menu_name']); ?></h1>
        <div>
            <dl>
                <dt>Parent Topic:</dt>
                <dd>
                    <?php
                        $t_name = [$topic['menu_name']];
                        $top_name = $t_name;
                        $i = 0;
                        foreach($t_name as $name) {
                            $i++;
                            echo h($name);
                        }
                     ?>
                </dd>
            </dl>
            <dl>
                <dt>Page Name:</dt>
                <dd>
                    <?php echo h($page['menu_name']); ?>
                </dd>
            </dl>
            <dl>
                <dt>Position:</dt>
                <dd>
                    <?php echo h($page['position']) ?>
                </dd>
            </dl>
            <dl>
                <dt>Published:</dt>
                <dd>
                    <?php echo $page['visible'] == "1" ? 'true' : 'false'; ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability Title:</dt>
                <dd>
                    <?php echo $page['capability_name']; ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 1 Subject:</dt>
                <?php echo '<dd>' . $page['capability_subject'] . '</dd>'; ?>
            </dl>
            <dl>
                <dt>Capability 1 Tasks:</dt>
                    <?php
                        $capability_tasks1 = [
                            $page['capability_task1'],
                            $page['capability_task2'],
                            $page['capability_task3'],
                            $page['capability_task4'],
                            $page['capability_task5'],
                            $page['capability_task6']
                        ];
                        $capability_tasks1 = array_filter($capability_tasks1);
                        foreach($capability_tasks1 as $task1) {
                            if(!empty($capability_tasks1)) {
                                echo '<dd>' . $task1 . '</dd>';
                            }
                        }
                    ?>
            </dl>
            <dl>
                <dt>Capability 2 Subject</dt>
                <dd>
                    <?php echo '<dd>' . $page['capability2_subject'] . '</dd>'; ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 2 Tasks:</dt>
                <dd>
                    <?php
                        $capability_tasks2 = [
                            $page['capability2_task1'],
                            $page['capability2_task2'],
                            $page['capability2_task3'],
                            $page['capability2_task4'],
                            $page['capability2_task5'],
                            $page['capability2_task6']
                        ];
                        $capability_tasks2 = array_filter($capability_tasks2);
                        foreach($capability_tasks2 as $task2) {
                            if(!empty($capability_tasks2)) {
                                echo $task2;
                            }
                        }
                    ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 3 Subject:</dt>
                <dd>
                    <?php echo '<dd>' . $page['capability3_subject'] . '</dd>'; ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 3 Tasks</dt>
                <dd>
                    <?php
                        $capability_tasks3 = [
                            $page['capability3_task1'],
                            $page['capability3_task2'],
                            $page['capability3_task3'],
                            $page['capability3_task4'],
                            $page['capability3_task5'],
                            $page['capability3_task6']
                        ];
                        $capability_tasks3 = array_filter($capability_tasks3);
                        foreach($capability_tasks3 as $task3) {
                            if(!empty($capability_tasks3)) {
                                echo $task3;
                            }
                        }
                    ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 4 Subject:</dt>
                <dd>
                    <?php echo '<dd>' . $page['capability4_subject'] . '</dd>'; ?>
                </dd>
            </dl>
            <dl>
                <dt>Capability 4 Tasks:</dt>
                <dd>
                    <?php
                        $capability_tasks4 = [
                            $page['capability4_task1'],
                            $page['capability4_task2'],
                            $page['capability4_task3'],
                            $page['capability4_task4'],
                            $page['capability4_task5'],
                            $page['capability4_task6']
                        ];
                        $capability_tasks4 = array_filter($capability_tasks4);
                        foreach($capability_tasks4 as $task4) {
                            if(!empty($capability_tasks4)) {
                                echo $task4;
                            }
                        }
                    ?>
                </dd>
            </dl>
            <dl>
                <dt>Content:</dt>
                <dd>
                    <p><?php echo h($page['content']); ?></p>
                </dd>
            </dl>
            <dl>
                <dt>Video:</dt>
                <dd>
                    <?php echo $page['video']; ?>
                </dd>
            </dl>
            <dl>
                <dt>Audio</dt>
                <dd>
                    <?php echo $page['audio']; ?>
                </dd>
            </dl>
        </div>
        <div>
            <a href="<?php echo url_for('/index.php?id' . h(u($page['id'])) . '&preview=true'); ?>"></a>
        </div>
    </div>
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
