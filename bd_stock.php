<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Armazém - Stock</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">STOCK</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-3">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-stock">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>

                        <div class="table-responsive-lg mt-3" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Cod Interno</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Entradas</th>
                                        <th scope="col">Saidas</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Tipo UN</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="stock-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add stock modal -->

    <div class="modal fade" id="add-stock" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_stock_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Item</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cod Interno</label>
                                <input type="text" name="codint" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo UN</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-select" name="un">
                                        <option value="UN" selected>Unidade</option>
                                        <option value="L">Litro</option>
                                        <option value="M">Metro</option>
                                        <option value="KG">Kilograma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome</label>
                                <input type="text" min="1" name="nome" class="form-control shadow-none" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Stock modal -->

    <div class="modal fade" id="edit-item" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_item_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Item</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cod Interno</label>
                                <input type="text" name="codint" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo UN</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-select" name="un">
                                        <option value="UN" selected>Unidade</option>
                                        <option value="L">Litro</option>
                                        <option value="M">Metro</option>
                                        <option value="KG">Kilograma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Nome</label>
                                <input type="text" min="1" name="nome" class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" name="item_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <script>
        let add_stock_form = document.getElementById('add_stock_form');

        add_stock_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_item();
        })

        function add_item() {
            let data = new FormData();
            data.append('add_item', '');
            data.append('codint', add_stock_form.elements['codint'].value);
            data.append('un', add_stock_form.elements['un'].value);
            data.append('nome', add_stock_form.elements['nome'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/stock.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('add-stock');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 0) {
                    alert('success', 'Novo Item Adicionado com Sucesso!');
                    add_stock_form.reset();
                    get_all_items();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }

            xhr.send(data);
        }

        function get_all_items() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/stock.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


            xhr.onload = function() {
                document.getElementById('stock-data').innerHTML = this.responseText;
            }

            xhr.send('get_all_items');
        }

        function rem_item(val) {
            if(confirm("Queres mesmo apagar este item?")){

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/stock.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function() {
                    if (this.responseText == 1) {
                        alert('success', 'Item Removido com Sucesso!');
                        get_all_items();
                    } else {
                        alert('error', 'Erro do Servidor!');
                    }
                }
                
                xhr.send('rem_item=' + val);
            }
        }

        let edit_item_form = document.getElementById('edit_item_form');

        function edit_item(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/stock.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                let data = JSON.parse(this.responseText);

                edit_item_form.elements['codint'].value = data.itemdata.CodInt;
                edit_item_form.elements['un'].value = data.itemdata.TipoUN;
                edit_item_form.elements['nome'].value = data.itemdata.Nome;
                edit_item_form.elements['item_id'].value = data.itemdata.id;

            }

            xhr.send('get_item=' + id);
        }

        edit_item_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_itens();
        })

        function submit_edit_itens() {
            let data = new FormData();
            data.append('edit_item', '');
            data.append('item_id', edit_item_form.elements['item_id'].value);
            data.append('codint', edit_item_form.elements['codint'].value);
            data.append('un', edit_item_form.elements['un'].value);
            data.append('nome', edit_item_form.elements['nome'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/stock.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('edit-item');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert('success', 'Item editado com sucesso!');
                    edit_item_form.reset();
                    get_all_items();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }

            xhr.send(data);
        }

        window.onload = function() {
            get_all_items();
        }
    </script>
</body>

</html>