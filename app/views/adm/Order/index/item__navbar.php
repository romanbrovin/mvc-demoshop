<div class="item__navbar row">

    <div class="col-6">
        <?php if ($item['can_cancel'] == 1)  : ?>

            <?php if ($item['current_status'] == 'checkouted') : ?>
                <?php if ($item['payment'] == 1) : ?>
                    <a class="order__pay py-0 me-2" href="#">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        Ссылка на оплату
                    </a>
                <?php elseif ($item['payment'] == 2) : ?>
                    <a class="order__confirm btn btn-sm btn-outline-primary py-0 me-2" href="#">
                        Подтвердить заказ
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($item['current_status'] == 'confirmed' || $item['current_status'] == 'paid') : ?>
                <?php if ($item['marketplace'] == 'wb' || $item['delivery_type'] == 'courier' || $item['delivery_track']): ?>
                    <a class="order__transited btn btn-sm btn-outline-primary py-0 me-2" href="#">
                        Отправить заказ
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($item['current_status'] == 'transited') : ?>
                <a class="order__delivered btn btn-sm btn-outline-success py-0 me-2" href="#">
                    Заказ доставлен
                </a>
            <?php endif; ?>

            <?php if ($item['marketplace'] != 'wb' && $item['current_status'] != 'new' && $item['role']) : ?>
                <?php if ($item['delivery_type'] == 'mail' && $item['current_status'] != 'checkouted'): ?>

                    <div class="btn-group btn-group-sm me-1">
                        <input class="btn-check delivery-service" id="delivery-service__pochta_<?=$item['id']?>"
                               name="delivery-service_<?=$item['id']?>" type="radio" value="Почта России"
                            <?=($item['delivery_service'] == 'Почта России') ? 'checked' : null;?>>
                        <label class="btn btn-outline-primary py-0 delivery-service_<?=$item['id']?>
                                <?=($item['delivery_service'] == 'Почта России') ? 'active' : null;?>"
                               for="delivery-service__pochta_<?=$item['id']?>">Почта</label>

                        <input class="btn-check delivery-service" id="delivery-service__cdek_<?=$item['id']?>"
                               name="delivery-service_<?=$item['id']?>" type="radio" value="СДЭК"
                            <?=($item['delivery_service'] == 'СДЭК') ? 'checked' : null;?>>
                        <label class="btn btn-outline-primary py-0 delivery-service_<?=$item['id']?>
                                <?=($item['delivery_service'] == 'СДЭК') ? 'active' : null;?>"
                               for="delivery-service__cdek_<?=$item['id']?>">СДЭК</label>

                        <input class="btn-check delivery-service" id="delivery-service__boxberry_<?=$item['id']?>"
                               name="delivery-service_<?=$item['id']?>" type="radio" value="Boxberry"
                            <?=($item['delivery_service'] == 'Boxberry') ? 'checked' : null;?>>
                        <label class="btn btn-outline-primary py-0 delivery-service_<?=$item['id']?>
                                <?=($item['delivery_service'] == 'Boxberry') ? 'active' : null;?>"
                               for="delivery-service__boxberry_<?=$item['id']?>">Boxberry</label>
                    </div>

                    <?php if ($item['delivery_track']) : ?>
                        <div class="d-inline-block mt-1">
                            <?php $deliveryUrl = getDeliveryServiceUrl($item['delivery_service']) . $item['delivery_track']; ?>
                            <a data-bs-custom-class="tooltip" data-bs-placement="top" data-bs-title="Трек-номер"
                               data-bs-toggle="tooltip" href="<?=$deliveryUrl?>" target="_blank">
                                <?=$item['delivery_track']?>
                            </a>
                            <a class="delivery-track mx-1" data-bs-custom-class="tooltip"
                               data-bs-placement="top" data-bs-title="Редактировать трек-номер"
                               data-bs-toggle="tooltip" href="#">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endif; ?>

            <?php if ($item['delivery_service']) : ?>
                <?php if (!$item['delivery_track']) : ?>
                    <a class="delivery-track btn btn-sm btn-outline-primary py-0 me-2" href="#">
                        Трек-номер
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        <?php else : ?>
            <?php if ($item['current_status'] == 'delivered' || $item['current_status'] == 'written_off') : ?>
                <a class="order__return btn btn-sm btn-outline-secondary py-0 me-2" href="#">
                    Оформить возврат
                </a>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <div class="col-6 text-end">

        <?php if ($item['comment_admin']) : ?>
            <a class="btn__comment me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
               data-bs-title="Изменить заметку" data-bs-toggle="tooltip" href="#">
                <span class="badge badge-comment">
                    <?=$item['comment_admin']?>
                </span>
            </a>
        <?php else : ?>
            <a class="btn__comment me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
               data-bs-title="Добавить заметку" data-bs-toggle="tooltip" href="#">
                <i class="fa-regular fa-comment-dots"></i>
            </a>
        <?php endif; ?>

        <?php if ($item['can_cancel'] == 1) : ?>

            <?php if ($item['marketplace'] == 'adv' &&
                ($item['current_status'] == 'checkouted' || $item['current_status'] == 'confirmed')) : ?>
                <a class="me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                   data-bs-title="Редактировать" data-bs-toggle="tooltip"
                   href="/adm/<?=$uri?>/edit?id=<?=$item['id']?>">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            <?php else : ?>
                <span class="me-1 text-secondary">
                    <i class="fa-regular fa-pen-to-square"></i>
                </span>
            <?php endif; ?>

            <a class="order__cancel text-danger" data-bs-custom-class="tooltip"
               data-bs-placement="top" data-bs-title="Отменить" data-bs-toggle="tooltip" href="#">
                <i class="fa-regular fa-trash-can"></i>
            </a>

        <?php endif; ?>

    </div>

</div>