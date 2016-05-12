<?php $this->assign('username', $username) ?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#search-form" style="cursor: pointer">Поиск сообщений
            </div>
            <div class="panel-body panel-collapse collapse" id="search-form">
                <form id="search-form" name="search_form" class="form-horizontal" method="post">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 col-md-2 text-right-not-xs">
                                <label for="search-form-query-input" class="control-label">Сообщение:</label>
                            </div>
                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <input id="search-form-query-input" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <a id="add-button" class="btn btn-danger pull-right"
           href="<?= $this->Url->build(['controller' => 'Logs', 'action' => 'clear']); ?>"><span
                class="fa fa-eraser"></span> Очистить</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="col-sm-9 col-md-8">Сообщение</th>
                <th class="hidden-xs hidden-sm">Уровень</th>
                <th class="hidden-xs">Дата события</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td class="col-sm-9 col-md-8 col-lg-9"><?= $log['message'] ?></td>
                    <td class="hidden-xs hidden-sm"><?= $log['level'] ?></td>
                    <td class="hidden-xs"><?= $log['date'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?= $this->Html->script('logs.js', ['block' => true]); ?>