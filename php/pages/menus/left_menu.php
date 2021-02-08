

<div id="accordion" style="cursor: pointer" class="left-menu">
<h6>Todas las categorías</h6>
<?php

require_once("php/class/Category.class.php");

getCategories();

function getCategories($id = null, $space = "") {

    $categories = Category::getBySubcategoryId($id);

    if($categories && $id) {
        $space .= "&nbsp&nbsp&nbsp";
    }

    if($categories) {
        foreach ($categories as $i => $category) {
            $category_id = isset($_REQUEST['category']) ? $_REQUEST['category'] : null;
            $bold = $category_id === $category->getId() ? "font-weight-bold" : "";
            $countSubcategory = Category::countSubCategories($category->getId());
            if(!$id && $category->isActive()) {
                $name = strtolower(formatOnlyString($category->getName()));
                ?>
                <!-- Open Accordion -->
                <div class="card">
                    <div id="heading<?php echo $name; ?>" data-toggle="collapse" data-target="#collapse<?php echo $name; ?>" aria-expanded="true" aria-controls="collapse<?php echo $format_name; ?>" title="title" style="background-color:#f8f9fa;height:30px;line-height:30px;padding-left:6px;">
                        <?php echo $category->getName(); ?>
                    </div>
                    <div id="collapse<?php echo $name; ?>" class="collapse <?php if($i == 0) { echo 'show'; } ?>" aria-labelledby="heading<?php echo $format_name; ?>" data-parent="#accordion">
                <?php
            }

            if($id && $category->isActive()){
                echo "<a class='a-left-menu $bold' href='?page=mosaic-articles&category=" . $category->getId() . "' title='" . $category->getDescription() . "'>" . $space . "- " . $category->getName() . "</a><br>";
            }

            getCategories($category->getId(), $space);

            if(!$id && $category->isActive()) {
                ?>
                <!-- Close Accordion -->
                    </div>
                </div>
                <?php
            }
        }
    }

}
?>

</div>