
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <div class="myIn">
        <?= h3($posts_archive_name) ?>
        <?php 
        if(isset($show_archive_link) && $show_archive_link == true){
            cta($posts_archive_index, 'Vai all\'archivio', 'btn-archive');
        }
         ?>
        <div class="card_listing_cnt">
            <?php foreach ($posts_archive as $single) { ?>
                <?= view(customOrDefaultViewFragment('components/post-listing-card'), ['single_items' => $single]) ?>
            <?php } ?>
        </div>
        <?php if (isset($pager)) { ?>
            <?= $pager->links() ?>
        <?php } ?>
    </div>
<?php } ?>