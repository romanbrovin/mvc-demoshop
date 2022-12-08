<div class="content_basket">

    <?php $basketList = R::findAll('m_basket', 'order_id = ?', [$item['id']]) ?>
    <?php foreach ($basketList as $basket) : ?>
        <?php $product = \app\models\Product::getById($basket['product_id']); ?>
        <?php if ($product) : ?>

            <div class="row">

                <div class="col-md-3 text-center mb-3">
                    <a href="/catalog/<?=$product['category_url']?>/<?=$product['article']?>">
                        <img alt="" class="img-fluid" loading="lazy" src="<?=$product['avatar']?>">
                    </a>
                </div>

                <div class="col-md-9 mb-3">
                    <div>
                        <a href="/adm/product?s_product_id=<?=$product['id']?>">
                            <?=$product['name']?>
                        </a>
                    </div>

                    <div class="small text-secondary">
                        <?=$product['article']?> <?=$product['category_name']?>
                    </div>


                    <div class="fw-bold">
                        <?=$basket['amount']?> шт.
                    </div>

                    <div class="">
                        <?php if ($basket['price_avg'] > 0) : ?>
                            <span class="cursor-help small" data-bs-custom-class="tooltip" data-bs-placement="top"
                                  data-bs-title="Средняя цена покупки" data-bs-toggle="tooltip">
                                    <?=rank($basket['price_avg'])?> ₽
                                </span>
                        <?php else : ?>
                            <span data-bs-custom-class="tooltip" data-bs-placement="top"
                                  data-bs-title="Цена покупки неизвестна" data-bs-toggle="tooltip">
                                    &#129335;&#8205;&#9794;&#65039;
                                </span>
                        <?php endif; ?>

                        <i class="fa-solid fa-arrow-right small"></i>

                        <div class="d-inline-block">
                            <span class="cursor-help fw-bold" data-bs-custom-class="tooltip"
                                  data-bs-placement="top" data-bs-title="Цена продажи"
                                  data-bs-toggle="tooltip">
                                <?php if ($item['marketplace'] == 'ozon') : ?>
                                    <?=rank($basket['price_ozon'])?> ₽
                                <?php elseif ($item['marketplace'] == 'dbs') : ?>
                                    <?=rank($basket['price_dbs'])?> ₽
                                <?php elseif ($item['marketplace'] == 'wb') : ?>
                                    <?=rank($basket['price_wb'])?> ₽
                                <?php elseif ($item['marketplace'] == 'avito') : ?>
                                    <?=rank($basket['price_avito'])?> ₽
                                <?php else : ?>
                                    <?php if ($product['price_adv_discount_sum'] > 0) : ?>
                                        <?=rank($product['price_adv_discount'])?> ₽
                                    <?php else : ?>
                                        <?=rank($basket['price_adv'])?> ₽
                                    <?php endif; ?>
                                <?php endif; ?>
                            </span>
                        </div>

                    </div>

                    <?php if ($item['current_status'] == 'checkouted' || $item['current_status'] == 'confirmed' || $item['current_status'] == 'written_off') : ?>
                    <div class="mt-2" style="border-left: 2px dashed #ddd; padding-left: 10px">
                        <?php $storageData = R::findAll('m_storage', 'product_id = ?', [$basket['product_id']]); ?>
                        <?php foreach ($storageData as $storage) : ?>
                            <?php $warehouse = R::load('m_warehouse', $storage['warehouse_id']); ?>
                            <?php if ($warehouse['name']) : ?>
                                <div class="small text-secondary">
                                    <?=$warehouse['name']?>
                                    <?=($storage['rack']) ? ' &bull; с' . $storage['rack'] : '';?>
                                    <?=($storage['pallet']) ? ' &bull; п' . $storage['pallet'] : '';?>
                                    <?=($storage['box']) ? ' &bull; к' . $storage['box'] : '';?>
                                </div>
                            <?php else : ?>
                                <div>
                                    <span data-bs-custom-class="tooltip" data-bs-placement="top"
                                          data-bs-title="Адрес склада отсутствует" data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-secondary mt-2 mb-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Товар удален со склада
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>
