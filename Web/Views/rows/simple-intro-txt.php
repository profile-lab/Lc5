<div class="row row-intro-txt row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_extra_class ?> <?= $row->css_color ?>">
    <div class="myIn intro-txt__content">
        <?php if (trim($row->titolo) !== '' || trim($row->sottotitolo) !== '') { ?>
            <hgroup>
                <?= h2($row->titolo, 'intro-txt__title') ?>
                <?= h4($row->sottotitolo, 'intro-txt__subtitle') ?>
            </hgroup>
        <?php } ?>
        <?= txt($row->testo, 'intro-txt__description') ?>
    </div>
</div>