<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-9">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">

<title>GeoTweets</title>
<link rel="stylesheet" href="bootstrap/css/tree.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-1.11.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>
var tweets = function(){
	
	$.ajax({
		  url: 'getTweets.php',
		  type:'POST',
		  data: {},
		  dataType: 'html',
		  success: function( resp ) {
			if(resp != "")
				$('#table').html(resp)
						
		  },
		  error: function( req, status, err ) {
			console.log( '', status, err );
		  }
		});
}
tweets();
$(document).ready(function(){
	
	setInterval(tweets, 1000);//milisaniye ile çalışırı 1000 = 1 second
	
});	

</script>
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">HGK Tweets</h3>
		</div>
		<div class="panel-body">
			<table class="table table-stripped" id="table">
				
			</table>
		</div>		
	</div>	
</body>
</html>