<style>
	#suggestions {
    box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
    height: auto;
    position: absolute;
    top: 45px;
    z-index: 9999;
    width: 206px;
}
 
#suggestions .suggest-element {
    background-color: #EEEEEE;
    border-top: 1px solid #d6d4d4;
    cursor: pointer;
    padding: 8px;
    width: 100%;
    float: left;
}
</style>
<script src="../public/bower_components/jquery/dist/jquery.min.js"></script>

<?php 

if($_POST['number_answers']){
	
	for($i=1;$i<=$_POST['number_answers'];$i++){
		echo '<br>';
		echo '<div class="panel panel-default">'; 
		echo '<div class="panel-heading">Panel Answer</div>';
			echo '<table class="table table-bordered">
				  <colgroup>
				  <col>
				  <col>
				  <col>
				  </colgroup>
				  <thead>
				    <tr>
				      <th>Answer'.$i.'<input type="text" name="answer'.$i.'" id="answer'.$i.'" class="search_query form-control"><br></th>
				      <th>Valoration'.$i.'<input type="text" name="correct'.$i.'" id="correct'.$i.'" class="form-control"><br></th>
				      <th><input type="checkbox" name="check'.$i.'" id="check'.$i.'" class="form-check-input"><br></th>
				    </tr>
				  </thead>				
				  </table>';
		echo '</div>';
	}
	echo '<input type="submit" name="submit_answers" value="Submit Answer" class="btn btn-success">';
	echo '<div id="suggestions"></div>';
	
}else{
	echo 'no llega';
}
?>
<script>
$(document).ready(function() {
    $(document).keyup(function(e) {
    	var number_answers=document.getElementById('number_answers').value;
    	if (number_answers == 1) {
            var answer1 = document.getElementById('answer1').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 2) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 3) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 4) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;

        } else if (number_answers == 5) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 6) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            var answer6 = document.getElementById('answer6').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 7) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            var answer6 = document.getElementById('answer6').value;
            var answer7 = document.getElementById('answer7').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 8) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            var answer6 = document.getElementById('answer6').value;
            var answer7 = document.getElementById('answer7').value;
            var answer8 = document.getElementById('answer8').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 9) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            var answer6 = document.getElementById('answer6').value;
            var answer7 = document.getElementById('answer7').value;
            var answer8 = document.getElementById('answer8').value;
            var answer9 = document.getElementById('answer9').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (number_answers == 10) {
            var answer1 = document.getElementById('answer1').value;
            var answer2 = document.getElementById('answer2').value;
            var answer3 = document.getElementById('answer3').value;
            var answer4 = document.getElementById('answer4').value;
            var answer5 = document.getElementById('answer5').value;
            var answer6 = document.getElementById('answer6').value;
            var answer7 = document.getElementById('answer7').value;
            var answer8 = document.getElementById('answer8').value;
            var answer9 = document.getElementById('answer9').value;
            var answer10 = document.getElementById('answer10').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else {
            console.log('dsssds');
        }
       if (number_answers == 1) {
            var parametros = {
                "answer1": answer1,              
            };
        } else if (number_answers == 2) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
            };
        } else if (number_answers == 3) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
            };
        } else if (number_answers == 4) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
            };
        } else if (number_answers == 5) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
            };
        } else if (number_answers == 6) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
                "answer6": answer6,
            };
        } else if (number_answers == 7) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
                "answer6": answer6,
                "answer7": answer7,
            };
        } else if (number_answers == 8) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
                "answer6": answer6,
                "answer7": answer7,
                "answer8": answer8,
            };
        } else if (number_answers == 9) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
                "answer6": answer6,
                "answer7": answer7,
                "answer8": answer8,
                "answer9": answer9,
            };
        } else if (number_answers == 10) {
            var parametros = {
                "answer1": answer1,
                "answer2": answer2,
                "answer3": answer3,
                "answer4": answer4,
                "answer5": answer5,
                "answer6": answer6,
                "answer7": answer7,
                "answer8": answer8,
                "answer9": answer9,
                "answer10": answer10,
            };
        } else {
        }
   
    $.ajax({
            type: "POST",
            url: "../ajax/ajax.autocomplet.php",
            data: parametros,
             beforeSend: function () {
                $("#suggestions").html("Procesando");
                console.log();
            },
            success: function (data) {
            	$('#suggestions').fadeIn(1000).html(data);
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#answer1').val($('#'+id).attr('data'));
                        $('#answer2').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
            }

        });
    });
});

</script>