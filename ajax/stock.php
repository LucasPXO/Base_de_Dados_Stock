<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['add_item'])) {
        
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `itens`(`CodInt`, `Nome`, `TipoUN`) VALUES (?,?,?)";
        $values = [$frm_data['codint'], $frm_data['nome'], $frm_data['un']];

        if(insert($q1, $values, 'iss')){
            $flag = 1;
        }

    }

    if(isset($_POST['get_all_items']))
    {
        $res = selectAll('itens');
        $i=1;

        $data = "";

        while($row = mysqli_fetch_assoc($res))
        {
            $resstock1 = select("SELECT SUM(`Qnt_Ent`) as Qnt_Ent FROM `entradas` WHERE `CodInt` = ?",[$row['CodInt']], 'i');
            $rowent = mysqli_fetch_assoc($resstock1);

            if(!isset($rowent['Qnt_Ent'])){
                $rowent['Qnt_Ent'] = 0;
            }

            $resstock2 = select("SELECT SUM(`Qnt_Sai`) as Qnt_Sai FROM `saidas` WHERE `CodInt` = ?",[$row['CodInt']], 'i');
            $rowsai = mysqli_fetch_assoc($resstock2);

            if(!isset($rowsai['Qnt_Sai'])){
                $rowsai['Qnt_Sai'] = 0;
            }

            $stock = $rowent['Qnt_Ent'] - $rowsai['Qnt_Sai'];

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[CodInt]</td>
                    <td>$row[Nome]</td>
                    <td>$rowent[Qnt_Ent]</td>
                    <td>$rowsai[Qnt_Sai]</td>
                    <td>$stock</td>
                    <td>$row[TipoUN]</td>
                    <td>
                        <button type='button' onclick='edit_item($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-item'>
                            <i class='bi bi-pencil-square'></i> 
                        </button>
                        <button type='button' onclick='rem_item($row[id])' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_item']))
    {
        $frm_data = filteration($_POST);
        
        $res1 = select("SELECT * FROM `itens` WHERE `id`=?",[$frm_data['get_item']], 'i');
        
        $itemdata = mysqli_fetch_assoc($res1);
        
        $data = ["itemdata" => $itemdata];
        
        $data = json_encode($data);
        
        echo $data;
        
    }
    
    if(isset($_POST['edit_item']))
    {
        $frm_data = filteration($_POST);
        $flag = 0;
        
        $q1="UPDATE `itens` SET `CodInt`=? ,`Nome`=?,`TipoUN`=? WHERE `id`=?";
        $values = [$frm_data['codint'], $frm_data['nome'], $frm_data['un'], $frm_data['item_id']];
        
        if(update($q1,$values,'issi')){
            $flag = 1;
        }
        
        if ($flag) {
            echo 1;
        }else{
            echo 0;
        }
        
    }
    
    if(isset($_POST['rem_item']))
    {
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_item']];

        $check_q = select('SELECT * FROM `itens` WHERE `id`=?', [$frm_data['rem_item']], 'i');

        if(mysqli_num_rows($check_q)==1){
            $q = "DELETE FROM `itens` WHERE `id`=?";
            $res = delete($q, $values, 'i');
            echo $res;
        }
        else{
            echo 'error';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_item'])) {

    $searchTerm = "%" . $_POST['search_item'] . "%";

    $query = "
        SELECT 
            i.id, 
            i.CodInt, 
            i.Nome, 
            i.TipoUN,
            COALESCE(SUM(e.Qnt_Ent), 0) AS TotalEntradas,
            COALESCE(SUM(s.Qnt_Sai), 0) AS TotalSaidas
        FROM 
            `itens` i
        LEFT JOIN 
            `entradas` e ON i.CodInt = e.CodInt
        LEFT JOIN 
            `saidas` s ON i.CodInt = s.CodInt
        WHERE 
            i.Nome LIKE ?
        GROUP BY 
            i.id, i.CodInt, i.Nome, i.TipoUN
        ORDER BY
            i.Nome ASC
    ";
    
    $res = select($query, [$searchTerm], 's');
    
    $i = 1;
    $data = ""; 

    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            
            $stock = $row['TotalEntradas'] - $row['TotalSaidas'];


            $data .= "
                <tr class='align-middle'>
                    <td>{$i}</td>
                    <td>" . htmlspecialchars($row['CodInt']) . "</td>
                    <td>" . htmlspecialchars($row['Nome']) . "</td>
                    <td>" . htmlspecialchars($row['TotalEntradas']) . "</td>
                    <td>" . htmlspecialchars($row['TotalSaidas']) . "</td>
                    <td>" . htmlspecialchars($stock) . "</td>
                    <td>" . htmlspecialchars($row['TipoUN']) . "</td>
                    <td>
                        <button type='button' onclick='edit_item(" . intval($row['id']) . ")' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-item'>
                            <i class='bi bi-pencil-square'></i> 
                        </button>
                        <button type='button' onclick='rem_item(" . intval($row['id']) . ")' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }
    } else {
        $data = "<tr><td colspan='8' class='text-center'>Nenhum item encontrado para a sua pesquisa.</td></tr>";
    }

    echo $data;
} else {
    // Resposta caso o ficheiro seja acedido de forma indevida
}

?>