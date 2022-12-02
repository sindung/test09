<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<div class="card border-primary mb-3">
    <div class="card-body">
        <button class="btn btn-outline-success" id="tambah-data"><i class="fas fa-fw fa-plus-circle"></i> Tambah</button>
        <button class="btn btn-outline-secondary" id="reload-data"><i class="fas fa-fw fa-sync"></i> Segarkan</button>
        <button class="btn btn-outline-danger" id="bulk-delete"><i class="fas fa-fw fa-trash"></i> Hapus Semua</button>

        <hr/>

        <h5>Tabel</h5>
        <div class="table-responsive">
            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="check-all"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Category</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col">Status</th>
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
                "url": "<?= site_url('AllPosts/ajax_list') ?>",
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
            "initComplete": function (settings, json) {
            },
            "drawCallback": function (settings) {
                fnAction();
            }
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

        $('#tambah-data').click(function () {
            tambah_data()
        });
        $('#reload-data').click(function () {
            reload_table()
        });
        $('#bulk-delete').click(function () {
            bulk_delete()
        });
        $('#btnSave').click(function () {
            save();
        });

    });

    function tambah_data()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('textarea').html('');
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
            url: "<?php echo site_url('AllPosts/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="id"]').val(data.id);
                $('[name="title"]').val(data.title);
//                $('[name="content"]').val(data.content);
                $('[name="content"]').html(data.content);
                $('[name="category"]').val(data.category);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Data'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function status_data(id, new_status)
    {
        var url;

        url = "<?php echo site_url('AllPosts/ajax_update_status') ?>";

        $.ajax({
            url: url,
            type: "POST",
            data: {
                id: id,
                status: new_status
            },
            dataType: "JSON",
            success: function (data)
            {
                if (data.status) //if success close modal and reload ajax table
                {
                    reload_table();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax
        fnAction();
    }

    function save()
    {
        $('#btnSave').text('Menyimpan ...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method === 'add') {
            url = "<?php echo site_url('AllPosts/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('AllPosts/ajax_update') ?>";
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
                url: "<?php echo site_url('AllPosts/ajax_delete') ?>/" + id,
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
                    url: "<?php echo site_url('AllPosts/ajax_bulk_delete') ?>",
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

    function fnAction() {
        $('.ubah-data').click(function (event) {
            let data = $(this).data();
            let id = data.id;

            ubah_data(id);
        });
        $('.hapus-data').click(function (event) {
            let data = $(this).data();
            let id = data.id;

            hapus_data(id);
        });
        $('.status-data').click(function (event) {
            let data = $(this).data();
            let id = data.id;
            let status = data.status;

            status_data(id, status);
        });
        $('.preview').click(function (event) {
            let data = $(this).data();
            let id = data.id;
            let preview = data.preview;

            window.open(preview + id, '_frame');
        });
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
                            <label class="control-label col-md-4" for="title">Title</label>
                            <div class="col-md">
                                <input id="title" name="title" placeholder="Title" class="form-control" type="text" maxlength="10" min="6">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="content">Content</label>
                            <div class="col-md">
                                <!--
                                <input id="content" name="content" placeholder="Content" class="form-control" type="text" maxlength="10" min="6">
                                -->
                                <textarea id="content" name="content" rows="5" cols="10" class="form-control" placeholder="Content"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="category">Category</label>
                            <div class="col-md">
                                <input id="category" name="category" placeholder="Category" class="form-control" type="text" maxlength="10" min="6">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Status</label>
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
                        -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-minus-circle"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->