<div class="d-flex mb-4">
    <h2 class="marker">
        <span class="marker_h2">Фотографии</span>
    </h2>
</div>

<div class="item" id="<?=$item['id']?>">

    <label class="btn btn-primary">
        <input accept="image/jpeg,image/png" class="btn__upload-photo"
               id="files_<?=$item['id']?>" multiple="multiple" type="file">
        <i class="fa-solid fa-download"></i>
        Загрузить фотографии
    </label>

    <?php $pathToPhotos = "/uploads/goods/$item[category_url]/$item[article]/"; ?>

    <div class="row mt-5">
        <div class="col">

            <?php foreach ($item['photo'] as $photo) : ?>
                <?php if ($photo) : ?>
                    <?php
                    $photoHref = "$pathToPhotos$photo";
                    $photoSrc = isImageExist("{$pathToPhotos}thumb/$photo");
                    $key = str_replace('.', '_', $photo);
                    ?>
                    <div class="item__photo" data-photo="<?=$key?>">
                        <div class="d-flex justify-content-end">
                            <div class="btn__photo_delete btn-round btn-round_small btn-round_delete btn-delete"
                                 data-bs-custom-class="tooltip" data-bs-placement="top"
                                 data-bs-title="Удалить фотографию" data-bs-toggle="tooltip"></div>
                        </div>

                        <a data-fancybox="gallery" href="<?=$photoHref?>">
                            <img alt="" loading="lazy" src="<?=$photoSrc?>">
                        </a>

                        <?php if (isImageAvatar($pathToPhotos, $photo)): ?>
                            <div class="d-flex">
                                <div class="btn__set_avatar btn-round btn-round_small btn-round_event btn-round_avatar"
                                     data-bs-custom-class="tooltip" data-bs-placement="top"
                                     data-bs-title="Сделать аватаркой" data-bs-toggle="tooltip"></div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-3">
            <a class="btn btn-secondary btn__back" href="#">Назад</a>
        </div>
    </div>

    <div class="mb-5 text-secondary small">
        <?php \app\models\App::renderBlock('adm/info', ['position' => 'vertical', 'var' => $item]); ?>
    </div>

</div>