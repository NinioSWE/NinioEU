$( document ).ready(function() {

});


function ButtonWasPressed(theButton){
	if($(theButton).val() == 1){
		$(theButton).css("background-color", "green");
		//$.getJSON('https://opentdb.com/api.php?amount=10&category=31&difficulty=medium&type=multiple', success);
	}else {
		$(theButton).css("background-color", "red");
	}
}



function success(data) {
	//var json = JSON.parse(data); unescape(encodeURIComponent(result['question'].replace(/&quot;/g, '\\"')))
	var result = data['results'][0];
	var question = unescape(encodeURIComponent(result['question']));
	var htmltext = '<h2>'+ question +'</h2>';
	var choices = [unescape(encodeURIComponent(result['correct_answer'])), unescape(encodeURIComponent(result['incorrect_answers'][0])),unescape(encodeURIComponent(result['incorrect_answers'][1])),unescape(encodeURIComponent(result['incorrect_answers'][2]))];
   	shuffleArray(choices);
   	htmltext += '<div class="button-holder">';
    htmltext += '<button class="answer-button1 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="';
    if(choices[0] == unescape(encodeURIComponent(result['correct_answer']))){
    	htmltext += '1';
    }else{
    	htmltext += '0';
    }
    htmltext += '">';
   	htmltext += choices[0] +'</button>';

   	htmltext += '<button class="answer-button2 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="';
    if(choices[1] == unescape(encodeURIComponent(result['correct_answer']))){
    	htmltext += '1';
    }else{
    	htmltext += '0';
    }
    htmltext += '">';
   	htmltext += choices[1] +'</button>';

   	htmltext += '<button class="answer-button3 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="';
    if(choices[2] == unescape(encodeURIComponent(result['correct_answer']))){
    	htmltext += '1';
    }else{
    	htmltext += '0';
    }
    htmltext += '">';
   	htmltext += choices[2] +'</button>';

   	htmltext += '<button class="answer-button4 quizbutton" onclick="ButtonWasPressed(this)" type="button" value="';
    if(choices[3] == unescape(encodeURIComponent(result['correct_answer']))){
    	htmltext += '1';
    }else{
    	htmltext += '0';
    }
    htmltext += '">';
   	htmltext += choices[3] +'</button>';
    htmltext += '</div>';
	$('.gameScreen').html(htmltext);
}

function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}