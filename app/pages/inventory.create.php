
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
                <div class="container px-5 my-5">
                    <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <div class="form-floating mb-3">

                        <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
<div id="qr-reader" style="width: 500px"></div>
<script>function onScanSuccess(decodedText, decodedResult) {
    console.log(`Code scanned = ${decodedText}`, decodedResult);
}
var html5QrcodeScanner = new Html5QrcodeScanner(
	"qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);</script>


                            <input class="form-control" id="barcode" type="text" placeholder="Barcode"
                                data-sb-validations="required" />
                            <label for="barcode">Barcode</label>
                            <div class="invalid-feedback" data-sb-feedback="barcode:required">Barcode is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text" placeholder="Name"
                                data-sb-validations="required" />
                            <label for="name">Name</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">Name is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="serial" type="text" placeholder="Serial"
                                data-sb-validations="required" />
                            <label for="serial">Serial</label>
                            <div class="invalid-feedback" data-sb-feedback="serial:required">Serial is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="quantety" type="text" placeholder="Quantety"
                                data-sb-validations="required" />
                            <label for="quantety">Quantety</label>
                            <div class="invalid-feedback" data-sb-feedback="quantety:required">Quantety is required.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="group" aria-label="Group">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <label for="group">Group</label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg disabled" id="submitButton"
                                type="submit">Submit</button>
                        </div>
                    </form>
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
