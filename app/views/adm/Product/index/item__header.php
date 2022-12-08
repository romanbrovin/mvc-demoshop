<?php $category = R::load('m_category', $item['category_id']); ?>
<?php $item['category_name'] = $category['name'] ?>
<?php $item['category_url'] = $category['url'] ?>

<div class="item__header row mb-2">

    <div class="col-md-11 col-10 overflow-hidden">
        <div class="d-flex">

            <h4 class="marker fw-normal m-0 me-2">
                <a href="/catalog/<?=$category['url']?>/<?=$item['article']?>">
                    <span class="<?=$meta['item']['header']['marker'] ?? null;?>">
                        <?=$item['name']?>
                    </span>
                </a>
            </h4>

            <div>
                <?=($item['tag_new'] == 1) ? '<span class="badge bg-teal">Новинка</span>' : null?>
                <?=($item['tag_hit'] == 1) ? '<span class="badge bg-red">Хит продаж</span>' : null?>
                <?=($item['tag_rare'] == 1) ? '<span class="badge bg-indigo">Редкий набор</span>' : null?>
                <?=($item['tag_low_price'] == 1) ? '<span class="badge bg-orange">Гарантия низкой цены</span>' : null?>
            </div>
        </div>

        <div class="text-secondary">
            <?=$item['article']?>
            <a class="link-secondary" href="/adm/product?s_category_id=<?=$category['id']?>">
                <?=$item['category_name']?>
            </a>
            <?=($item['barcode']) ? '<span>/ ' . $item['barcode'] . '</span>' : null?>
        </div>

    </div>

    <div class="col-md-1 col-2 text-end">

        <div class="" style="padding-top: 2px">
            <span class="btn__mark cursor-pointer">
                <?php if ($item['is_select'] == 1) : ?>
                    <i class="fa-solid text-orange fa-bookmark"></i>
                <?php else : ?>
                    <i class="fa-regular fa-bookmark"></i>
                <?php endif; ?>
            </span>
        </div>

    </div>

</div>