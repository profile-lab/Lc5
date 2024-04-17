<?php if (isset($single_items) && $single_items != null) { ?>
    <div class="card_listing_item">
    <?= (isset($single_items->permalink) && $single_items->permalink != null) ? '<a href="'.$single_items->permalink.'" title="'.$single_items->titolo.'" >' : '' ?>
        <?= h4($single_items->titolo) ?>
        <?= single_img($single_items->main_img_path, 'thumbs', true) ?>
        <?= txt($single_items->abstract) ?>
    <?= (isset($single_items->permalink) && $single_items->permalink != null) ? '</a>' : '' ?>
    </div>
<?php } ?>