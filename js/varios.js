function questions_projects() {
    var project = document.getElementById('project').value;
    var parametros = {
        "project": project,
    };
    $.ajax({
        data: parametros,
        url: "../ajax/ajax.questions_projects.php",
        type: "post",
        beforeSend: function () {
            $("#result").html("Process");
            console.log();
        },
        success: function (response) {
            $("#result").html(response);
        }
    });
}

function answer_ques() {
    var questions = document.getElementById('questions').value;
    var parametros = {
        "questions": questions,
    };
    $.ajax({
        data: parametros,
        url: "../ajax/ajax.questions_projects.php",
        type: "post",
        beforeSend: function () {
            $("#resultans").html("Process");
            console.log();
        },
        success: function (response) {
            $("#resultans").html(response);
        }
    });
}

function addinputsanswers() {
    var number_answers = document.getElementById('number_answers').value;
    var parametros = {
        "number_answers": number_answers,
    };
    $.ajax({
        data: parametros,
        url: "../ajax/ajax.prueba.php",
        type: "post",
        beforeSend: function () {
            $("#resultadd").html("Process");
            console.log();
        },
        success: function (response) {
            $("#resultadd").html(response);
        }
    });
}

function validation_rol() {
    var email = document.getElementById('email').value;
    var parametros = {
        "email": email,
    };
    $.ajax({
        data: parametros,
        url: "../ajax/ajax.validation_login.php",
        type: "post",
        beforeSend: function () {
            $("#resultadorol").html("Process");
            console.log();
        },
        success: function (response) {
            $("#resultadorol").html(response);
        }
    });
}
var cajas=1;
function agregarFila(){
    var valores = new Array();
    var contenido = ""
    var contenidov = ""
    for (i = 1; i <= cajas; i++) {//Obtenemos el valor de las cajas
        valores[i] = eval("document.form.answer" + i.toString() + ".value");
        valores[i] = eval("document.form.correct" + i.toString() + ".value");
    }
    cajas = cajas + 1
    for (i in valores) {
        contenido += " <input type=text name='answer" + i.toString() + "' value='" + valores[i] + "' class='form-control' ><br>";
        contenidov += " <input type=text name='correct" + i.toString() + "' value='" + valores[i] + "' class='form-control' ><br>";
    }
    contenido += " <input type=text name='answer" + cajas.toString() + "' class='form-control' value='I dont know'>";
    contenidov += " <input type=text name='correct" + cajas.toString() + "' class='form-control'>";
    document.getElementById("cajas").innerHTML = contenido;
    document.getElementById("cajasv").innerHTML = contenidov;
}

var cajas2 = 2;

function add_input_starproject() {
    var valores2 = new Array();
    var contenido2 = ""

    for (i = 1; i <= cajas2; i++) {//Obtenemos el valor de las cajas
        valores2[i] = eval("document.form.valor" + i.toString() + ".value");
    }
    cajas2 = cajas2 + 1
    for (i in valores2) {
        contenido2 += " <input type=text name='valor" + i.toString() + "' value='" + valores2[i] + "' class='form-control'><br>";
    }
    contenido2 += " <input type=text name='valor" + cajas2.toString() + "' class='form-control'><br>";
    document.getElementById("cajas2").innerHTML = contenido2;
}

$(document).ready(function() {
    $('#key').on('keyup', function() {
        var key = $(this).val();        
        var dataString = 'key='+key;
    $.ajax({
            type: "POST",
            url: "../ajax/ajax.autocomplet.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
            }
        });
    });
});
$(function() {
    $("#answer").autocomplete({
        source: "../ajax/ajax.autocomplete_answers.php",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#answer').val(ui.item.answer);           
        }
    });


});