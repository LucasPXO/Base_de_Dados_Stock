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
    <title>Stock Armazém - Entradas</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">ENTRADAS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-entrada">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Fact. Nº</th>
                                        <th scope="col">Fornecedor</th>
                                        <th scope="col">Cod Interno</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data Ent.</th>
                                        <th scope="col">Tipo UN</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="entrada-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Entradas modal -->

    <div class="modal fade" id="add-entrada" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_entrada_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Entrada</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Cod Interno - Nome do Item</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-select" name="codint" required>
                                    <option selected disabled></option>
                                        <?php
                                            $res = selectAll('itens');
                                            while ($opt = mysqli_fetch_assoc($res)){
                                                echo"
                                                    <option value='$opt[CodInt]'>$opt[CodInt] - $opt[Nome]</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fact Nº</label>
                                <input type="text" name="factN" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fornecedor</label>
                                <input type="text" min="1" name="fornecedor" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Quantidade Entrada</label>
                                <input type="text" min="1" name="Qnt" class="form-control shadow-none" required>
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

    <!-- Edit Entradas modal -->

    <div class="modal fade" id="edit-entrada" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_entrada_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Entrada</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Cod Interno - Nome do Item</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-select" name="codint" required>
                                        <?php
                                            $res = selectAll('itens');
                                            while ($opt = mysqli_fetch_assoc($res)){
                                                echo"
                                                    <option value='$opt[CodInt]'>$opt[CodInt] - $opt[Nome]</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fact Nº</label>
                                <input type="text" name="factN" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fornecedor</label>
                                <input type="text" min="1" name="fornecedor" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Quantidade Entrada</label>
                                <input type="text" min="1" name="Qnt" class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" name="entrada_id">
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
        let add_entrada_form = document.getElementById('add_entrada_form');

        add_entrada_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_entrada();
        })

        function add_entrada() {
            let data = new FormData();
            data.append('add_entrada', '');
            data.append('codint', add_entrada_form.elements['codint'].value);
            data.append('factN', add_entrada_form.elements['factN'].value);
            data.append('fornecedor', add_entrada_form.elements['fornecedor'].value);
            data.append('Qnt', add_entrada_form.elements['Qnt'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/entradas.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('add-entrada');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 0) {
                    alert('success', 'Novo Entrada Adicionada com Sucesso!');
                    add_entrada_form.reset();
                    get_all_entradas();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }
            
            xhr.send(data);
        }

        function get_all_entradas() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/entradas.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


            xhr.onload = function() {
                document.getElementById('entrada-data').innerHTML = this.responseText;
            }

            xhr.send('get_all_entradas');
        }

        function rem_entrada(val) {
            if(confirm("Queres mesmo apagar esta entrada?")){

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/entradas.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function() {
                    if (this.responseText == 1) {
                        alert('success', 'Entrada Removida com Sucesso!');
                        get_all_entradas();
                    } else {
                        alert('error', 'Erro do Servidor!');
                    }
                }
                
                xhr.send('rem_entrada=' + val);
            }
        }
            
            let edit_entrada_form = document.getElementById('edit_entrada_form');
            
            function edit_entrada(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/entradas.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                let data = JSON.parse(this.responseText);

                edit_entrada_form.elements['codint'].value = data.entradadata.CodInt;
                edit_entrada_form.elements['factN'].value = data.entradadata.Fact;
                edit_entrada_form.elements['fornecedor'].value = data.entradadata.Fornecedor;
                edit_entrada_form.elements['Qnt'].value = data.entradadata.Qnt_Ent;
                edit_entrada_form.elements['entrada_id'].value = data.entradadata.id;

            }

            xhr.send('get_entrada=' + id);
        }

        edit_entrada_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_entradas();
        })

        function submit_edit_entradas() {
            let data = new FormData();
            data.append('edit_entrada', '');
            data.append('codint', edit_entrada_form.elements['codint'].value);
            data.append('factN', edit_entrada_form.elements['factN'].value);
            data.append('fornecedor', edit_entrada_form.elements['fornecedor'].value);
            data.append('Qnt_Ent', edit_entrada_form.elements['Qnt'].value);
            data.append('entrada_id', edit_entrada_form.elements['entrada_id'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/entradas.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('edit-entrada');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert('success', 'Entrada editada com sucesso!');
                    edit_entrada_form.reset();
                    get_all_entradas();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }

            xhr.send(data);
        }

        window.onload = function() {
            get_all_entradas();
        }
    </script>
</body>

</html>