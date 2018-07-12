<?php
session_start();

include ("connection.php");

if(!isset($_SESSION['course']) && $_GET['c_id'] && $_GET['qtr']):
		$_SESSION['course'] = $_GET['c_id'];
		$_SESSION['qtr'] = $_GET['qtr'];
	else:
		$_SESSION['course'] = $_GET['c_id'];
	$_SESSION['qtr'] = $_GET['qtr'];
	endif;

$c_id = $_SESSION['course'];
$qtr = $_SESSION['qtr'];

$_SESSION['studentGroup'] = basename($_SERVER['PHP_SELF'])."?c_id={$c_id}&qtr={$qtr}";


$category = [1=>"Unacceptable",2=>"Developing",3=>"Proficient",4=>"Accomplished",5=>"Exemplary"];


function getQuery($q){
	global $mysqli;
	//echo $q;
	return $mysqli->query($q);
}

$studentlist = getQuery("SELECT * FROM `studentlist_new` WHERE `qtr` = '{$qtr}' AND `c_id` = '{$c_id}'");
$reviewCount = getQuery("SELECT `reviewer` FROM `student_new` WHERE `qtr` = '{$qtr}' AND `reviewer` = '{$_SESSION['initials']}' AND `c_id` = '{$c_id}' ");
if($studentlist->num_rows == $reviewCount->num_rows):
	header('Location:index.php');
endif;


?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset='utf-8'>
		<title>Display Rubric</title>
		<link rel="stylesheet" href="css/foundation.css" />
    	<script src="js/vendor/modernizr.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
	<span>reviewer: <?php echo $_SESSION['initials'];?></span>


<div class="report row">
<?php

while($assessment = $studentlist->fetch_assoc()):

	$alreadyQuery = "SELECT `reviewer` FROM `student_new` WHERE `reviewer` = '{$_SESSION['initials']}' AND `s_id` = {$assessment['s_id']} ";
	$already = $mysqli->query($alreadyQuery);
	$enable = (!$already->num_rows)? "enable" : "disable";
	//if($category['ID'] != 2 && $category['ID'] != 6  ){
	?>

		<div class="main panel small-11 small-centered columns <?php echo $enable; ?>">
			<h5><a href="rubric.php?s_id=<?php echo $assessment['s_id']?>"><?php echo $assessment['name']?></a></h5>
		</div>

	<?php
	//}
endwhile;
?>
</div>




		</div>

<script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>

    $('.disable a').click(function(e){
    	e.preventDefault();
    })


      $(document).foundation();

      $("#sendIt").click(function(){
      		$collectData = $('.report').find('.selected');
      		$collection = [];
      		//console.log($collectData);
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