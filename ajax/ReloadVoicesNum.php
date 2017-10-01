<?php
$query1="SELECT * FROM `".$_POST['id']."`";
  $result1 = mysqli_query($QUIZZESBD, $query1) or die("sadasda");
  $voicesNumSum=0;
  $voicedByMe=0;
while($row = mysqli_fetch_array($result1)) {
  if ($row['voices']=='') {
    $VNumber = 0;
  } else {
  $VNumber = COUNT(TakeSQLArray($row['voices']));
  };
  $voicesNumSum += $VNumber;
}
echo $voicesNumSum;
 ?>
