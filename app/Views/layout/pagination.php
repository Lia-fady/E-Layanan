<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-sm justify-content-end mb-0 mt-3" style="font-size: 0.85rem;">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link shadow-sm text-secondary rounded-start" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link shadow-sm text-muted bg-light rounded-start">&laquo;</span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link shadow-sm <?= $link['active'] ? 'bg-primary border-primary text-white' : 'text-secondary' ?>" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link shadow-sm text-secondary rounded-end" href="<?= $pager->getNext() ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link shadow-sm text-muted bg-light rounded-end">&raquo;</span>
            </li>
        <?php endif ?>
    </ul>
</nav>
