<?php
session_start();

include ("connection.php");

//$_SESSION['course'] = "GWDA123";

$category = [1=>"Unacceptable",2=>"Developing",3=>"Proficient",4=>"Accomplished",5=>"Exemplary"];

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
$queryAssessment = "SELECT * FROM `course_new` WHERE `c_id` = '{$_SESSION['course']}'";

//$queryCate = mysql_fetch_array($queryCate);
$result = $mysqli->query($queryAssessment);
$allPoints = null;

while($assessment = $result->fetch_assoc()):
	//if($category['ID'] != 2 && $category['ID'] != 6  ){
	?>

		<div class="main small-11 small-centered columns">
			<h3><?php echo $assessment['c_id'] ?> -  <?php echo $assessment['title']?></h3>

				<?php $points = explode(";", $assessment['points']); 
				
				?>

				<?php foreach($points as $point): ?>
					<div class="row topic small-collapse">
					<?php
						$getRubric = "SELECT * FROM `main_new` as `m` WHERE m.`m_id` = {$point}";
						$resultRubric = $mysqli->query($getRubric);
						while($rubric = $resultRubric->fetch_assoc()):
						?>

							<h2><?php echo $rubric['m_topic']?></h2>
							<p><?php echo $rubric['description']?></p>
							<?php
							$subRubric = "SELECT * FROM `points_new` as `p` WHERE p.`m_id` = {$point}";
							$subResultRubric = $mysqli->query($subRubric);
							$allPoints += $subResultRubric->num_rows;

							while($subRubric = $subResultRubric->fetch_assoc()):

								$topic = ($subRubric['topic'] != 'null')? $subRubric['topic'] : false;
								$subDataCount = 1;
								$subDataPoints = 5;

								?>
								<div class="small-11 small-centered columns sub-topic">
									<?php if($topic): ?>
										<h3><?php echo $topic; ?></h3>
									<?php endif; ?>

									<ul class="row rubric">
									<?php
									while($subDataCount <= $subDataPoints):

									?>
										<?php /* ?><li><?php echo $subRubric['r'.$subDataCount++]; ?></li><?php */ ?>
										<li class="columns small-2" data-topic="<?php echo $subRubric['m_id'] ?>" data-subtopic="<?php echo $subRubric['p_id'] ?>" data-point="<?php echo $subDataCount ?>"><span><?php echo $subDataCount ?></span><span><?php echo $category[$subDataCount]; ?></span></li>
										<?php $subDataCount++?>
									<?php
									endwhile;
									?>
									<li class="comment columns small-2 disable end" data-topic="<?php echo $subRubric['m_id'] ?>" data-subtopic="<?php echo $subRubric['p_id'] ?>"><span class="v-c">comment</span></li>
									</ul>


								</div>

							<?php
							endwhile;
							?>


						<?php
						endwhile;
					?>



					</div>
				<?php endforeach; ?>

					<div class="small-2 small-centered columns">
						<!--<button class="button secondary small-6 columns">Reset</button>-->
						<button id="sendIt" class="button success" data-sid="<?php echo $_GET['s_id'];?>">Submit</button>
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
      $(document).foundation();

      $checkPoints = <?php echo $allPoints ?>;


      $("#sendIt").click(function(){

      		$collectData = $('.report').find('.selected');
      		$collection = [];
      		$details = {
      				 sid:$(this).data('sid'),
      				 cid:'<?php echo $_SESSION['course']?>',
					 qtr:'<?php echo  $_SESSION['qtr']?>'
      				}
      		//console.log($collectData);
      		$collectData.each(function(){
      			$collection.push($(this).data());

      		});
      		
      		if($('.asssessed').length != $checkPoints){
      			$('.rubric').each(function(){
      				//console.log($(this).parent().hasClass('assessed'));
      				if(!$(this).parent().hasClass('assessed')){
      					$(this).parent().addClass('errorBox');
      				}		
      			});
      		} 

      		if($('.errorBox').length > 0){
      				$top = $('.errorBox').eq(0).offset().top;

      				$(document).scrollTop( $top );

      		}

      		if($('.errorBox').length == 0) {
      			console.log('Good');
      			$(this).hide();
      		

      		$.ajax({
			  method: "POST",
			  url: "recordData.php",
			  data: {details:$details,json:$collection},
			})
			  .done(function( msg ) {
			  	//console.log(msg);
			    if(msg){
			    	window.location.href="<?php echo $_SESSION['studentGroup'];?>";
			    }
			  });

			}
      });

      $('.rubric').find("li:not(.comment)").click(function(){

      		if($(this).hasClass('selected')){
      			$(this).parent().parent().removeClass('assessed');
      			$(this).parent().find('.selected').removeClass('selected');
      			$(this).parent().find('.unselected').removeClass('unselected');
      		} else {
      			if($(this).parent().parent().hasClass('errorBox')){
      				$(this).parent().parent().removeClass('errorBox');
      			}
      			$(this).parent().parent().addClass('assessed');
      			$(this).parent().find('.selected').removeClass('selected');
      			$(this).parent().find('.unselected').removeClass('unselected');
      			$(this).addClass('selected');
      			$(this).parent().find("li:not(.selected, .comment)").addClass('unselected');
      		}
      });

    </script>

	</body>
</html>