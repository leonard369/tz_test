<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;
$this->addExternalCss(SITE_TEMPLATE_PATH . '/css/sidebar.css');

$this->setFrameMode(true);

$this->SetViewTarget('sidebar', 300);
$frame = $this->createFrame()->begin();

?><div class="sidebar-widget sidebar-widget-birthdays">
    <div class="sidebar-widget-top">
        <div class="sidebar-widget-top-title">Руководители</div>
    </div>
    <div class="sidebar-widget-content">
        <?php

        $i = 0;

        foreach ($arResult['HEAD'] as $id=>$arUser)
        {
            $classList = [
                'sidebar-widget-item',
                '--row',
            ];

            if (++$i === count($arResult['HEAD']))
            {
                $classList[] = 'widget-last-item';
            }
            $avatarStyle = (isset($arUser['PHOTO']['src']) ? "background: url('" . Uri::urnEncode($arUser['PHOTO']['src']) . "') no-repeat center; background-size: cover;" : '');

            ?><a href="/company/personal/user/<?=$id?>/" class="<?= implode(' ', $classList) ?>">
            <span class="user-avatar user-default-avatar" style="<?= $avatarStyle ?>"></span>
            <span class="sidebar-user-info">
				<span class="user-head-name"><?=$arUser['LAST_NAME']?> <?=$arUser['NAME']?></span>
			</span>
            </a><?php
        }
        ?>
    </div>
</div>
<?php

$frame->end();
$this->EndViewTarget();
