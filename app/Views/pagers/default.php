<?php $pager->setSurroundCount(2) ?>
<nav aria-label="Page navigation">
    <ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
        </li>
        <li class="page-item ">
            <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
            <a href="<?= $link['uri'] ?>" class="page-link">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li>
        <li class="page-item ">
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>

<!-- 
<ul class="pagination">
    <li class="page-item previous disabled"><a href="#" class="page-link"><i class="previous"></i></a></li>
    <li class="page-item "><a href="#" class="page-link">1</a></li>
    <li class="page-item active"><a href="#" class="page-link">2</a></li>
    <li class="page-item "><a href="#" class="page-link">3</a></li>
    <li class="page-item "><a href="#" class="page-link">4</a></li>
    <li class="page-item "><a href="#" class="page-link">5</a></li>
    <li class="page-item "><a href="#" class="page-link">6</a></li>
    <li class="page-item next"><a href="#"  class="page-link"><i class="next"></i></a></li>
</ul> -->