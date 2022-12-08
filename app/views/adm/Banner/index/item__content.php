<div class="item__content row">

    <div class="col-3">
        <?php $pathToAvatar = "/uploads/banners/{$item['id']}/thumb-{$item['photo']}"; ?>
        <?php $item['avatar'] = isImageExist($pathToAvatar); ?>

        <?php if ($item['photo']) : ?>
            <div class="d-flex justify-content-end">
                <div class="btn-round btn-round_small btn-round_delete btn-delete btn__delete-photo"
                     data-bs-custom-class="tooltip" data-bs-placement="top"
                     data-bs-title="Удалить фотографию" data-bs-toggle="tooltip"></div>
            </div>
        <?php endif; ?>

        <label class="btn-photo" data-bs-custom-class="tooltip" data-bs-placement="top"
               data-bs-title="Загрузить фотографию" data-bs-toggle="tooltip">
            <input accept="image/jpeg,image/png" class="btn__upload-photo"
                   id="files_<?=$item['id']?>" type="file">
            <img alt="" class="img-fluid" loading="lazy" src="<?=$item['avatar']?>">
        </label>
    </div>

    <div class="col-9 ">
        <div class="" style="font-size: 12px;color: #999">
            Ссылка на баннер
        </div>
        <div class="mt-1">
            <a href="<?=$item['url']?>">
                <?=$item['url']?>
            </a>
        </div>
    </div>
</div>