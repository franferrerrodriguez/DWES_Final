<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<h2>Listado de categorías</h2>

<br>

<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011/04/25</td>
            <td>2011/04/25</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>Position</td>
            <td>Office</td>
            <td>Age</td>
            <td>Start date</td>
            <td>Salary</td>
        </tr>
    </tbody>
</table>

<br>

<?php
$button_icon = "plus-circle";
$button_title = "Añadir categoría";
$modal_title = "Añadir categoría";

include('php/pages/common/modal-large.php');
?>

<form>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
        </div>
        <div class="form-group col-md-4">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
    </div>
    <div class="form-group">
        <label for="inputAddress2">Address 2</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputCity">City</label>
        <input type="text" class="form-control" id="inputCity">
        </div>
        <div class="form-group col-md-4">
        <label for="inputState">State</label>
        <select id="inputState" class="form-control">
            <option selected>Choose...</option>
            <option>...</option>
        </select>
        </div>
        <div class="form-group col-md-2">
        <label for="inputZip">Zip</label>
        <input type="text" class="form-control" id="inputZip">
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck">
        <label class="form-check-label" for="gridCheck">
            Check me out
        </label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
</form>

<?php include('php/pages/common/close-modal.php'); ?>