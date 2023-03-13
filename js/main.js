$(document).on('click', 'a', function (e) {
    if ($('#'+e.target.id).attr('href')=='#') {
        e.preventDefault();
    }
});

function Saida(url){
        var form = document.createElement("form");
        form.setAttribute("action",url);
        form.setAttribute("method","GET");
        form.setAttribute("target","conteudo");
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
}
function tecladoSistema(e, obj, div){
    var tecla=(window.event)?event.keyCode:e.which;

    if ( tecla == 13 ) {
        localiza_sistema(obj.value, div);
        return true;
    } else {
        return numeroInteiro(e,obj);
    }
}

function tabela() {  
     $(document).ready(function() {
       $('#clicli').dataTable();
     } );
}


function novo_sistema(usu){
    window.open('pweb_001.php');
}
function inicia() {
//var tabela1 = new superTable("tabela_fixa"); }
 var tabela1 = new superTable("lista_tabela", {	colWidths : [200,300, 80, 80,-1,-1,250] });
}
function addLinha(nome){
    var tab = document.getElementById("tabela");
    //insere linha
    var linha = tab.insertRow(tab.rows.length );
    //insere celulas
    var coluna1 = linha.insertCell(-1);
    coluna1.align ="center";
    coluna1.innerHTML = '<input type="checkbox" name="raiz_'+tab.rows.length+'"  value="" />';

    coluna1 = linha.insertCell(-1);
    coluna1.align ="right";
    coluna1.innerHTML = '<input type="text" name="arq[]"  value="" size="80" maxlength="80" class="f_texto"/>';
    return true;
}
function blur_nome(obj) {
    var frm = obj.form;
    if ( frm.nome_completo.value == "" ) {
        frm.nome_completo.value = obj.value;
    }
}

