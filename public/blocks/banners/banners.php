<?php $bannerList = R::findAll('m_banner', 'ORDER BY sort_order DESC'); ?>
<?php if ($bannerList) : ?>
    <div class="banner-block">
        <div class="owl-carousel owl-theme owl-banner">
            <?php foreach ($bannerList as $banner): ?>
                <a href="<?=$banner['url']?>">
                    <img alt="<?=SITE_KEYWORDS?>" loading="lazy"
                         src="/uploads/banners/<?=$banner['id']?>/<?=$banner['photo']?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
