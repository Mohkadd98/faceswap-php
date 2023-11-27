<?php
include 'config.php';
function faceswap($url_source,$url_target,$RapidAPIKey)
{
    $curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://deepfake-face-swap.p.rapidapi.com/swap",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'target' => $url_target,
        'source' => $url_source
    ]),
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: deepfake-face-swap.p.rapidapi.com",
        "X-RapidAPI-Key:".$RapidAPIKey,
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$json=json_decode($response);
if ($response && isset($json->result)) {
      echo '<div class="card"><div class="card-header  "><h5> Result </h5></div>
       <div class="card-body"><img height="100%" width="100%"class="img-responsive" src="data:image/jpeg;base64,' . $json->result . '" width="100" height="100"/></div></div></div>';
}else{
   echo '<div class="card"><div class="card-header  "><h5> Result </h5></div>
       <div class="card-body">Error in Rapid API Key</div></div></div>';
}
}

?>

<!DOCTYPE html>
<html dir="">
    <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Face Swap</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="img/20231120.png">

</head>
<body>
<style type="text/css">
  html,body{
        height: 100%;
        background:#EEEEEE;
      }
 
</style>

  
<div class="container">

    
  <div style="padding-top:5%;"class="row">
    <div class="col-sm-4">
  <form action="index.php" method="POST"enctype="multipart/form-data">
    <div class="card ">
    <div class="card-header  "><h5> Face Swap   </h5></div>
    <div class="card-body">
   <div class="mb-3">
    <label class="form-label"for="Source"> Source </label>
    <input name="Source"  type="file" value="" required />
    </div>

    <div class="mb-3">
    <label class="form-label"for="Target"> Target </label>
    <input name="target"  type="file" value="" required/>
    </div>
 

 
   <div class="mb-3">
  <div class="btn-list">
 <button name="submit"class="btn btn-primary w-100"> Swapping </button>

 </div> </form>
              </div>
             
    </div></div></div>
    <div class="col-sm-8">
      <?php if (isset($_POST["submit"])) {

        // Check image using getimagesize function and get size
        // if a valid number is got then uploaded file is an image
        if (isset($_FILES["target"])) {
        // directory name to store the uploaded image files
        // this should have sufficient read/write/execute permissions
        // if not already exists, please create it in the root of the
        // project folder
         $url_target=$url.$targetDir.$_FILES["target"]["name"];
        $targetFile = $targetDir . basename($_FILES["target"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["target"]["tmp_name"], $targetFile) ;
        $url_source=$url.$targetDir.$_FILES["Source"]["name"];
        $SourceFile = $targetDir . basename($_FILES["Source"]["name"]);
        $uploadOk = 1;
        $imageFileSource = strtolower(pathinfo($SourceFile, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["Source"]["tmp_name"], $SourceFile);
        }
        faceswap($url_source,$url_target,$RapidAPIKey);


           }else {?>

              <div class="empty">
              <div class="empty-img"><center><img style="width: 50%;height:300px;" src="img/9318694.png" height="100" alt=""></center>
              </div>
              <center><h4> No results found </h4></center>
              <center><h6 class="empty-subtitle text-muted">
                Add Images and Try Again
              </h6></center>
              
            </div>

       <?php }?>

           </div>
    </div></div>
    </div>
</div>
