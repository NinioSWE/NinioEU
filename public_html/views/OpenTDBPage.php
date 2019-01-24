<h1>Anime quiz!</h1>
<?php
if($data['jsonFile'] != null){

  foreach ($data['jsonFile']->results as $result) {
    $choices = array($result->correct_answer,$result->incorrect_answers[0],$result->incorrect_answers[1],$result->incorrect_answers[2]);
    shuffle($choices);
    ?>
    <div class="gameScreen">
      <h2><?= $result->question?> </h2>
      <div class="button-holder">
        <button class="answer-button1 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="<?=($choices[3] == $result->correct_answer) ? 1:0 ?>"><?= $choices[3]?> </button>
        <button class="answer-button2 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="<?=($choices[0] == $result->correct_answer) ? 1:0 ?>"><?= $choices[0]?> </button>
        <button class="answer-button3 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="<?=($choices[2] == $result->correct_answer) ? 1:0 ?>"><?= $choices[2]?> </button>
        <button class="answer-button4 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="<?=($choices[1] == $result->correct_answer) ? 1:0 ?>"><?= $choices[1]?> </button>
      </div>
    </div>
    <?php
  }

}
?>
<script src="/js/quizHandler.js?v3.0"></script>