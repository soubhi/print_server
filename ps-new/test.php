<!DOCTYPE HTML>
<html>

<?php
/*session_start();
include ("config.php");
$username = $_SESSION["username"];
echo $username;
/*$result_stream = mysqli_query($conn,"SELECT stream_quota FROM quota WHERE stream_code = CONCAT(SUBSTRING('$username', 1, 2), SUBSTRING('$username', 5, 2))");
$row_stream = mysqli_fetch_row($result_stream);
//$quota = $row_stream['stream_quota'];
$quota = $result_stream['stream_quota'];
echo "dfds$quota ggf<br>";
echo "kehfkelwiew";

$filename = "103-command_helper.txt";
echo "$filename"."<br>";
$file_path = "/home/printmaster/uploads/$filename";
echo "$file_path"."<br>";
echo exec("loffice --convert-to pdf --outdir /home/printmaster/uploads/ /home/printmaster/uploads/$filename");
//echo "$file_ps"."<br>";
echo "yoortlyl"
*/
$ip = exec("ifconfig wlp6s0 | grep \"inet \" | awk -F'[: ]+' '{ print $4 }'");
echo $ip;
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["userfile"])) {
    // move_uploaded_file()
}
?>

<head>
<style>

#bar_blank {
  border: solid 1px #000;
  height: 20px;
  width: 300px;
}

#bar_color {
  background-color: #006666;
  height: 20px;
  width: 0px;
}

#bar_blank, #hidden_iframe {
  display: none;
}

</style>
</head>

<body>
  <div id="bar_blank">
   <div id="bar_color"></div>
  </div>
  <div id="status"></div>
  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" 
   id="myForm" enctype="multipart/form-data" target="hidden_iframe">
   <input type="hidden" value="myForm"
    name="<?php echo ini_get("session.upload_progress.name"); ?>">
   <input type="file" name="userfile"><br>
   <input type="submit" value="Start Upload">
  </form>
  <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
  <script>
	function toggleBarVisibility() {
    var e = document.getElementById("bar_blank");
    e.style.display = (e.style.display == "block") ? "none" : "block";
}

function createRequestObject() {
    var http;
    if (navigator.appName == "Microsoft Internet Explorer") {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        http = new XMLHttpRequest();
    }
    return http;
}

function sendRequest() {
    var http = createRequestObject();
    http.open("GET", "progress.php");
    http.onreadystatechange = function () { handleResponse(http); };
    http.send(null);
}

function handleResponse(http) {
    var response;
    if (http.readyState == 4) {
        response = http.responseText;
        document.getElementById("bar_color").style.width = response + "%";
        document.getElementById("status").innerHTML = response + "%";

        if (response < 100) {
            setTimeout("sendRequest()", 1000);
        }
        else {
            toggleBarVisibility();
            document.getElementById("status").innerHTML = "Done.";
        }
    }
}

function startUpload() {
    toggleBarVisibility();
    setTimeout("sendRequest()", 1000);
}

(function () {
    document.getElementById("myForm").onsubmit = startUpload;
})();

  </script>
 </body>

<?php
session_start();

$key = ini_get("session.upload_progress.prefix") . "myForm";
if (!empty($_SESSION[$key])) {
    $current = $_SESSION[$key]["bytes_processed"];
    $total = $_SESSION[$key]["content_length"];
    echo $current < $total ? ceil($current / $total * 100) : 100;
}
else {
    echo 100;
}
?>
</html>
