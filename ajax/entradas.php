<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['add_entrada'])) {
        
        $frm_data = filteration($_POST);
        $flag = 0;

        $q1 = "INSERT INTO `entradas`(`CodInt`, `Fact`, `Fornecedor`, `Qnt_Ent`) VALUES (?,?,?,?)";
        $values = [$frm_data['codint'], $frm_data['factN'], $frm_data['fornecedor'], $frm_data['Qnt']];

        if(insert($q1, $values, 'issi')){
            $flag = 1;
        }

    }

    if(isset($_POST['get_all_entradas']))
    {
        $res1 = selectAll('entradas');
        
        $i=1;

        $data = "";

        while($row = mysqli_fetch_assoc($res1))
        {
            $res2 = select("SELECT * FROM `itens` WHERE `CodInt` = ?", [$row['CodInt']] , 'i');
            $rowitem = mysqli_fetch_assoc($res2);

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[Fact]</td>
                    <td>$row[Fornecedor]</td>
                    <td>$row[CodInt]</td>
                    <td>$rowitem[Nome]</td>
                    <td>$row[Data]</td>
                    <td>$rowitem[TipoUN]</td>
                    <td>$row[Qnt_Ent]</td>
                    <td>
                        <button type='button' onclick='edit_entrada($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-entrada'>
                            <i class='bi bi-pencil-square'></i> 
                        </button>
                        <button type='button' onclick='rem_entrada($row[id])' class='btn btn-danger btn-sm shadow-none'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_entrada']))
    {
        $frm_data = filteration($_POST);
        
        $res1 = select("SELECT * FROM `entradas` WHERE `id`=?",[$frm_data['get_entrada']], 'i');
        
        $entradadata = mysqli_fetch_assoc($res1);
        
        $data = ["entradadata" => $entradadata];
        
        $data = json_encode($data);
        
        echo $data;
        
    }
    
    if(isset($_POST['edit_entrada']))
    {
        $frm_data = filteration($_POST);
        $flag = 0;
        
        $q1="UPDATE `entradas` SET `CodInt`=? ,`Fact`=?,`Fornecedor`=?,`Qnt_Ent`=? WHERE `id`=?";
        $values = [$frm_data['codint'], $frm_data['factN'], $frm_data['fornecedor'], $frm_data['Qnt_Ent'], $frm_data['entrada_id']];
        
        if(update($q1,$values,'iisii')){
            $flag = 1;
        }
        
        if ($flag) {
            echo 1;
        }else{
            echo 0;
        }
        
    }
    
    if(isset($_POST['rem_entrada']))
    {
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_entrada']];

        $check_q = select('SELECT * FROM `entradas` WHERE `id`=?', [$frm_data['rem_entrada']], 'i');

        if(mysqli_num_rows($check_q)==1){
            $q = "DELETE FROM `entradas` WHERE `id`=?";
            $res = delete($q, $values, 'i');
            echo $res;
        }
        else{
            echo 'error';
        }
    } 

?>