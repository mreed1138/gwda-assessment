<?php
include("connection.php");
session_start();

//session_unset();

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
            # code...
            break;
    }

    return $quarter;

}

//$month = date("M");
$month = getQuarter(date("n"));
$year = date("y");
$current = ($month).''.($year);

$quarters = array("WI","SP","SU","FA");
$build = $year - 1;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Fundamentals Assessment</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>



<div id="viewAssessment">

<form action="selectCourseReport.php" method="post" name="viewReport">
<h2>View Assessment Report:</h2>
    <h3>Select Course:</h3>
    <?php
        $getCourses = "SELECT * FROM `course_new` ORDER BY `c_id` ASC";
        $found = $mysqli->query($getCourses);

        while($course = $found->fetch_assoc()):
                ?>
            <p><input type="radio" name="course" required value="<?php echo $course['c_id']?>" /><?php echo $course['c_id'] .' - '. $course['title'];?></p>
        <?php
            endwhile;
    ?>

    <h3><label for="qtr">Select Quarter</label></h3>
    <p>
<?php
                $build = $year - 3;
                while($build <= $year):
                    foreach($quarters as $quarter):
                        $name = $quarter.''.$build;
            ?>
                <input type="radio" name="qtr" required value="<?php echo $name ?>"><?php echo $name ."\n" ?>
            <?php
                    endforeach;
                    ?>
                        <br><br>
                    <?php
                    $build++;
                endwhile
            ?>
            </p>
<input type="submit" name="report" value="View Assessment Report"/>
</form>
</div>


 </body></html>

