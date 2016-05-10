<?php $this->assign('username', $username) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#search-form" style="cursor: pointer">Search
                log messages
            </div>
            <div class="panel-body panel-collapse collapse" id="search-form">
                <form id="search-form" name="search_form" class="form-horizontal" method="post">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 col-md-2 text-right-not-xs">
                                <label for="search-form-query-input" class="control-label">Text message:</label>
                            </div>
                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <input id="search-form-query-input" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button id="add-button" class="btn btn-danger pull-right" data-toggle="modal"
                data-target="#add-group"><span class="fa fa-eraser"></span> Clear logs
        </button>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="hidden-xs hidden-sm">#</th>
                <th class="col-sm-9 col-md-8">Message</th>
                <th class="hidden-xs hidden-sm">Level</th>
                <th class="hidden-xs">Fire date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td class="hidden-xs hidden-sm"><?= $log['id'] ?></td>
                    <td class="col-sm-9 col-md-8 col-lg-9"><?= $log['message'] ?></td>
                    <td class="hidden-xs hidden-sm"><?= $log['level'] ?></td>
                    <td class="hidden-xs"><?= $log['date'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?= $this->Html->script('logs.js', ['block' => true]); ?>