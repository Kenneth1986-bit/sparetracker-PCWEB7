<?php

require_once ("db.php");
require_once ("component.php");

$con = Createdb();

// create button click
if(isset($_POST['create'])){
    createData();
}

if(isset($_POST['update'])){
    UpdateData();
}

if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();

}

function createData(){
    $sparename = textboxValue("spare_name");
    $mfgname = textboxValue("manufacturer_name");
    $unitprice = textboxValue("unit_price");

    if($sparename && $mfgname && $unitprice){

        $sql = "INSERT INTO spare (spare_name, manufacturer_name, unit_price) 
                        VALUES ('$sparename','$mfgname','$unitprice')";

        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Record Successfully Inserted!");
        }else{
            echo "Error";
        }

    }else{
            TextNode("error", "Provide Data in the Textbox");
    }
}

function textboxValue($value){
    $textbox = mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
}


// messages
function TextNode($classname, $msg){
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


// get data from mysql database
function getData(){
    $sql = "SELECT * FROM spare";

    $result = mysqli_query($GLOBALS['con'], $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}

// update dat
function UpdateData(){
    $spareid = textboxValue("spare_id");
    $sparename = textboxValue("spare_name");
    $mfgname = textboxValue("manufacturer_name");
    $unitprice = textboxValue("unit_price");

    if($sparename && $mfgname && $unitprice){
        $sql = "
                    UPDATE spare SET spare_name='$sparename', manufacturer_name = '$mfgname', unit_price = '$unitprice' WHERE id='$spareid';                    
        ";

        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Data Successfully Updated");
        }else{
            TextNode("error", "Enable to Update Data");
        }

    }else{
        TextNode("error", "Select Data Using Edit Icon");
    }


}


function deleteRecord(){
    $spareid = (int)textboxValue("spare_id");

    $sql = "DELETE FROM spare WHERE id=$spareid";

    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","Record Deleted Successfully!");
    }else{
        TextNode("error","Unable to Delete Record!");
    }

}


function deleteBtn(){
    $result = getData();
    $i = 0;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $i++;
            if($i > 3){
                buttonElement("btn-deleteall", "btn btn-danger" ,"<i class='fas fa-trash'></i> Delete All", "deleteall", "");
                return;
            }
        }
    }
}


function deleteAll(){
    $sql = "DROP TABLE spare";

    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","All Record deleted Successfully!");
        Createdb();
    }else{
        TextNode("error","Something Went Wrong Record cannot deleted!");
    }
}


// set id to textbox
function setID(){
    $getid = getData();
    $id = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $id = $row['id'];
        }
    }
    return ($id + 1);
}








