<?php $title="Поиск - ".$url2;
$searchingWords = $url2;
include 'blocks/header.php';
include 'blocks/menu.php';
 ?>
 <div class="content">
   <div class="searchingResults">
<?php

$searchingWords = str_replace(',', ' ', $searchingWords);
$searchingWords = preg_replace("|[\s]+|i"," ",$searchingWords);

$tags = explode(" ",$searchingWords);
$tagsNum = COUNT($tags);



//------------------------Получаем данные совпадений из опросов и закдючаем все в массив SEA - SearchEngineArray
$quizzesNumber = mysqli_fetch_array(mysqli_query($MAINBD , "SELECT COUNT(*) FROM `quizzes`"));
$i = $quizzesNumber[0];
$SEA = array();//SearchEngineArray
while ($i >= 1) {
$quiz = QuizInfo($i);
if ($quiz['status'] != 'deleted') {
$j = $tagsNum - 1;


//подготовка текста
$quizText = ' '.$quiz['name'].' '.$quiz['description'].' ';
$quizText = str_replace(',', ' ', $quizText);//заменяет запятые на пробелы
$quizText = preg_replace("|[\s]+|i"," ",$quizText);//удаляет лишние пробелы
$quizText = mb_strtolower($quizText);//переводит строку в нижний регистр


while($j >= 0) {
    $tags[$j] = mb_strtolower($tags[$j]);
    $SEA[$i]['number of coincidences'] += mb_substr_count($quizText, ' '.$tags[$j].' ');//считает количество совпадений данного тега и приплюсовывает к сумме совпадений всех тегов
    if (mb_substr_count($quizText, ' '.$tags[$j].' ') > 0) {//если совпадения есть, то получаем координаты этих совпадений
        $z = 0;
        while ($z < mb_substr_count($quizText, ' '.$tags[$j].' ')) {//перебираем все совпадения записываем в двумерный массив как : ТЕГ - Номер тега - координата
        if ($z == 0) {// если первое совпадение то берем начало координат от самого начала
            $SEA[$i]['tags'][$tags[$j]][$z] = mb_strpos($quizText, ' '.$tags[$j].' ');
        } else {//если 2ое и далее, то смещаем координату на координату предыдущего тега + 3 ($SEA[$i]['tags'][$tags[$j]][$z1] + 3)
            $z1 = $z - 1;
            $SEA[$i]['tags'][$tags[$j]][$z] = mb_strpos($quizText, ' '.$tags[$j].' ', $SEA[$i]['tags'][$tags[$j]][$z1] + 3);
        }
        $z++;
        }
    };
    if ( mb_substr_count($quizText, ' '.$tags[$j].' ') != 0) {//счетчик количества тегов найденных в опросе, без повторений. Далее это параметр b.
    $SEA[$i]['number of tags'] += 1;
    }
    $j--;
};

if ($SEA[$i]['number of coincidences'] == 0) {//если совпадений совсем нет, то удаляем этот опрос из массива поиска SEA
  unset($SEA[$i]);
}
}
$i--;
};

$SCounter = COUNT($SEA);//Количество подходящих опросов

/*----------------------------------Получаем все параметры уравнения - a,b,c ----------------------
a - Количество пар тегов которые находятся в таком же порядке, как и в запросе поиска
b - количество тегов, которые есть в опросе, без повторений
c - общее количество совпадений

все параметры сохраняем в SEAUnS - SEA Unsorted

уравнение Ранга = 3*a+2*b+c = 'SRang'
*/

$SEAUnS = array();//SEA Unsorted
//---------------------------------Получаем параметр а-----------------

//---новый массив: Id опроса - координата тега - тег
foreach ($SEA as $quizId => $QuizSearchingData) {
  foreach ($QuizSearchingData['tags'] as $tag => $tagValues) {
    foreach ($tagValues as $key => $value) {
      $TagsInQuizUnsorted[$quizId][$value]=$tag;
    }
  }
}

//---Сортировка по координате
$TagsInQuizSorted = array();
foreach ($TagsInQuizUnsorted as $quizId => $value) {
  ksort($value);
  $TagsInQuizSorted[$quizId] = $value;
}


//---Замена координат на порядковый номер - 0,1,2...
foreach ($TagsInQuizSorted as $quizId => $TagsInQuiz) {
  $i = 0;
  foreach ($TagsInQuiz as $key => $value) {
    $TagsInQuizSorted[$quizId][$i] = $value;
    unset($TagsInQuizSorted[$quizId][$key]);
    $i++;
  }
}
// получен сортированный массив $TagsInQuizSorted вида: id опроса - порядок тега в тексте опроса - тег
//--- сам процесс подсчета параметра а
foreach ($TagsInQuizSorted as $quizId => $TagsInQuiz) {
  //echo '<h1>'.$quizId.'</h1>';
  if ($SEA[$quizId]['number of tags'] > 1) {//если меньше 1го находить пару бесполезно
    foreach ($TagsInQuiz as $key => $value) {

                  //далее узнаем какой номер нашего тега в поисковом запросе - $i
                  $i = 0;
                  while ($i < $tagsNum) {
                    if ($tags[$i] == $value) {
                      break;
                    } else {
                      $i++;
                    };
                  };
                    //echo $value.' :<br>';
            //перебираем все теги из поискового запроса:
            foreach ($tags as $tagKey => $tag) {
                //echo $tagKey.' - $tagKey  >? $i - '.$i;
              if ($tagKey > $i) {//берем только те теги из запроса, которые идут после нашего
                
                //перебираем все теги найденные в опросе
                foreach ($TagsInQuiz as $key2 => $value2) {
                    //сравниваем теги из опроса и запроса
                    //берем только теги идущие после нашего в опросе
                    
                    if ($value2 == $tag and $key2 > $key) {
                      $SEAUnS[$quizId]['a'] = $SEAUnS[$quizId]['a'] + 1/($key2 - $key);//1 делим на расстояние между тегами в опросе тем самым уменьшаем ранг для дальних тегов
                      
                      //echo '<br><br>'.$value.'['.$key.'] ? '.$value2.'['.$key2.']';
                      //echo '<br>a = '.$SEAUnS[$quizId]['a'].'<br>';
                    }
                }
                
              }
              //echo '<hr>';
            }

      }




  } else {
    $SEAUnS[$quizId]['a'] = 0;
  }
  //echo '<hr>';
}

//---------------------------------Получаем параметр b------------------
foreach ($SEA as $quizId => $value) {
  $SEAUnS[$quizId]['b'] = $SEA[$quizId]['number of tags'];
}
//---------------------------------Получаем параметр c------------------
foreach ($SEA as $quizId => $value) {
  $SEAUnS[$quizId]['c'] = $SEA[$quizId]['number of coincidences'];
}

//-------------------Считаем уравнение SRang-----------------------
foreach ($SEAUnS as $quizId => $value) {
  $SEAUnS[$quizId]['SRang'] = 3*$SEAUnS[$quizId]['a']+2*$SEAUnS[$quizId]['b']+$SEAUnS[$quizId]['c'];
}

//-----------------Cортируем массив SEAS--------------------------
foreach ($SEAUnS as $quizId => $value) {
  $SEAS[$quizId] = $SEAUnS[$quizId]['SRang'];
  arsort($SEAS);
}
/*не удалять строки для проверки
echo '<br>TagsInQuizSorted';
if (!empty($TagsInQuizSorted)) {
echo '<pre>';
print_r($TagsInQuizSorted);
echo '</pre>';
};


echo '<br>TagsInQuizUnsorted';
if (!empty($TagsInQuizUnsorted)) {
echo '<pre>';
print_r($TagsInQuizUnsorted);
echo '</pre>';
};


echo '<br>Первоначальный Массив';
if (!empty($SEA)) {
echo '<pre>';
print_r($SEA);
echo '</pre>';
} else {
  echo 'Совпадений не найдено';
}

echo '<br>SEAUnS';
if (!empty($SEAUnS)) {
echo '<pre>';
print_r($SEAUnS);
echo '</pre>';
} else {
  echo 'Совпадений не найдено';
}

echo '<br>Cортированный массив по рангу';
if (!empty($SEAS)) {
echo '<pre>';
print_r($SEAS);
echo '</pre>';
};
*/

if (!empty($SEAS)) {
  foreach ($SEAS as $quizId => $value) {
    $quiz = QuizInfo($quizId);


    //---------Здесь узнаем голосовали ли мы в этом опросе ------------------------
    $query1="SELECT * FROM `".$quizId."`";
      $result1 = mysqli_query($QUIZZESBD, $query1) or die("sadasda");
      $voicesNumSum=0;
      $voicedByMe=0;
    while($row = mysqli_fetch_array($result1)) {


      if ($row['voices']=='') {
        $VNumber = 0;
      } else {
      $VNumber = COUNT(TakeSQLArray($row['voices']));
      };


      $voices = TakeSQLArray($row['voices']);
      if (in_array($_SESSION['id'],$voices)) {
        $voicedByMe = $row['id'];
        //$voicedByMe Проверяет голосовал ли юзер за этот вариант и голосовал ли вообще
        /*
        0 - не голосовал вообще
        другое число - номер варианта за который голосвал
        */
      }

      $voicesNumSum += $VNumber;
    }
    //--------------------------------end------------------------------------------




    if ($quiz['likes'] == '') {
      $likesCounter = 0;
      $likeStatus = 'like';
    } else {
      $likes = TakeSQLArray($quiz['likes']);
      if (in_array($_SESSION['id'], $likes)) {
        $likeStatus = 'redlike';
      } else {
      $likeStatus = 'like';
      }
      $likesCounter = COUNT(TakeSQLArray($quiz['likes']));
    }


    ?>
    <div class="quizSearching"  id="<?php echo $i; ?>">
    <div class="quizBlock">
        <div class="name" onclick="openQuiz(<?php echo $quiz['id']; ?>)" title="<?php echo $quiz['name']; ?>"><?php echo $quiz['name']; ?></div>
      <div class="bgSearch"  style="background-image:url(<?php echo $quiz['poster']; ?>)"  onclick="openQuiz(<?php echo $quiz['id']; ?>)"></div>
      <div class="voicesMainContent" title="Количество проголосовавших">
        <table style="border-spacing:0;">
          <tr>
            <td>
              <img src="/resources/design/quiz/VoicesNum.png" height="20px" style="opacity:0.8;">
            </td>
            <td class='voicesNumber<?php echo $i; ?>'><?php echo $voicesNumSum; ?></td>
          </tr>
        </table>

      </div>
      <div class="likesNumber" title="Количество лайков">
        <table style="border-spacing:0;">
          <tr>
            <td>
              <img src="/resources/design/quiz/<?php echo $likeStatus ?>.png" <?php if ($_SESSION['status'] == 'login') {?> onclick="ILikeThis(<?php echo $quiz['id'] ?>)" <?php ;}; ?> height="20px" class="like-quiz-<?php echo $quiz['id'] ?>" title="Like it" alt="Like it">
            </td>
            <td class="likesNumber<?php echo $quiz['id'] ?>"><?php echo $likesCounter;  ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
<?  }
} else {
  echo 'Совпадений не найдено';
}

?>
  </div>
</div>
<?php include 'blocks/sidebar.php';include 'blocks/footer.php'; ?>
