<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="./css/normalize.css"> 
    <link rel="stylesheet" type="text/css" media="all" href="./css/style.css">

    <title>Document</title>
</head>
<body>   
<?php
error_reporting(0);



// -------------------------------------------------path & files ------------------------------------------------------------

$path = './' . $_GET['path'];
echo $path;
// getting path without . & .. ;
$files = array_diff(scandir($path), array('..', '.'));
echo'<h2>Directory contents: '. $path .'</h2>';


// -------------------------------------------------deleting file-----------------------------------------------------------

if (isset($_POST['del'])) {
    $fileDel = './' . $_GET['path'] . $_POST['del']; 
    unlink($fileDel);
}

// -------------------------------------------------downloading file-----------------------------------------------------------

// if (isset($_POST['down'])) {
//     $fileDown = './' . $_GET['path'] . $_POST['down']; 
    
// }


// ----------------------------------------------create new directory----------------------------------------------------

if (isset($_POST['create'])) {
    $newDir = './' . $_GET['path'] . $_POST['create'];
    //if input value is not empty, 
    if ($_POST['create'] != "") { 
        //if dir with this name doesn't exists, create new directory.
        if (!is_dir($newDir)) {
            mkdir($newDir, 0777, true);
            //if dir with that name exists - alert.  
        };
    //if name is empty - alert.
    } 
}


//--------------------------------------------------- table ----------------------------------------------------------------
//spausdinu lentele:
echo '<table><thead><tr><th>Type</th><th>Name</th><th>Action</th></tr></thead>';
echo '<tbody>';
//gaunu files masyvo reiksmes
foreach ($files as $val) {
    echo '<tr>';
    // jei $path.$val yra direktorija - print Directory. Jei $path.$val yra failas - print File;
    if (is_dir($path . $val)) {
        echo '<td>' . 'Directory' . '</td>';
    } else echo '<td>' . 'File' . '</td>';
    echo '<td>';

    // jei $path.$val yra direktorija - printina linka;
    if (is_dir($path . $val)) {
        echo '<a href="';
        //jei path pasettintas, salygoje nerasyti "?path=" ir atvirksciai.
        if (isset($_GET['path'])) {
            echo $_SERVER['REQUEST_URI'] . $val . '/';
        } else {
            echo $_SERVER['REQUEST_URI'] . '?path=' . $val . '/';  
        } 
        echo '">' . $val . '</a>';
    // jei $path.$val yra ne direktorija - printina tiesiog $val.
    } else echo $val;

    // --------------------------------------download & delete buttons--------------------------------------
    echo '<td class="buttons">';
    // jei $path.$val yra direktorija - nieko nespausdinti. Jei failas, spausdinti mygtukus.
    if (is_dir($path . $val)) {
        echo '';
    } else {
        echo '<form action="" method="post" class="buttonsform">
        <input class="hidinput" name="down" value='.$val.'>
        <button type="submit" class="myButton" id="down">Download</button>
        </form>
        <form action="" method="post" class="buttonsform">
        <input class="hidinput" name="del" value='.$val.'>
        <button type="submit" class="myButton" id="del">Delete</button></td>
        </form>';
    } echo '</tr>';
} print "</tbody></table>";



?>
    <form action="" method="POST" class="dirform">
        <input type="text" class="createinput" name="create" placeholder="Create new directory">
        <input type="submit" value="Create" class="createbtn">
    </form>

</body>
</html>