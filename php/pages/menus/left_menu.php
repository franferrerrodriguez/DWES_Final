<div id="accordion" style="cursor: pointer">

<?php

include('php/class/Category.class.php');

getCategories();

function getCategories($id = null, $space = "") {

    $categories = Category::getBySubcategoryId($id, "");

    if($categories && $id) {
        $space .= "&nbsp&nbsp&nbsp";
    }

    if($categories) {
        foreach ($categories as $i => $category) {
            $countSubcategory = Category::countSubCategories($category['id']);
            if(!$id) {
                $name = $category['name'];
                $format_name = str_replace(" ","", $name);
                $format_name = str_replace(".","", $format_name);
                $format_name = str_replace(",","", $format_name);
                $format_name = str_replace("(","", $format_name);
                $format_name = str_replace(")","", $format_name);
                $format_name = strtolower($format_name);
?>
                <!-- Open Accordion -->
                <div class="card">
                    <div class="card-header" id="heading<?php echo $format_name; ?>" data-toggle="collapse" data-target="#collapse<?php echo $format_name; ?>" aria-expanded="true" aria-controls="collapse<?php echo $format_name; ?>" title="title">
                        <?php echo $name; ?>
                    </div>
                    <div id="collapse<?php echo $format_name; ?>" class="collapse <?php if($i == 0) { echo 'show'; } ?>" aria-labelledby="heading<?php echo $format_name; ?>" data-parent="#accordion">
<?php
            }

            if($id){
                if($id && $countSubcategory){
                    echo "<a class='a-left-menu' href='#' title='" . $category['description'] . "'>" . $space . "- " . $category['name'] . "</a><br>";
                } else {
                    echo "<a class='a-left-menu' href='" . $category['id'] . "' title='" . $category['description'] . "'>" . $space . "- " . $category['name'] . "</a><br>";
                }
            }

            getCategories($category['id'], $space);

            if(!$id) {
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