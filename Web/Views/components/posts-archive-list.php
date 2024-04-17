<?php if (isset($posts_list) && is_iterable($posts_list) && count($posts_list) > 0) { ?>
    <section class="post_list">
        <?php
        if (isset($show_archive_header) && $show_archive_header == true) {
            echo '<div class="post_archive_header">';
            echo '<div class="myIn">';
            echo h3($posts_archive_name);
            if (isset($show_archive_link) && $show_archive_link == true) {
                echo cta($posts_archive_index, 'Vai all\'archivio', 'btn-archive');
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
        <div class="myIn">
            <div class="post_list_cards_cnt">
                <?php foreach ($posts_list as $single) { ?>
                    <?= view(customOrDefaultViewFragment('components/post-listing-card'), ['single_items' => $single]) ?>
                <?php } ?>
            </div>
        </div>
        <?php if (isset($pager)) { ?>
            <?= $pager->links() ?>
        <?php } ?>
    </section>
<?php } ?>