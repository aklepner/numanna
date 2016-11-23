<!-- Begin magiczoomplus -->
<div class="MagicToolboxContainer selectorsBottom minWidth">
    <?php if(!empty($main)) echo $main; ?>
    <?php if(count($thumbs)): ?>
    <div class="MagicToolboxSelectorsContainer">
        <div id="MagicToolboxSelectors<?php echo $pid; ?>" class="more-views">
            <h2><?php echo $moreViewsCaption ?></h2>
            <ul class="product-image-thumbs">
            <?php foreach($thumbs as $thumb): ?>
                <li><?php echo $thumb; ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif ?>
</div>
<!-- End magiczoomplus -->
