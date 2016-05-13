<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-addon.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-datetimepicker.min.css', ['block' => true]) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#search-form" style="cursor: pointer">Поиск активных заявок
            </div>
            <div class="panel-body panel-collapse collapse" id="search-form">
                <form id="search-form" name="search_form" class="form-horizontal" method="post">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-right-not-xs">
                                <label for="search-form-query-input" class="control-label">Номер заявки, продукт, клиент, компьютер:</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                                <input id="search-form-query-input" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Продукт</th>
                <th>Клиент</th>
                <th class="hidden-xs hidden-sm">Компьютер</th>
                <th class="hidden-xs">Дата активации</th>
                <th class="hidden-xs">Дата истечения</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bids as $bid): ?>
                <tr id="bid_<?= $bid['id'] ?>" <?= $this->Time->isPast($bid['expiration_date']) ? ' class="danger"' : '' ?>>
                    <td><?= $bid['id'] ?></td>
                    <td><?= $bid['product']['name'] ?></td>
                    <td><?= $bid['client_name'] ?></td>
                    <td class="hidden-xs hidden-sm  "><?= $bid['pc']['name'] ?></td>
                    <td class="hidden-xs"><?= $bid['activation_date'] ?></td>
                    <td class="hidden-xs"><?= $bid['expiration_date'] ?></td>
                    <td>
                        <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                            <button type="button" class="btn btn-warning"
                                    onclick="showEditActiveBidDialog(<?= $bid['id'] ?>);"><span
                                    class="fa fa-pencil-square-o"></span></button>
                            <?= $this->Form->postLink($this->Html->tag('span', '', [
                                'class' => 'fa fa-lock'
                            ]), [
                                'controller' => 'bids',
                                'action' => 'block', $bid['id']
                            ], [
                                'class' => 'btn btn-danger',
                                'escape' => false,
                                'confirm' => 'Вы действительно хотите заблокировать заявку?'
                            ]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="edit-active-bid" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Редактирование активной заявки <span id="edit-active-bid-caption"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="edit-active-bid-form" name="edit_active_bid"
                          class="form-horizontal bootstrap-form-with-validation" method="post"
                          action="">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-4 text-right-not-xs">
                                <label class="control-label" for="edit-active-bid-product-id-input">Имя продукта:</label>
                            </div>
                            <div class="col-xs-12 col-sm-5">
                                <select class="form-control" name="active_bid_product_id"
                                        id="edit-active-bid-product-id-input"
                                        data-live-search="true">
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-4 text-right-not-xs">
                                <label class="control-label" for="edit-active-bid-expiration-date-input">Дата истечения:</label>
                            </div>
                            <div class="col-xs-12 col-sm-5">
                                <div class="input-group date" id="edit-active-bid-expiration-date-input-group">
                                    <input id="edit-active-bid-expiration-date-input"
                                           name="active_bid_expiration_date" type="text" class="form-control"
                                           readonly="readonly">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                            <div id="max-date" class="col-xs-2 col-sm-2">
                                <button type="button" class="btn btn-default" onclick="setMaxDate()">
                                    <span class="glyphicon glyphicon-time"></span> Макс. дата
                                </button>
                            </div>
                        </div>

                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'bids', 'action' => 'save']); ?>"
                               id="edit-active-bid-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="edit_active_bid.submit();"><span
                            class="glyphicon glyphicon-floppy-save"></span> Сохранить
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-datetimepicker.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('active_bids.js', ['block' => true]); ?>