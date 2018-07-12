<?php

session_start();

include ("connection.php");

if(!isset($_SESSION['initials']) && $_POST['initials']):
  $_SESSION['initials'] = $_POST['initials'];
endif;

function getQuarter($m){

    $quarter = null;
    switch ($m) {
        case '1':
        case '2':
        case '3':
            $quarter = "WI";
            break;
        case '4':
        case '5':
        case '6':
            $quarter = "SP";
            break;
        case '7':
        case '8':
        case '9':
            $quarter = "SU";
            break;
        case '10':
        case '11':
        case '12':
            $quarter = "FA";
            break;
        default:
            break;
    }
    return $quarter;
}

$quarter = getQuarter(date("n"));
$year = date("y");
$current = $quarter.''.$year;
//echo $current;
$current = "FA17";
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
        $queryAssessment = "SELECT * FROM `course_new` WHERE `a` = 1 ORDER BY `c_id` ASC";
        $result = $mysqli->query($queryAssessment);
        while($assessment = $result->fetch_assoc()):
      ?>
        <div class="main panel small-11 small-centered columns">

      	   <h5><a href="selectStudent.php?c_id=<?php echo $assessment['c_id'] ?>&amp;qtr=<?php echo $current?>"><?php echo $assessment['c_id'] ?> -  <?php echo $assessment['title']?></a></h5>
        </div>
      <?php
        endwhile;
      ?>
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
          }).done(function( msg ) {
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