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
    <title>Stock Armazém - Saídas</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SAÍDAS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-saida">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Nº REQ</th>
                                        <th scope="col">Requisitante</th>
                                        <th scope="col">Cod Interno</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data Sai.</th>
                                        <th scope="col">Tipo UN</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="saida-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Entradas modal -->

    <div class="modal fade" id="add-saida" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_saida_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Saída</h5>
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
                                <label class="form-label fw-bold">Nº REQ</label>
                                <input type="text" name="reqN" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Requisitante</label>
                                <input type="text" min="1" name="requisitante" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Quantidade Saída</label>
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

    <div class="modal fade" id="edit-saida" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_saida_form" autocomplete="off">
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
                                <label class="form-label fw-bold">Nº REQ</label>
                                <input type="text" name="reqN" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Requisitante</label>
                                <input type="text" min="1" name="requisitante" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Quantidade Saída</label>
                                <input type="text" min="1" name="Qnt" class="form-control shadow-none" required>
                            </div>
                            <input type="hidden" name="saida_id">
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
        let add_saida_form = document.getElementById('add_saida_form');

        add_saida_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_saida();
        })

        function add_saida() {
            let data = new FormData();
            data.append('add_saida', '');
            data.append('codint', add_saida_form.elements['codint'].value);
            data.append('reqN', add_saida_form.elements['reqN'].value);
            data.append('requisitante', add_saida_form.elements['requisitante'].value);
            data.append('Qnt', add_saida_form.elements['Qnt'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/saidas.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('add-saida');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 0) {
                    alert('success', 'Novo Saída Adicionada com Sucesso!');
                    add_saida_form.reset();
                    get_all_saidas();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }
            
            xhr.send(data);
        }

        function get_all_saidas() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/saidas.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


            xhr.onload = function() {
                document.getElementById('saida-data').innerHTML = this.responseText;
            }

            xhr.send('get_all_saidas');
        }

        function rem_saida(val) {
            if(confirm("Queres mesmo apagar esta saída?")){

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/saidas.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function() {
                    if (this.responseText == 1) {
                        alert('success', 'Saída Removida com Sucesso!');
                        get_all_saidas();
                    } else {
                        alert('error', 'Erro do Servidor!');
                    }
                }
                
                xhr.send('rem_saida=' + val);
            }
        }

       let edit_saida_form = document.getElementById('edit_saida_form');

        function edit_saida(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/saidas.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                let data = JSON.parse(this.responseText);

                edit_saida_form.elements['codint'].value = data.saidadata.CodInt;
                edit_saida_form.elements['reqN'].value = data.saidadata.nREQ;
                edit_saida_form.elements['requisitante'].value = data.saidadata.Requisitante;
                edit_saida_form.elements['Qnt'].value = data.saidadata.Qnt_Sai;
                edit_saida_form.elements['saida_id'].value = data.saidadata.id;

            }

            xhr.send('get_saida=' + id);
        }

        edit_saida_form.addEventListener('submit', function(e) {
            e.preventDefault();
            submit_edit_entradas();
        })

        function submit_edit_entradas() {
            let data = new FormData();
            data.append('edit_saida', '');
            data.append('codint', edit_saida_form.elements['codint'].value);
            data.append('reqN', edit_saida_form.elements['reqN'].value);
            data.append('requisitante', edit_saida_form.elements['requisitante'].value);
            data.append('Qnt_Sai', edit_saida_form.elements['Qnt'].value);
            data.append('saida_id', edit_saida_form.elements['saida_id'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/saidas.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('edit-saida');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert('success', 'Saída editada com sucesso!');
                    edit_saida_form.reset();
                    get_all_saidas();
                } else {
                    alert('error', 'Erro do Servidor!');
                }
            }

            xhr.send(data);
        }

        window.onload = function() {
            get_all_saidas();
        } 
    </script>
</body>

</html>