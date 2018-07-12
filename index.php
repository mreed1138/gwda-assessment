<?php
session_start();

// Unset all of the session variables.
$_SESSION = array();

// destroy the session, and delete the session cookie + data.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
include ("connection.php");

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset='utf-8'>
		<title>GWDA - Assessment</title>
		<link rel="stylesheet" href="css/foundation.css" />
    	<script src="js/vendor/modernizr.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>

<div class="report row">
<form method="POST" action="selectCourse.php">
  <label for="initals" class="hiddenLabel">Enter initials</label>
  <input type="text" id="initials" name="initials" class="centerIt" placeholder="example: jfk">
  <input type="submit" class="button centerIt" id="initals" name="submit" value="continue">
</form>
</div>

<script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();

      $("#sendIt").click(function(){
      		$collectData = $('.report').find('.selected');
      		$collection = [];
      		$collectData.each(function(){
      			$collection.push($(this).data());
      		});
      		$.ajax({
			  method: "POST",
			  url: "recordData.php",
			  data: {json:$collection},
			})
			  .done(function( msg ) {
			    console.log( "Data Saved: " + msg );
			  });
      });

      $('.rubric').find("li:not(.comment)").click(function(){

      		if($(this).hasClass('selected')){
      			$(this).parent().find('.selected').removeClass('selected');
      			$(this).parent().find('.unselected').removeClass('unselected');
      		} else {
      			$(this).parent().find('.selected').removeClass('selected');
      			$(this).parent().find('.unselected').removeClass('unselected');
      			$(this).addClass('selected');
      			$(this).parent().find("li:not(.selected, .comment)").addClass('unselected');
      		}
      });

    </script>

	</body>
</html>