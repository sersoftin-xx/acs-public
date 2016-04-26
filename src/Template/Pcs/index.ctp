<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<div class="container">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th class="hidden-xs">User name</th>
            <th>PC name</th>
<!--            <th class="hidden-xs hidden-sm hidden-md">PC unique key</th>-->
            <th class="hidden-xs">Products count</th>
            <th class="hidden-xs">Addition date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pcs as $pc): ?>
            <tr<?= $pc['user_id'] === 0 ? ' class="success"' : '' ?>>
                <td><?= $pc['id'] ?></td>
                <td class="hidden-xs"><?= $this->Html->link($pc['user_id'] === 0 ? 'UNKNOWN USER' : $pc['user']['name'],['controller' => 'pcs', 'action' => 'user', $pc['user_id']] ) ?></td>
                <td><?= $pc['name'] ?></td>
<!--                <td class="hidden-xs hidden-sm hidden-md">--><?//= $pc['unique_key'] ?><!--</td>-->
                <td class="hidden-xs"><?= $pc['products_count'] ?></td>
                <td class="hidden-xs"><?= $pc['addition_date'] ?></td>
                <td>
                    <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                        <button type="button" class="btn btn-warning"
                                onclick="showEditPcDialog(<?= $pc['id'] ?>);"><span
                                class="fa fa-pencil-square-o"></span></button>
                        <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-lock']), ['controller' => 'pcs', 'action' => 'block', $pc['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                        <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'pcs', 'action' => 'delete', $pc['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="edit-pc" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit PC</h4>
            </div>
            <div class="modal-body">
                <form id="edit-pc-form" name="edit_pc" class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-pc-user-id-input">User name:</label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="pc_user_id" id="edit-pc-user-id-input" data-live-search="true">
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-pc-name-input">PC name:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="pc_name" id="edit-pc-name-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label for="edit-pc-comment-textarea">Comment:</label>
                        </div>
                        <div class="col-sm-5">
                            <textarea name="pc_comment" class="form-control" rows="5"
                                      id="edit-pc-comment-textarea"></textarea>
                        </div>
                    </div>
                    <input type="hidden" value="<?= $this->Url->build(['controller' => 'pcs', 'action' => 'save']); ?>"
                           id="edit-pc-form-action">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="edit_pc.submit();"><span
                        class="glyphicon glyphicon-floppy-save"></span> Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('pcs.js', ['block' => true]); ?>
