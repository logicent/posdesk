<div class="row">
<?php
if (!empty($items)) :
    foreach ($items as $id => $item) : ?>
    <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
        <?php 
            $img_path = Model_Product_Item::getValue('image_path', $item->id) ?>
            <img src="<?= empty($img_path) ? 'images/image-ph.jpg' : $img_path ?>" alt="..." class="">
            <div class="caption">
                <h5><?= Model_Product_Item::getValue('item_name', $item->id) ?></h5>
                <p class="small text-muted"><?= Model_Product_Item::getValue('description', $item->id) ?></p>
                <!-- <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p> -->
            </div>
        </div>
    </div>
<?php 
    endforeach;
endif ?>
</div>
