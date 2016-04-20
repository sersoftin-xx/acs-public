<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-datetimepicker.min.css', ['block' => true]) ?>
    <div class="container">
        <div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product name</th>
                    <th class="hidden-xs">User name</th>
                    <th class="hidden-xs">User PC name</th>
                    <th class="hidden-xs">Activation date</th>
                    <th class="hidden-xs">Expiration date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bids as $bid): ?>
                    <tr<?= $this->Time->isPast($bid['expiration_date'])  ?  ' class="danger"' : '' ?>>
                        <td><?= $bid['id'] ?></td>
                        <td><?= $this->Html->link($bid['product']['name'], ['controller' => 'bids', 'action' => 'product', $bid['product']['id']]) ?></td>
                        <td class="hidden-xs"><?= $bid['username'] ?></td>
                        <td class="hidden-xs"><?= $this->Html->link($bid['pc']['name'], ['controller' => 'bids', 'action' => 'pc', $bid['pc']['id']]) ?></td>
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
        </div>
    </div>

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
                            <div class="col-sm-5 text-right">
                                <label class="control-label" for="edit-active-bid-product-id-input">Product name:</label>
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
                            <div class="col-sm-5 text-right">
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
                        <input type="hidden" value="<?= $this->Url->build(['controller' => 'bids', 'action' => 'save']); ?>" id="edit-active-bid-form-action">
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
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('active_bids.js', ['block' => true]); ?>