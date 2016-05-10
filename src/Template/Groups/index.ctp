<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?php $this->assign('isMobile', $isMobile) ?>
<div class="container">
    <button id="add-button" class="btn btn-success pull-right" data-toggle="modal"
            data-target="#add-group"><span class="fa fa-plus"></span> Add new group
    </button>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Addition date</th>
            <th>Edit date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?= $group['id'] ?></td>
                <td><?= $group['name'] ?></td>
                <td><?= $group['addition_date'] ?></td>
                <td><?= $group['edit_date'] ?></td>
                <td>
                    <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                        <button type="button" class="btn btn-warning"
                                onclick="showEditUserDialog(<?= $group['id'] ?>);"><span
                                class="fa fa-pencil-square-o"></span></button>
                        <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'users', 'action' => 'delete', $group['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="edit-group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit user <span id="edit-group-caption"></span></h4>
            </div>
            <div class="modal-body">
                <form id="edit-group-form" name="edit_group" class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-group-name-input">Name:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_name" id="edit-group-name-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-group-login-input">Login:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_login" id="edit-group-login-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-group-group-id-input">Group:</label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="user_group_id" id="edit-group-group-id-input"
                                    data-live-search="true">

                            </select>
                        </div>
                    </div>
                    <input type="hidden"
                           value="<?= $this->Url->build(['controller' => 'Groups', 'action' => 'save']); ?>"
                           id="edit-group-form-action">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="edit_group.submit();"><span
                        class="glyphicon glyphicon-floppy-save"></span> Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<div id="add-group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add user</h4>
            </div>
            <div class="modal-body">
                <form id="add-group-form" name="add_group" class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="<?= $this->Url->build(['controller' => 'Groups', 'action' => 'add']); ?>">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-group-name-input">Name:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="group_name" id="add-group-name-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-group-group-permissions-input">Permissions:</label>
                        </div>
                        <div class="col-sm-5">
                            <select multiple  class="form-control" name="group_permissions[]" id="add-group-group-permissions-input"
                                    data-live-search="true">
                                <?php foreach ($permissions as $controller=>$actions): ?>
                                <optgroup label="<?= $controller ?>"
                                    <?php foreach ($actions as $action): ?>
                                        <option value="<?= "$controller/$action" ?>"><?= $action ?></option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add_group.submit();"><span
                        class="glyphicon glyphicon-plus"></span> Add
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('groups.js', ['block' => true]); ?>
