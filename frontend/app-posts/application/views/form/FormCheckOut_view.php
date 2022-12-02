<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<div class="card border-primary mb-3">
    <div class="card-body">
        <button class="btn btn-outline-success" onclick="tambah_data()"><i class="fas fa-fw fa-plus-circle"></i> Tambah</button>
        <button class="btn btn-outline-secondary" onclick="reload_table()"><i class="fas fa-fw fa-sync"></i> Segarkan</button>
        <button class="btn btn-outline-danger" onclick="bulk_delete()"><i class="fas fa-fw fa-trash"></i> Hapus Semua</button>

        <hr/>

        <h5>Tabel</h5>
        <div class="table-responsive">
            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="check-all"></th>
                        <th scope="col">Nomor Polisi</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Tanggal Keluar</th>
                        <th scope="col">Jam Keluar</th>
                        <th scope="col">Jenis Kendaraan</th>
                        <th scope="col">Biaya Parkir</th>
                        <th scope="col"></th>
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
                        <td>@mdo</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                    </tr>
                </tbody>
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
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('FormCheckOut/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
            ],
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        //check all
        $("#check-all").click(function () {
            $(".data-check").prop('checked', $(this).prop('checked'));
        });

        //custom
        $("#nomor_polisi").on({
            change: function () {
                let dis = $(this);
                console.log("run");
                console.log(dis.val());

                $.ajax({
                    url: "<?= site_url('FormCheckOut/ajax_list_by/') ?>" + dis.val(),
                    type: "GET",
                    data: {},
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function (data)
                    {
                        console.log(data);
                        console.log(data.data.jenis_kendaraan);
                        if (data.status) {
                            let dataC = data.data;
                            $("#tanggal_masuk").val(dataC.tanggal);
                            $("#jam_masuk").val(dataC.jam);
                            $("#jenis_kendaraan").val(dataC.jenis_kendaraan);
                            $("#biaya_parkir").val(dataC.biaya_parkir)
                        } else {

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                    }
                })
            },
        });
    });

    function tambah_data()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
    }

    function ubah_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('FormCheckOut/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="id"]').val(data.id);
                $('[name="nama"]').val(data.nama);
                $('[name="harga"]').val(data.harga);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Data'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save()
    {
        $('#btnSave').text('Menyimpan ...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method === 'add') {
            url = "<?php echo site_url('FormCheckOut/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('FormCheckOut/ajax_update') ?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data)
            {
                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }

    function hapus_data(id)
    {
        if (confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('FormCheckOut/ajax_delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }

    function bulk_delete()
    {
        var list_id = [];
        $(".data-check:checked").each(function () {
            list_id.push(this.value);
        });
        if (list_id.length > 0)
        {
            if (confirm('Are you sure delete this ' + list_id.length + ' data?'))
            {
                $.ajax({
                    type: "POST",
                    data: {id: list_id},
                    url: "<?php echo site_url('FormCheckOut/ajax_bulk_delete') ?>",
                    dataType: "JSON",
                    success: function (data)
                    {
                        if (data.status)
                        {
                            reload_table();
                        } else
                        {
                            alert('Failed.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            }
        } else
        {
            alert('no data selected');
        }
    }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Data</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="nama">Nomor Polisi</label>
                            <div class="col-md">
                                <input id="nomor_polisi" name="nomor_polisi" placeholder="Nomor Polisi" class="form-control" type="text" maxlength="10" min="6">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Tanggal Masuk</label>
                            <div class="col-md">
                                <input id="tanggal_masuk" name="tanggal_masuk" placeholder="Tanggal Masuk" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Jam Masuk</label>
                            <div class="col-md">
                                <input id="jam_masuk" name="jam_masuk" placeholder="Jam Masuk" class="form-control" type="time">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Tanggal Keluar</label>
                            <div class="col-md">
                                <input id="tanggal_keluar" name="tanggal_keluar" placeholder="Tanggal Keluar" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Jam keluar</label>
                            <div class="col-md">
                                <input id="jam_keluar" name="jam_keluar" placeholder="Jam Keluar" class="form-control" type="time">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Jenis Kendaraan</label>
                            <div class="col-md">
                                <select id="jenis_kendaraan" name="jenis_kendaraan" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Sepeda Motor">Sepeda Motor</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Truk">Truk</option>
                                    <option value="Bus">Bus</option>
                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Biaya Parkir</label>
                            <div class="col-md">
                                <input id="biaya_parkir" name="biaya_parkir" placeholder="Biaya Parkir" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-minus-circle"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->