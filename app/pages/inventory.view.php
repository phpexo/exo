<!-- Content Row -->
<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-9 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Company Inventory</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Serial</th>
                                <th>Quantity</th>
                                <th>Group</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Serial</th>
                                <th>Quantity</th>
                                <th>Group</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
$inv = new Lagerverwaltung($db);
echo $inv->getItemsTable();
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-3 col-lg-3">
        <div class="card shadow mb-5">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <!-- Card Body -->
                <div class="card-body">
                    <a href="#" class="btn btn-primary btn-block btn-icon-split">
                        <span class="text">Manage Items</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>