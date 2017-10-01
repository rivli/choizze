<?php
  $title = "Оповещения";
  include 'blocks/header.php';
  include 'blocks/menu.php';
  include 'blocks/alerts.php';
  ?>

  <div class="content">
    <?php

function alertInfo($id)
{
  $USERSDB = mysqli_connect(HOST, "zakilven_choiceu", PASS, "zakilven_choiceu") or die("Ошибка MySQL: ".mysql_error());
  //Подключение к базе данных пользователей
  $ALERTSSBD = mysqli_connect(HOST, "zakilven_choicea", PASS, "zakilven_choicea") or die("Ошибка MySQL: ".mysql_error());
  //Подключение к базе данных оповещений

  $alert = mysqli_fetch_array(mysqli_query($USERSDB , "SELECT * FROM `".$_SESSION['id']."-Alerts` WHERE `id` = '".$id."'"));
  return $alert;
}

   $alertsNumber = mysqli_fetch_array(mysqli_query($USERSDB , "SELECT COUNT(*) FROM `".$_SESSION['id']."-Alerts`"));

   $i = $alertsNumber[0];
   while ($i >= 1) {
     $alert = alertInfo($i);
    $postData = explode("-",$alert['tableName']);
     if ($postData[1] == "Quiz") {
       $post = QuizInfo($postData[0]);
       $author = UserInfo($post['author']);
       if ($post['poster'] == "img") {
         $post['poster'] = 'http://www.safexone.com/images/old/default.gif';
       }
     } else {
       $post = UserInfo($postData[0]);
       $author = $post;
     }

     $mainMessage = mysqli_fetch_array(mysqli_query($ALERTSBD , "SELECT * FROM `".$alert['tableName']."` WHERE `user` = '".$alert['sender']."' and `mainid` = 0")) or die('asdas');


     $messNum = mysqli_fetch_array(mysqli_query($ALERTSBD , "SELECT COUNT(*) FROM `".$alert['tableName']."` WHERE `mainid` = ".$mainMessage['id'].""));

     if ($messNum[0] != 0) {
         $lastCommentQuery = mysqli_query($ALERTSBD, "SELECT * FROM `".$alert['tableName']."` WHERE `mainid` = '".$mainMessage['id']."' ORDER BY id DESC, date DESC LIMIT 1") or die("sadas21312");
	   $lastMessage = mysqli_fetch_array($lastCommentQuery);
     } else {
       $lastMessage = $mainMessage;
     }

    $alertsArray[$i]['alert'] = $alert;
    $alertsArray[$i]['post'] = $post;
    $alertsArray[$i]['author'] = $author;
    $alertsArray[$i]['lastMessage'] = $lastMessage;



   $i--;
   };


   function sorta($a, $b) {
           if ($a['lastMessage']['date'].' '.$a['lastMessage']['time'] < $b['lastMessage']['date'].' '.$b['lastMessage']['time'])
               return 1;
       }
       
       

        usort($alertsArray, 'sorta');
      //showArray($alertsArray);
       $j = $alertsNumber[0] - 1;
       $i = 0;
       while ($i <= $j) {
           /* if ($alertsArray[$i]['alert']['status'] == "unread") {
             $bgColor = '#c6c6c6';
         } elseif ($alertsArray[$i]['alert']['status'] == "admin") {
             $bgColor = 'red';
         } else {
             $bgColor = 'inherit';
         }*/
         $bgColor = 'white';
         
         echo '
        
         <div class="authorBlock" style="cursor:pointer;background:'.$bgColor.'" onclick="showAlert(\''.$alertsArray[$i]['alert']['tableName'].'\','.$alertsArray[$i]['alert']['mainid'].','.$alertsArray[$i]['alert']['sender'].')">
                       <table>
                         <tbody><tr>
                           <td class="authorBlockLeft" style="text-align: left;">
                             <div class="authorName"><img src="'.$alertsArray[$i]['post']['poster'].'" class="authorAva" style="width: 100%;border-radius:0;"></div>
                           </td>
                           <td class="authorBlockRight">
                             <div class="authorName">'.$alertsArray[$i]['post']['name'].'</div>
                             <span class="authorQuote">'.$alertsArray[$i]['author']['name'].' '.$alertsArray[$i]['author']['lastname'].'</span>

                             <span class="authorQuote">'.$alertsArray[$i]['lastMessage']['text'].'</span><br>
                             
                           </td>
                         </tr>
                       </tbody></table>
                     </div>
         ';
         $i++;
       }

   ?>
  </div>


<?php include 'blocks/footer.php'; ?>
