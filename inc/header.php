<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
    <a href="dashboard.php" class="text-decoration-none text-white"><h3 class="mb-0 h-font">STOCK ARMAZÉM</h3></a>
    <a href="logout.php" class="btn btn-dark btn-sm">LOG OUT</a>
</div>


<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light">BASE DE DADOS</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2 " id="adminDropdown">
                <ul id="view" class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Página Inicial</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="nada.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bases de Dados</a>
                        <ul class="dropdown-menu dropdown-menu-dark w-100" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="bd_stock.php">Stock</a></li>
                            <li><a class="dropdown-item" href="bd_entradas.php">Entradas</a></li>
                            <li><a class="dropdown-item" href="bd_saidas.php">Saídas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>  
    </nav>
</div>



