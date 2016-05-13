<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?php $this->assign('isMobile', $isMobile) ?>
<div class="container">
    <button id="add-button" class="btn btn-success pull-right" data-toggle="modal"
            data-target="#add-user"><span class="fa fa-plus"></span> Добавить пользователя
    </button>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Логин</th>
            <th class="hidden-xs">Группа</th>
            <th class="hidden-xs">Дата добавления</th>
            <th class="hidden-xs">Дата изменения</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['login'] ?></td>
                <td class="hidden-xs"><?= $user['group']['name'] ?></td>
                <td class="hidden-xs"><?= $user['addition_date'] ?></td>
                <td class="hidden-xs"><?= $user['edit_date'] ?></td>
                <td>
                    <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                        <button type="button" class="btn btn-warning"
                                onclick="showEditUserDialog(<?= $user['id'] ?>);"><span
                                class="fa fa-pencil-square-o"></span></button>
                        <button type="button" class="btn btn-success"
                                onclick="showResetPasswordDialog(<?= $user['id'] ?>);"><span
                                class="fa fa-undo"></span></button>
                        <?= $this->Form->postLink($this->Html->tag('span', '', [
                            'class' => 'fa fa-remove'
                        ]), [
                            'controller' => 'Users',
                            'action' => 'delete',
                            $user['id']
                        ], [
                            'class' => 'btn btn-danger', 'escape' => false,
                            'confirm' => 'Вы действительно хотите удалить пользователя?'
                        ]) ?>
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
                <h4 class="modal-title">Редактирование пользователя <span id="edit-user-caption"></span></h4>
            </div>
            <div class="modal-body">
                <form id="edit-user-form" name="edit_user" class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-user-name-input">Имя:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_name" id="edit-user-name-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-user-login-input">Логин:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_login" id="edit-user-login-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="edit-user-group-id-input">Группа:</label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="user_group_id" id="edit-user-group-id-input"
                                    data-live-search="true">
                                <?php foreach ($groups as $group): ?>
                                    <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden"
                           value="<?= $this->Url->build(['controller' => 'Users', 'action' => 'save']); ?>"
                           id="edit-user-form-action">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="edit_user.submit();"><span
                        class="glyphicon glyphicon-floppy-save"></span> Сохранить
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Закрыть
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
                <h4 class="modal-title">Добавление пользователя</h4>
            </div>
            <div class="modal-body">
                <form id="add-user-form" name="add_user" class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']); ?>">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-user-name-input">Имя:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_name" id="add-user-name-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-user-login-input">Логин:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_login" id="add-user-login-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-user-password-input">Пароль:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_password" id="add-user-password-input"
                                   required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="add-user-group-id-input">Группа:</label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="user_group_id" id="add-user-group-id-input"
                                    data-live-search="true">
                                <?php foreach ($groups as $group): ?>
                                    <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add_user.submit();"><span
                        class="glyphicon glyphicon-plus"></span> Добавить
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<div id="reset-password-user" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Сброс пароля пользователя <span id="reset-password-user-caption"></span></h4>
            </div>
            <div class="modal-body">
                <form id="reset-password-user-form" name="reset_password"
                      class="form-horizontal bootstrap-form-with-validation"
                      method="post"
                      action="">
                    <div class="form-group">
                        <div class="col-sm-5 text-right-not-xs">
                            <label class="control-label" for="reset-password-user-password-input">Новый пароль:</label>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="user_password"
                                   id="reset-password-user-password-input"
                                   required="required">
                        </div>
                    </div>
                    <input type="hidden"
                           value="<?= $this->Url->build(['controller' => 'Users', 'action' => 'resetPassword']); ?>"
                           id="reset-password-user-form-action">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="reset_password.submit();"><span
                        class="fa fa-undo"></span> Сбросить
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('users.js', ['block' => true]); ?>
