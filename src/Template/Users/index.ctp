<?php $this->assign('username', $username) ?>
    <div class="container">
        <button id="add-button" class="btn btn-success pull-right" data-toggle="modal"
                data-target="#add-user"><span class="fa fa-plus"></span> Add new user
        </button>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th class="hidden-xs">PCs count</th>
                <th class="hidden-xs">Products count</th>
                <th class="hidden-xs">Contact</th>
                <th class="hidden-xs">Addition date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td class="hidden-xs"><?= $user['pcs_count'] ?></td>
                    <td class="hidden-xs"><?= $user['products_count'] ?></td>
                    <td class="hidden-xs"><?= $this->Html->link($user['contact'], $user['contact'], ['target' => '_blank']) ?></td>
                    <td class="hidden-xs"><?= $user['addition_date'] ?></td>
                    <td>
                        <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                            <button type="button" class="btn btn-warning"
                                    onclick="showEditUserDialog(<?= $user['id'] ?>);"><span
                                    class="fa fa-pencil-square-o"></span></button>
                            <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-lock']), ['controller' => 'users', 'action' => 'block', $user['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                            <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'users', 'action' => 'delete', $user['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="edit-user" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit user</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-user-form" name="edit_user" class="form-horizontal bootstrap-form-with-validation"
                          method="post"
                          action="">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-user-name-input">User name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="user_name" id="edit-user-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-user-contact-input">Contact:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="user_contact" id="edit-user-contact-input"
                                       required="required" onclick="this.setSelectionRange(0, this.value.length)">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="edit-user-note-textarea">Note:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="user_note" class="form-control" rows="5"
                                      id="edit-user-note-textarea"></textarea>
                            </div>
                        </div>
                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'users', 'action' => 'save']); ?>"
                               id="edit-user-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="edit_user.submit();"><span
                            class="glyphicon glyphicon-floppy-save"></span> Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="add-user" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add user</h4>
                </div>
                <div class="modal-body">
                    <form name="add_user" class="form-horizontal bootstrap-form-with-validation" method="post"
                          action="<?= $this->Url->build(['controller' => 'users', 'action' => 'add']); ?>">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-user-name-input">User name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="user_name" id="add-user-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-user-contact-input">Contact:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="user_contact" id="add-user-contact-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="add-user-note-textarea">Note:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="user_note" class="form-control" rows="5"
                                      id="add-user-note-textarea"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="add_user.submit();"><span
                            class="glyphicon glyphicon-plus"></span> Add
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
<?= $this->Html->script('users.js', ['block' => true]); ?>