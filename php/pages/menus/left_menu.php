<div id="accordion" style="cursor: pointer;">
    <?php
    include('php/class/Category.class.php');

    $categories = Category::getAll();

    if($categories) {
        foreach ($categories as $i => $category) {
            if($category['is_visible']) {
    ?>

    <div class="card">
        <div class="card-header" id="heading<?php echo $category['id']; ?>" data-toggle="collapse" data-target="#collapse<?php echo $category['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $category['id']; ?>" title="<?php echo $category['description']; ?>">
            <?php echo $category['name']; ?>
        </div>
        <div id="collapse<?php echo $category['id']; ?>" class="collapse <?php if($i == 0) { echo 'show'; } ?>" aria-labelledby="heading<?php echo $category['id']; ?>" data-parent="#accordion">
            <div style="margin-top:14px;"></div>

            <?php

            $subcategories = Category::getSubcategories($category['id']);

            if($categories) {
                foreach ($subcategories as $index => $subcategory) {
                    if($subcategory['is_visible']) {
                        echo "<p><a class='a-left-menu' href='" . $subcategory['id'] . "' title='" . $subcategory['description'] . "'>" . $subcategory['name'] . "</a><p>";
                    }
                }
            }

            ?>
        </div>
    </div>

    <?php
                }
            }
        }
    ?>
</div>