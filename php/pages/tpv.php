<style>

</style>

<div class="row">
    <div class="col-sm-6">
        <div class="tableFixHead" style="height:500px">
            <table class="table-primary table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="background-color:#b8daff;" class='center'>#</th>
                        <th style="background-color:#b8daff;">Id Artículo</th>
                        <th style="background-color:#b8daff;">Nombre Artículo</th>
                        <th style="background-color:#b8daff;" class='center'>Cantidad</th>
                        <th style="background-color:#b8daff;" class='right'>Precio</th>
                        <th style="background-color:#b8daff;" class='right'>Total</th>
                    </tr>
                </thead>
                <tbody id="orderLines" style="background-color:#fff">
                    <?php
                    for($i = 0; $i < 120; $i++) {
                        echo "<tr>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                            echo "<td>1</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="tpv-text">
            Total: 110€&nbsp
        </div>

        <div class="prueba2" style="height:400px;border:solid 1px #000;">
            <?php
            $r = 0;
            for($i = 0; $i < 21; $i++) {
                if($r === 0) echo "<div class='row' style='cursor:pointer;'>";
                    if($i === 0) {
                        echo "<div class='col-sm tpv-category' style='line-height:155px;'>";
                            echo "<i class='fas fa-undo-alt fa-4x'></i>";
                        echo "</div>";
                    } else {
                        echo "<div class='col-sm tpv-category'>";
                            echo "OK";
                        echo "</div>";
                    }
                if($r === 2) { echo "</div>"; $r = 0; } else { $r++; }
            }
            ?>
        </div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm">
        <table class="table-primary table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Id Artículo</th>
                    <th>Nombre Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="orderLines" style="background-color:#fff">
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm">
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
        <button type="button" class="btn btn-primary" style="width:80px;height:80px;">Primary</button>
    </div>
</div>