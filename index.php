<?php
require_once './assets/php/common-data.php';
require_once './assets/php/header.php';
?>
<div class="body">
    <div class="folders">
        <ul>
            <li>
                <a href="/storage/">Home</a>
            </li>
            <?php
            foreach ($nav as $name => $items ) :
                $url = '/storage/'.$name;
                ?>
                <li class="<?=(!empty($items)?'hasKids':'')?> <?=menuCheck($url)?>">
                    <a href="<?=formatURL($url)?>"><?=$name?></a>
                <?php
                if ( !empty($items) ) :
                    ?>
                    <ul class="submenu">
                    <?php
                    foreach ($items as $name2 => $items2 ) :
                        $url2 = $url."/".$name2;
                        ?>
                        <li class="<?=(!empty($items2)?'hasKids':'')?> <?=menuCheck($url2)?>">
                            <a href="<?=formatURL($url2)?>"><?=$name2?></a>
                            <?php
                            if ( !empty($items2) ) :
                                ?>
                                <ul class="submenu">
                                    <?php
                                    foreach ($items2 as $name3 => $items3 ) :
                                        $url3 = $url2."/".$name3;
                                        ?>
                                        <li class="<?=(!empty($items3)?'hasKids':'')?> <?=menuCheck($url3)?>">
                                            <a href="<?=formatURL($url3)?>"><?=$name3?></a>
                                            <?php
                                            if ( !empty($items3) ) :
                                                ?>
                                                <ul class="submenu">
                                                    <?php
                                                    foreach ($items3 as $name4 => $items4 ) :
                                                        $url4 = $url3."/".$name4;
                                                        ?>
                                                        <li class="<?=(!empty($items4)?'hasKids':'')?><?=menuCheck($url4)?>">
                                                            <a href="<?=$url4?>"><?=$name4?></a>
                                                        </li>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </ul>
                                                <?php
                                            endif;
                                            ?>
                                        </li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                                <?php
                            endif;
                            ?>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    </ul>
                    <?php
                endif;
                ?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="files">
        <?php if ( !empty($files) ) : ?>
        <ul>
            <?php
            foreach ($files as $name => $item ) :
                $size = fileSizeConvert(filesize($item));
                ?>
            <li>
                <a href="<?=$params['base'].$params['folder'].'/'.$name?>" target="_blank"><?=$name?> (<?=$size?>)</a>
            </li>
                <?php
            endforeach;
            ?>
        </ul>
        <?php else : ?>
        <div class="noFiles">
            No files in this folder.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
require_once './assets/php/footer.php';
?>