<?php $this->assign('username', $username) ?>
<?= $this->Html->css('awesome-bootstrap-checkbox.css', ['block' => true]) ?>
    <div class="container">
        <button id="add-button" class="btn btn-success pull-right" data-toggle="modal"
                data-target="#add-new-product"><span class="fa fa-plus"></span> Add new product
        </button>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Product name</th>
                <th class="hidden-xs">Version</th>
                <th class="hidden-xs">Hidden</th>
                <th class="hidden-xs">Addition date</th>
                <th class="hidden-xs">Update date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td class="hidden-xs"><?= $product['version'] ?></td>
                    <td class="hidden-xs"><?= $product['is_hidden'] ?></td>
                    <td class="hidden-xs"><?= $product['addition_date'] ?></td>
                    <td class="hidden-xs"><?= $product['update_date'] ?></td>
                    <td>
                        <div class="btn-group btn-group-xs btn-group-xs-small" role="group">
                            <button type="button" class="btn btn-info"
                                    onclick="showUploadNewProductVersionDialog(<?= $product['id'] ?>);"><span
                                    class="fa fa-upload"></span></button>
                            <button type="button" class="btn btn-warning"
                                    onclick="showEditProductDialog(<?= $product['id'] ?>);"><span
                                    class="fa fa-pencil-square-o"></span></button>
                            <button type="button" class="btn btn-success download-link-generator hidden-xs hidden-sm"
                                    data-clipboard-text="<?= $this->Url->build(['controller' => 'products', 'action' => 'download', $product['id']], true); ?>">
                                <span class="fa fa-copy"></span>
                            </button>
                            <?= $this->Form->postLink($this->Html->tag('span', '', ['class' => 'fa fa-remove']), ['controller' => 'products', 'action' => 'delete', $product['id']], ['class' => 'btn btn-danger', 'escape' => false]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="add-new-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new product</h4>
                </div>
                <div class="modal-body">
                    <form name="add_product_form" class="form-horizontal bootstrap-form-with-validation"
                          enctype="multipart/form-data" method="post"
                          action="<?= $this->Url->build(['controller' => 'products', 'action' => 'add']); ?>">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-new-product-name-input">Product name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="product_name"
                                       id="add-new-product-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label">Hidden:</label>
                            </div>
                            <div class="col-sm-5">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" id="add-new-product-hidden-checkbox" name="product_hidden">
                                    <label for="add-new-product-hidden-checkbox"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label">Product file:</label>
                            </div>
                            <div class="col-sm-5">
                                <input type="file" data-filename-placement="inside" name="product_file"
                                       accept=".exe,.dll">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="add-new-product-download-name-input">Download
                                    name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="product_download_name"
                                       id="add-new-product-download-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="add-new-product-description">Description:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="product_description" class="form-control" rows="5"
                                      id="add-new-product-description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="add_product_form.submit();"><span
                            class="fa fa-plus"></span> Add product
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="update-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload new version</h4>
                </div>
                <div class="modal-body">
                    <form id="update-product-form" name="update_product_form" class="form-horizontal bootstrap-form-with-validation"
                          enctype="multipart/form-data" method="post"
                          action="">
                        <div class="form-group">
                            <div class="col-sm-6 text-right-not-xs">
                                <label class="control-label">Product file:</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="file" data-filename-placement="inside" name="product_file"
                                       accept=".exe,.dll">
                            </div>
                        </div>
                        <input type="hidden" value="<?= $this->Url->build(['controller' => 'products', 'action' => 'update']); ?>" id="update-product-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="upload-button" class="btn btn-primary"
                            onclick="update_product_form.submit();"><span class="fa fa-upload"></span> Upload
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit product <span id="edit-product-caption"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="edit-product-form" name="edit_product"
                          class="form-horizontal bootstrap-form-with-validation" method="post" action="">
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-product-name-input">Product name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="product_name" id="edit-product-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label">Hidden:</label>
                            </div>
                            <div class="col-sm-5">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" id="edit-product-hidden-checkbox" name="product_hidden">
                                    <label for="edit-product-hidden-checkbox"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label class="control-label" for="edit-product-download-name-input">Download
                                    name:</label>
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="product_download_name"
                                       id="edit-product-download-name-input"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right-not-xs">
                                <label for="edit-product-description-textarea">Description:</label>
                            </div>
                            <div class="col-sm-5">
                            <textarea name="product_description" class="form-control" rows="5"
                                      id="edit-product-description-textarea"></textarea>
                            </div>
                        </div>
                        <input type="hidden"
                               value="<?= $this->Url->build(['controller' => 'products', 'action' => 'save']); ?>"
                               id="edit-product-form-action">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="edit_product.submit();"><span
                            class="glyphicon glyphicon-floppy-save"></span> Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
<?= $this->Html->script('bootstrap.file-input.js', ['block' => true]); ?>
<?= $this->Html->script('clipboard.min.js', ['block' => true]); ?>
<?= $this->Html->script('products.js', ['block' => true]); ?>