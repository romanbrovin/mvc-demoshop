<div class="d-flex mt-3 mb-3">
    <h2 class="marker">
        <span class="marker_h2">Каталог товаров</span>
    </h2>
</div>

<div class="d-flex row mt-3 mb-3">

    <div class="col-lg-8 col-md-12">
        <ul class="list-inline">
            <li class="list-inline-item text-secondary">
                Сортировать по:
            </li>
            <?php foreach ($sort['searchFields'] as $field) : ?>
                <li class="list-inline-item">
                    <a class="s_query" href="#" data-query="<?=$sort['query_' . $field['query']]?>">
                        <?=$field['name']?> <?=$sort['arrow_' . $field['query']]?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="d-flex col-lg-4 col-md-12">
        <ul class="list-inline ms-lg-auto">
            <li class="list-inline-item text-secondary">
                Товаров на странице:
            </li>

            <?php foreach ($sort['listPerPage'] as $item) : ?>
                <?php if ($sort['perPage'] == $item) : ?>
                    <li class="list-inline-item fw-bold text-secondary">
                        <?=$item?>
                    </li>
                <?php else : ?>
                    <li class="list-inline-item">
                        <a class="n_query" href="#" data-query="<?=$item?>">
                            <?=$item?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

</div>

<input type="hidden" id="s" value="<?=$sort['searchQuery']?>">
<input type="hidden" id="q" value="<?=$sort['sortQuery']?>">
<input type="hidden" id="n" value="<?=$sort['perPage']?>">
