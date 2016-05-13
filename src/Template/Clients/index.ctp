<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?php $this->assign('isMobile', $isMobile) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#search-form" style="cursor: pointer">Поиск клиентов
            </div>
            <div class="panel-body panel-collapse collapse" id="search-form">
                <form id="search-form" name="search_form" class="form-horizontal" method="post">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3 text-right-not-xs">
                                <label for="search-form-query-input" class="control-label">Имя клиента или контакт:</label>
                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
                                <input class="form-control" type="text" id="search-form-query-input">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button id="add-button" class="btn btn-success pull-right" data-toggle="modal"
                data-target="#add-client"><span class="fa fa-plus"></span> Добавить клиента
        </button>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th class="hidden-xs hidden-sm">Количество компьютеров</th>
                <th class="hidden-xs hidden-sm">Количество продуктов</th>
                <th class="hidden-xs">Контакт</th>
                <th class="hidden-xs">Дата добавления</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= $client['id'] ?></td>
                    <td><?= $client['name'] ?></td>
                    <td class="hidden-xs hidden-sm"><?= $client['pcs_count'] ?></td>
                    <td class="hidden-xs hidden-sm"><?= $client['products_count'] ?></td>
                    <td class="hidden-xs"><?= $this->Html->link($client['contact'], $client['contact'], ['target' => '_blank']) ?></td>
                    <td class="hidden-xs"><?= $client['addition_date'] ?></td>
                    <td>
                        <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                            <button type="button" class="btn btn-warning"
                                    onclick="showEditClientDialog(<?= $client['id'] ?>);"><span
                                    class="fa fa-pencil-square-o"></span></button>
                            <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-lock']), ['controller' => 'clients', 'action' => 'block', $client['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                            <?php if (!$isMobile): ?>
                                <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'clients', 'action' => 'delete', $client['id']], ['class' => 'btn btn-danger hidden-xs', 'escape' => false]) ?>
                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="edit-client" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Редактирование клиента <span id="edit-client-caption"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="edit-client-form" name="edit_client" class="form-horizontal bootstrap-form-with-validation"
                          method="post"
                          action="">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-client-name-input">Имя:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="client_name" id="edit-client-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-client-contact-input">Контакт:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="client_contact" id="edit-client-contact-input"
                                       required="required" onclick="this.setSelectionRange(0, this.value.length)">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="edit-client-note-textarea">Примечание:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="client_note" class="form-control" rows="5"
                                      id="edit-client-note-textarea"></textarea>
                            </div>
                        </div>
                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'clients', 'action' => 'save']); ?>"
                               id="edit-client-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="edit_client.submit();"><span
                            class="glyphicon glyphicon-floppy-save"></span> Сохранить
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="add-client" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Добавление клиента</h4>
                </div>
                <div class="modal-body">
                    <form name="add_client" class="form-horizontal bootstrap-form-with-validation" method="post"
                          action="<?= $this->Url->build(['controller' => 'clients', 'action' => 'add']); ?>">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-client-name-input">Имя:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="client_name" id="add-client-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-client-contact-input">Контакт:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="client_contact" id="add-client-contact-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="add-client-note-textarea">Примечание:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="client_note" class="form-control" rows="5"
                                      id="add-client-note-textarea"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="add_client.submit();"><span
                            class="glyphicon glyphicon-plus"></span> Добавить
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('clients.js', ['block' => true]); ?>