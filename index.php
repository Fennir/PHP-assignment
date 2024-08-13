<?php
    include'conn.php';

    if(isset($_POST['addBtn'])){

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $matricNumber = $_POST['matricNumber'];

            if(!empty($firstName && $lastName && $matricNumber)){
                //prepared statement
                $insert = $pdo->prepare("insert into crud_table (firstName, lastName, matricNumber) values (:firstName, :lastName, :matricNumber)");
                $insert->bindParam(':firstName',$firstName); 
                $insert->bindParam(':lastName',$lastName); 
                $insert->bindParam(':matricNumber',$matricNumber); 

                $insert->execute();

                    if($insert->rowCount()){
                        echo"insert success";
                    }else{
                        echo"insert unsuccess";
                    }//if row count

            } else {
                echo'Empty feilds';
            }//if empty           
    } //isset add Btn

    if(isset($_POST['updateBtnExecute'])){

        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $matricNumber = $_POST['matricNumber'];

            if(!empty($firstName && $lastName && $matricNumber)){
                //prepared statement
                $update = $pdo->prepare("update crud_table set firstName=:firstName, lastName=:lastName, matricNumber=:matricNumber where id=:id");
                $update->bindParam(':id',$id); 
                $update->bindParam(':firstName',$firstName); 
                $update->bindParam(':lastName',$lastName); 
                $update->bindParam(':matricNumber',$matricNumber); 

                $update->execute();

                    if($update->rowCount()){
                        echo"update success";
                    }else{
                        echo"update unsuccess";
                    }//if row count

            } else {
                echo'Empty feilds';
            }//if empty 
    }//isset update Btn execute

    if(isset($_POST['deleteBtn'])){

        $id = $_POST['deleteBtn'];
        
        $delete = $pdo->prepare('delete from crud_table where id=:id');
        $delete->bindParam(':id',$id);
        $delete->execute();

            if ($delete->rowCount()) {
                echo'you deleted id:'.$id;
            }
            else{
                echo'delete fail';
            }//if row count
    }
?>

<html>
<head>
    <title>CRUD</title>
</head>
<body>
    <h1>CRUD FORM</h1>
    <form action="" method="post">
<?php
    if(isset($_POST['updateBtn'])){
        
        $id = $_POST['updateBtn'];
        
        $select = $pdo->prepare('select * from crud_table where id = :id');   
        $select->bindParam(':id',$id);
        $select->execute();
        
            if ($select) {
                $row = $select->fetch(PDO::FETCH_OBJ);
                echo'
                    <input type="hidden" name="id" value="'.$row->id.'">
                    <label>First Name</label> 
                    <input type="text" name="firstName" value="'.$row->firstName.'">
                    <br>
                    <label>Last Name</label> 
                    <input type="text" name="lastName" value="'.$row->lastName.'">
                    <br>
                    <label>Matric Number</label> 
                    <input type="text" name="matricNumber" value="'.$row->matricNumber.'">
                    <br>
                    <input type="submit" name="updateBtnExecute" value="Update">  
                    <input type="submit" name="cancelBtn" value="Cancel"> 
                 ';
            }//pop up form with data
        
    }//isset update Btn
    else{
        echo'
            <label>First Name</label> 
            <input type="text" name="firstName" placeholder="enter">
            <br>
            <label>Last Name</label> 
            <input type="text" name="lastName" placeholder="enter">
            <br>
            <label>Matric Number</label> 
            <input type="text" name="matricNumber" placeholder="enter starts with letter">
            <br>
            <input type="submit" name="addBtn" value="Save">
        ';

    }// if not update Btn default form
?>
    <hr>

    <table cellspadding="10px" width="50%" border="1px solid black">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Matric Number</th>
            <th>Action Button</th>
        </tr>

        <?php
            $select = $pdo->prepare('select * from crud_table');
            $select->execute();

                //PDO::FETCH_BOTH (default): returns an array indexed by both column name and 0-indexed column number as returned in your result set
                //PDO::FETCH_NUM: returns an array indexed by column number as returned in your result set, starting at column 0
                //PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result 
                //PDO::FETCH_OBJ: returns an anonymous object with property names that correspond to the column names returned in your result set 

                while($row = $select->fetch(PDO::FETCH_OBJ)){ 
                    //FETCH_NUM    ->  echo $row['1']."<br>";
                    //FETCH_ASSOC  ->  echo $row['firstName']."<br>";
                    //FETCH_OBJ    ->  echo $row->firstName."<br>"
                    echo'<tr>';
                    echo '<td>'.$row->id.'</td>';
                    echo '<td>'.$row->firstName.'</td>';
                    echo '<td>'.$row->lastName.'</td>';
                    echo '<td>'.$row->matricNumber."</td>";
                    echo '<td> <button type="submit" name="updateBtn" value="'.$row->id.'">UPDATE</button> ||';
                    echo ' <button type="submit" name="deleteBtn" value="'.$row->id.'">DELETE</button></td>';
                    echo'</tr>';
                }
        ?>

    </table>

    </form>

</body>
</html>