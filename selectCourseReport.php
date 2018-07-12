<?php
include ("connection.php");
session_start();
//SELECT * FROM `studentlist` s LEFT JOIN `assessment` a ON s.`s_id` = a.`s_id` WHERE s.`qtr` = "FA13"
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fundamentals Assessment</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="main_wrap" class="full">
			<?php
			if(isset($_POST['report'])){
				$c = $_POST['course'];
				$q = $_POST['qtr'];
				echo $q;
				$cquery ="SELECT * FROM `studentlist_new` WHERE `c_id`= '".$c."' AND `qtr` = '".$q."'";
				$title ="SELECT `title` FROM `course_new` WHERE `c_id`= '{$c}'";

				$countResult = $mysqli->query($cquery);
				$getTitle = $mysqli->query($title);
				$getTitle = $getTitle->fetch_row()[0];
				$sampleCount = $countResult->num_rows;
				
				if($sampleCount):
				?>
					<h2><?php echo $c;?> - <?php echo $getTitle;?> <br> Quarter : <?php echo $q;?></h2>
					<p>Number of Students : <?php echo $sampleCount;  ?></p>
				<?php
				else:
					?>
					<h2>No assessment data found regarding <br /> Course : <?php echo $c;?> <br /> Quarter : <?php echo $q;?></h2>
					<a href="index.php">Return Home to run another report</a>
				<?php
				endif;
			function color($number){
				$choice;
				if($number > 3.45){
					$choice = "strength";
				} else {
					$choice = "weakness";
				}
				return $choice;
			}

			function cateAvg($cID,$c,$q){
				global $mysqli;//, $target;
				$queryRubric = "SELECT * FROM `points_new` WHERE `m_id` = {$cID}";
				$result = $mysqli->query($queryRubric);
				$cc = 0;
				$sectionType = 0;
				$questionCount = 0;
				$subQuestions = $result->num_rows;
				$avg = 0;
				$showCate = "SELECT ";
				while($row = $result->fetch_assoc()){
					$m=$row['m_id'];
					$t=$row['p_id'];
					$questionRating = "{$m}_{$t}";
					$mod = ($cc < $subQuestions-1)? ", ":" ";
					$showCate .= "AVG(`".$questionRating."`){$mod}";
					$cc++;
				}
				$avg = 0;
			$showCate .=  " FROM `student_new` WHERE `c_id`= '{$c}' AND `qtr` = '{$q}'";
			$getCate =  $mysqli->query($showCate);
			while ($row = $getCate->fetch_assoc()) {
				foreach ($row as $key => $value) {

					$avg += $value;
				}
			}
				$fixed = $avg/$subQuestions;
				echo '<b class="'. color(round(($fixed),2)).'">'.number_format(($fixed),2).'</b>';
			}

			function avg($cID,$c,$q){
				global $mysqli;//, $target;
				$queryRubric = "SELECT * FROM `points_new` WHERE `m_id` = {$cID}";
				$result = $mysqli->query($queryRubric);
				$topic = $result->num_rows;
				while($points = $result->fetch_assoc()):
					echo '<li>';
					$questionRating = "{$points['m_id']}_{$points['p_id']}";
					echo "{$points['topic']} ::: ";

				$cc = 1;
				$sectionType = 0;
				$questionCount = 0;
				$subQuestions = $result->num_rows;
					$avg = 0;
					
					$get_select ="SELECT AVG(".$questionRating.") FROM `student_new` s LEFT JOIN `studentlist_new` sl ON s.`s_id` = sl.`s_id` WHERE s.`c_id`= '{$c}' AND s.`qtr` = '{$q}'";
					$callback = $mysqli->query($get_select);

					while ($subrow = $callback->fetch_assoc()){
							$fixed = $subrow["AVG({$questionRating})"];

							echo '<b class="'. color(round(($fixed),2)).'">'.number_format(($fixed),2).'</b>';

					}
					echo '</li>';
				endwhile;
			}
?>

<div class="report">
	<?php
	$queryAssessment = "SELECT * FROM `course_new` WHERE `c_id` = '{$c}'";
	$result = $mysqli->query($queryAssessment);

	$main = $result->fetch_assoc();
	$main = explode(';',$main['points']);
	while(list($k,$assessment) = each($main)):
 	$queryAssessment = "SELECT * FROM `main_new` WHERE `m_id` = '{$assessment}'";

	$result = $mysqli->query($queryAssessment);
	$cc = 1;
	while($assessment = $result->fetch_assoc()):
	?>
		<div class="main">
			<h3 class="heading"><?php echo $assessment['m_topic'] ?> :: <?php echo cateAvg($assessment['m_id'],$c,$q); ?></h3>

			<ul><?php echo avg($assessment['m_id'],$c,$q); ?></ul>
		</div>
	<?php
	endwhile;
endwhile;
}
?>
		</div>
	</body>
	</html>