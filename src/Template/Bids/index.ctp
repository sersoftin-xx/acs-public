<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('awesome-bootstrap-checkbox.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-addon.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-datetimepicker.min.css', ['block' => true]) ?>
<?= $this->Html->css('daterangepicker.css', ['block' => true]) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Search bids</div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-xs-3 col-sm-4 col-md-3 search-form-label text-right">
                                <label for="search-form-product_id" class="control-label">Product:</label>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-9">
                                <select class="form-control" name="search_form_product_id" id="search-form-product_id"
                                        data-live-search="true">
                                    <option value="0">All</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-xs-3 col-sm-4 col-md-2 search-form-label text-right">
                                <label class="control-label">User:</label>
                            </div>
                            <div class="col-xs-9 col-sm-8 col-md-10">
                                <select class="form-control" name="search_form_user_id" id="search-form-user-id"
                                        data-live-search="true">
                                    <option value="0">All</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 search-form-label text-right">
                                <label class="control-label hidden-xs">Activation date:</label>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group date" id="search-form-activation-date-from">
                                            <input name="search_form_activation_date_from" type="text"
                                                   class="form-control"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group date" id="search-form-activation-date-to">
                                            <input name="search_form_activation_date_to" type="text"
                                                   class="form-control"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div
                        </div>
                        <div class="checkbox checkbox-success checkbox-inline">
                            <input type="checkbox" class="styled" id="search-form-use-date" value="option1" checked="">
                            <label for="search-form-use-date"></label>
                        </div>
                    </div>
                    <div class="col-md-3 pull-right search-button">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-search hidden-xs hidden-sm"></span>
                            Search bid
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Product<span class="hidden-xs"> name</span></th>
            <th>User name</th>
            <th class="hidden-xs hidden-sm">User PC name</th>
            <th class="hidden-xs">Activation date</th>
            <th class="hidden-xs">Expiration date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bids as $bid): ?>
            <tr<?= $this->Time->isPast($bid['expiration_date']) ? ' class="danger"' : '' ?>>
                <td><?= $bid['id'] ?></td>
                <td><?= $bid['product']['name'] ?></td>
                <td><?= $bid['username'] ?></td>
                <td class="hidden-xs hidden-sm  "><?= $bid['pc']['name'] ?></td>
                <td class="hidden-xs"><?= $bid['activation_date'] ?></td>
                <td class="hidden-xs"><?= $bid['expiration_date'] ?></td>
                <td>
                    <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                        <button type="button" class="btn btn-warning"
                                onclick="showEditActiveBidDialog(<?= $bid['id'] ?>);"><span
                                class="fa fa-pencil-square-o"></span></button>
                        <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-lock']), ['controller' => 'bids', 'action' => 'block', $bid['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div id="edit-active-bid" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit active bid</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-active-bid-form" name="edit_active_bid"
                          class="form-horizontal bootstrap-form-with-validation" method="post"
                          action="">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-active-bid-product-id-input">Product
                                    name:</label>
                            </div>
                            <div class="col-sm-5">
                                <select name="active_bid_product_id" id="edit-active-bid-product-id-input"
                                        data-live-search="true">
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-active-bid-expiration-date-input">Expiration
                                    date:</label>
                            </div>
                            <div class="col-sm-5">
                                <div class='input-group date' id='edit-active-bid-expiration-date-input-group'>
                                    <input id="edit-active-bid-expiration-date-input"
                                           name="active_bid_expiration_date" type='text' class="form-control"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'bids', 'action' => 'save']); ?>"
                               id="edit-active-bid-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="edit_active_bid.submit();">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-datetimepicker.min.js', ['block' => true]); ?>
<?= $this->Html->script('daterangepicker.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('active_bids.js', ['block' => true]); ?>