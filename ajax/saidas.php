<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['add_saida'])) {
        
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `saidas`(`CodInt`, `nREQ`, `Requisitante`, `Qnt_Sai`) VALUES (?,?,?,?)";
        $values = [$frm_data['codint'], $frm_data['reqN'], $frm_data['requisitante'], $frm_data['Qnt']];

        if(insert($q1, $values, 'iisi')){
            $flag = 1;
        }

    }

    if(isset($_POST['get_all_saidas']))
    {
        $res1 = selectAll('saidas');
        
        $i=1;

        $data = "";

        while($row = mysqli_fetch_assoc($res1))
        {
            $res2 = select("SELECT * FROM `itens` WHERE `CodInt` = ?", [$row['CodInt']] , 'i');
            $rowitem = mysqli_fetch_assoc($res2);

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[nREQ]</td>
                    <td>$row[Requisitante]</td>
                    <td>$row[CodInt]</td>
                    <td>$rowitem[Nome]</td>
                    <td>$row[Data]</td>
                    <td>$rowitem[TipoUN]</td>
                    <td>$row[Qnt_Sai]</td>
                    <td>
                        <button type='button' onclick='edit_saida($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-saida'>
                            <i class='bi bi-pencil-square'></i> 
                        </button>
                        <button type='button' onclick='rem_saida($row[id])' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_saida']))
    {
        $frm_data = filteration($_POST);
        
        $res1 = select("SELECT * FROM `saidas` WHERE `id`=?",[$frm_data['get_saida']], 'i');
        
        $saidadata = mysqli_fetch_assoc($res1);
        
        $data = ["saidadata" => $saidadata];
        
        $data = json_encode($data);
        
        echo $data;
        
    }
    
    if(isset($_POST['edit_saida']))
    {
        $frm_data = filteration($_POST);
        $flag = 0;
        
        $q1="UPDATE `saidas` SET `CodInt`=? ,`nREQ`=?,`Requisitante`=?,`Qnt_Sai`=? WHERE `id`=?";
        $values = [$frm_data['codint'], $frm_data['reqN'], $frm_data['requisitante'], $frm_data['Qnt_Sai'], $frm_data['saida_id']];
        
        if(update($q1,$values,'iisii')){
            $flag = 1;
        }
        
        if ($flag) {
            echo 1;
        }else{
            echo 0;
        }
        
    }
    
    if(isset($_POST['rem_saida']))
    {
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_saida']];

        $check_q = select('SELECT * FROM `saidas` WHERE `id`=?', [$frm_data['rem_saida']], 'i');

        if(mysqli_num_rows($check_q)==1){
            $q = "DELETE FROM `saidas` WHERE `id`=?";
            $res = delete($q, $values, 'i');
            echo $res;
        }
        else{
            echo 'error';
        }
    } 

?>