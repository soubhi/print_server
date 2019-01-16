<script src="../jquery.min.js"></script>
<script>
var request;
function printJob(v,pageRange)
{
	//var v = "filePath";
	var url = "../user/printJob.php?filePath="+v+"&pageRange="+pageRange;
	if(window.XMLHttpRequest) {
		request=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		request=new ActiveXObject("Microsoft.XMLHTTP");
	}

	try {
		request.onreadystatechange = printJobResult;
		request.open("GET", url, true);
		request.send();
	}
	catch(e) {
		alert("Unable to connect to server");
	}
}

function printJobResult() {
	if (request.readyState == 4) {
		var val = request.responseText;
		document.getElementById('demo').innerHTML=val;
	}
}
</script>
<div id="demo"> DEMO </div>
<?php $filePath = "filePathhh";
$pageRange = "pageRange"; ?>
<script> printJob(<?php echo "\"$filePath\",\"$pageRange\""; ?>); 

confirm("<?php echo "Hello $filePath"; ?>");</script>
