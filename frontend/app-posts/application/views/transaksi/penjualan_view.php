<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<!-- Select2 -->
<?= link_tag(base_url('assets/select2/dist/css/select2.css'), 'stylesheet', 'text/css') ?>
<?= link_tag(base_url('assets/select2/dist/css/select2-bootstrap.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>"></script>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Selamat Datang!</strong> Halaman ini masih dalam tahap pembuatan.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="card border-primary mb-3">
    <div class="card-body">
        <form class="mb-3">
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <select class="form-control js-example-basic-single" id="validationServer03" name="state" placeholder="Nama Barang" required>
                        <option value="AL">Alabama</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    <div class="invalid-feedback">
                        Please provide a valid city.
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" id="validationServer04" placeholder="Harga" required>
                    <div class="invalid-feedback">
                        Please provide a valid state.
                    </div>
                </div>
                <div class="col-md-1 mb-3">
                    <input type="text" class="form-control" id="validationServer05" placeholder="Qty" required>
                    <div class="invalid-feedback">
                        Required
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" id="validationServer05" placeholder="Sub Total" required>
                    <div class="invalid-feedback">
                        Please provide a valid zip.
                    </div>
                </div>
            </div>
            <div class="custom-switch mb-3">
                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                <label class="custom-control-label" for="customSwitch2">Cetak Nota / Struk</label>
            </div>
            <div class="custom-switch mb-3">
                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                <label class="custom-control-label" for="customSwitch3">Hapus otomatis</label>
            </div>
            <button class="btn btn-outline-primary m-2" type="button"><i class="fas fa-fw fa-cash-register"></i> Transaksi</button>
            <button class="btn btn-outline-danger m-2" type="button"><i class="fas fa-fw fa-eraser"></i> Clear</button>
            <button class="btn btn-outline-success m-2" type="button"><i class="fas fa-fw fa-save"></i> Save</button>
            <button class="btn btn-outline-info m-2" type="button"><i class="far fa-fw fa-edit"></i> Input</button>
            <button class="btn btn-outline-secondary m-2" type="button"><i class="fas fa-fw fa-minus-circle"></i> Cancel</button>
        </form>

        <hr/>
        <h5>Tabel</h5>
        <div class="table-responsive">
            <div class="text-right mb-2 content-responsive">
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio1">Umum</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio2">Pengecer</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Khusus</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio4">Grosir</label>
                    </div>
                </div>
            </div>

            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 30%;">Nama Produk</th>
                        <th scope="col" style="width: 20%;">Harga</th>
                        <th scope="col" style="width: 15%;">Qty</th>
                        <th scope="col" style="width: 15%;">Satuan</th>
                        <th scope="col" style="width: 25%;">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>@fat</td>
                        <td>@fat</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="p-0">
                            <table style="width: 100%;">
                                <tbody>
                                <th scope="col" class="text-right" style="width: 50%;">Total Bayar</th>
                                <th scope="col" style="width: 25%;">
                                    <div class="col">
                                        <label class="sr-only" for="inlineFormInputGroup">Rp.</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                        </div>
                                    </div>
                                </th>
                                <th scope="col" style="width: 25%;">
                                    <div class="col">
                                        <label class="sr-only" for="inlineFormInputGroup">Diskon (%)</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Diskon (%)</div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                        </div>
                                    </div>
                                </th>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" rowspan="4">
                            <svg class="bd-placeholder-img rounded float-right" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 100%x250"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="40%" y="50%" fill="#dee2e6" dy=".3em">100%x250</text></svg>
                        </th>
                        <th scope="col">Total Harga</th>
                        <th scope="col" colspan="2">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup">Rp.</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">Total Diskon</th>
                        <th scope="col" colspan="2">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup">Rp.</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">CASH</th>
                        <th scope="col" colspan="2">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup">Rp.</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">Cash Back</th>
                        <th scope="col" colspan="2">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup">Rp.</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function () {
        //datatables
        table = $('#table').DataTable({})

        $('.js-example-basic-single').select2({
            theme: "bootstrap"
        });
    })
</script>