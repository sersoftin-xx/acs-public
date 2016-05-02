<?php $this->assign('username', $username) ?>
<?= $this->Html->css('bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-addon.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-datetimepicker.min.css', ['block' => true]) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#search-form" style="cursor: pointer">Search
                recent bids
            </div>
            <div class="panel-body panel-collapse collapse" id="search-form">
                <form id="search-form" name="search_form" class="form-horizontal" method="post">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-4 text-right-not-xs">
                                <label for="search-form-query-input" class="control-label">Enter bid id, pc name or product
                                    name:</label>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-8">
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
                <th>Product</th>
                <th>PC name</th>
                <th class="hidden-xs hidden-sm hidden-md">PC unique key</th>
                <th class="hidden-xs">Application date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($recent_bids as $recent_bid): ?>
                <tr>
                    <td><?= $recent_bid['id'] ?></td>
                    <td><?= $recent_bid['product']['name'] ?></td>
                    <td><?= $recent_bid['pc']['name'] ?></td>
                    <td class="hidden-xs hidden-sm hidden-md"><?= $recent_bid['pc']['unique_key'] ?></td>
                    <td class="hidden-xs"><?= $recent_bid['application_date'] ?></td>
                    <td>
                        <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                            <button type="button" class="btn btn-success"
                                    onclick="showAcceptBidDialog(<?= $recent_bid['id'] ?>);"><span
                                    class="fa fa-check"></span></button>
                            <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'bids', 'action' => 'reject', $recent_bid['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="accept-bid" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Accept bid <span id="accept-bid-caption"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="accept-bid-form" name="accept_bid" class="form-horizontal bootstrap-form-with-validation"
                          method="post" action="">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-4 text-right-not-xs">
                                <label class="control-label" for="accept-bid-expiration-date-input">Expiration
                                    date:</label>
                            </div>
                            <div class="col-xs-12 col-sm-5">
                                <div class="input-group date" id="accept-bid-expiration-date-input-group">
                                    <input id="accept-bid-expiration-date-input" name="bid_expiration_date"
                                           type="text" class="form-control" readonly="readonly">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div id="max-date" class="col-xs-4 col-sm-2">
                                <button type="button" class="btn btn-default" onclick="setMaxDate()">
                                    <span class="glyphicon glyphicon-time"></span> Max date
                                </button>
                            </div>
                        </div>
                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'bids', 'action' => 'accept']); ?>"
                               id="accept-bid-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="accept_bid.submit();"><span
                            class="fa fa-check"></span> Accept
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-datetimepicker.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('recent_bids.js', ['block' => true]); ?>