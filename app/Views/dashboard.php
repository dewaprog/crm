<?= $this->extend('layout/template'); ?>

<!-- <?= d($company); ?> -->
<?= $this->section('headlink'); ?>
<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
<script src="js/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="/css/app.css">
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<?php //d($member); 
?>
<div class="container-fluid pb-3">
    <div class="d-grid gap-3" style="grid-template-columns: 1fr 1fr;">

        <div class="bg-light border rounded-1">
            <select name='company' id='company'>
                <?php
                if (isset($company))
                    foreach ($company as $r) { ?>
                    <option value="<?= $r['company_id'] ?>"><?= $r['company_name']; ?></option>
                <?php } ?>
            </select>
            <br>
            <br>
            <br>
            <a href="#addCompany" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Project</span></a>
            <br><br><br><br><br><br><br><br><br>
        </div>
        <div class="bg-light border rounded-3">
            <br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>

<!-- Add Modal HTML -->
<div id="addCompany" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name='project' method="post" action='/project/save'>
                <div class="modal-header">
                    <h4 class="modal-title"><?php if (isset($title)) echo $title ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input id='company_id' name='company_id' type="hidden" class="form-control">
                        <input id='project_name' name='project_name' type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Default view :</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="default_view" value="1" id="rd_list">
                            <label class="form-check-label" for="rd_list">
                                LIST
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="default_view" id="rd_board" value="2" checked>
                            <label class="form-check-label" for="rd_board">
                                BOARD
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="default_view" id="rd_calender" value="3" checked>
                            <label class="form-check-label" for="rd_calender">
                                CALENDER
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>is Approval :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_approval" id="is_approval" value="1">
                            <label class="form-check-label" for="is_approval">
                                Yes
                            </label>
                        </div>
                    </div>
                    <div class="form-group hide" id='div-approval'>
                        <label>Approval by :</label>
                        <input type="text" name='approval_by' id="approval_by" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Member :</label>
                        <input type="text" name='member' id="member" class="form-control" />
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="button" id='btn-save' class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#company_id").val($("#company").val());
        $("#company").on('change', function() {
            $("#company_id").val($(this).val());
        });
        if ($("#project_name").val() == "") $("#btn-save").addClass('disabled');
        else $("#btn-save").removeClass('disabled');

        $("#project_name").keyup(function() {

            if (this.value == "") $("#btn-save").addClass('disabled');
            else $("#btn-save").removeClass('disabled');
        });

        var data = '<?= ($member); ?>';
        var app = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace("email"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: jQuery.parseJSON(data) //your can use json type
        });
        app.initialize();

        var elt = $("#approval_by");
        elt.tagsinput({
            itemValue: "id",
            itemText: "email",
            typeaheadjs: {
                name: "app",
                displayKey: "email",
                source: app.ttAdapter()
            }
        });

        var m = $("#member");
        m.tagsinput({
            itemValue: "id",
            itemText: "email",
            typeaheadjs: {
                name: "member",
                displayKey: "email",
                source: app.ttAdapter()
            }
        });

        $("#is_approval").click(function() {
            // alert(this.checked);
            if (this.checked == true) {
                $("#div-approval").removeClass('hide');

            } else {
                $("#div-approval").addClass('hide');
                $('#approval_by').tagsinput('removeAll');
            }
        });

        $("#btn-save").click(function() {

            // alert($("#member").tagsinput('items'));
            console.log($("#member").tagsinput('items'));
            $(this).parents('form').submit();
        });
    });
    //insert data to input in load page
    // elt.tagsinput("add", {
    //     value: 1,
    //     text: "task 1",
    //     continent: "task"
    // });
</script>
<?= $this->endsection(); ?>