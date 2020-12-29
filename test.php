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

echo "<a href=\"login.php\" class=\"logout\">Log Out</a>";
$path = './' . $_GET['path'];
// getting path without . & .. ;
$files = array_diff(scandir($path), array('..', '.'));
echo'<h2>Directory contents: '. $path .'</h2>';

// -------------------------------------------------deleting file-----------------------------------------------------------

if (isset($_POST['del'])) {
    $fileDel = './' . $_GET['path'] . $_POST['del']; 
    unlink($fileDel);
    header('Location:' . $_SERVER['REQUEST_URI']);
}

// -------------------------------------------------downloading file-----------------------------------------------------------

if (isset($_POST['download'])) {
    $file = './' . $_GET["path"] . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}

// ----------------------------------------------create new directory----------------------------------------------------

if (isset($_POST['create'])) {
    $newDir = './' . $_GET['path'] . $_POST['create'];
    //if input value is not empty, 
    if ($_POST['create'] != "") { 
        //if dir with this name doesn't exists, create new directory.
        if (!is_dir($newDir)) {
            mkdir($newDir, 0777, true);
            header('Location:' . $_SERVER['REQUEST_URI']); 
            //if dir with that name exists - alert.  
        } else echo '<script>alert("Directory with this name aready exists")</script>';
    //if name is empty - alert.
    } else echo '<script>alert("Directory name is empty")</script>';
}
// ----------------------------------------------uploading file-----------------------------------------------------------
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// if (isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if ($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
//   // Check if file already exists
//   if (file_exists($target_file)) {
//     echo "File already exists.";
//     $uploadOk = 0;
//   }
//   // Check file size
//   if ($_FILES["fileToUpload"]["size"] > 500000) {
//     echo "File is too large.";
//     $uploadOk = 0;
//   }
//   // Allow certain file formats
//   if (
//     $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     && $imageFileType != "gif"
//   ) {
//     echo "Only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
//   }
//   // Check if $uploadOk is set to 0 by an error
//   if ($uploadOk == 0) {
//     echo " File was not uploaded.";
//     // if everything is ok, try to upload file
//   } else {
//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//       echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
//       header('refresh: 0');
//     } else {
//       echo "There was an error uploading your file.";
//     }
//   }
// }


//---------------------------------------------------table----------------------------------------------------------------
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

// -------------------------------------------download & delete buttons--------------------------------------
    
    // jei $path.$val yra failas - spausdinti mygtukus.
    if (is_file($path . $val)) {
        echo '<td class="buttons"><form action="" method="post" class="buttonsform">
        <input class="hidinput" name="download" value='.$val.'>
        <button type="submit" class="myButton" id="download">Download</button>
        </form>
        <form action="" method="post" class="buttonsform">
        <input class="hidinput" name="del" value='.$val.'>
        <button type="submit" class="myButton" id="del">Delete</button>
        </form></td></tr>';
    } 
} print "</tbody></table>";
//--------------------------------------------new dir & upload file forms-----------------------------------
?>
    <form action="" method="POST" class="dirform">
        <input type="text" class="createinput" name="create" placeholder="Create new directory">
        <input type="submit" value="Create" class="createbtn">
    </form>
    <br>
    <form action="" method="post" enctype="multipart/form-data" class="uploadform" id="upload">
        <h3>Upload image:</h3>
        <input type="file" hidden name="fileToUpload" id="fileToUpload"/>
        <label for="fileToUpload" class="choosefile">Choose file</label>
        <input type="submit" value="Upload Image" name="submit" class="upload">
    </form>   

    <!-- <form id='upload' action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <input type="submit" value="Upload Image" name="submit">
  </form> -->
</body>
</html> 