<div class="content_delivery mb-1">

    <?php if ($item['can_cancel'] == 0)  : ?>
        <?php if ($item['delivery_service']) : ?>
            <?php $deliveryUrl = getDeliveryServiceUrl($item['delivery_service']) . $item['delivery_track']; ?>
            <div class="d-inline-block">
                <span class="badge bg-info">
                    <?=$item['delivery_service']?>
                </span>
            </div>
            <div class="d-inline-block small">
                <a data-bs-custom-class="tooltip" data-bs-placement="top" data-bs-title="Трек-номер"
                   data-bs-toggle="tooltip" href="<?=$deliveryUrl?>" target="_blank">
                    <?=$item['delivery_track']?>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
