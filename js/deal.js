/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
       function pesquisa_produto()  {
        $('.typeahead').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "pesquisa_produto.php",
          data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
            result($.map(data, function (item) {
              return item;
                        }));
                    }
                });
            }
        });
    }
       function pesquisa_pessoa()  {
        $('.typeahead').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "pesquisa_pessoa.php",
          data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
            result($.map(data, function (item) {
              return item;
                        }));
                    }
                });
            }
        });
    }
    function tabela() {   
             $('#clicli').dataTable();
      }

    function atualiza( frm ) {
            frm.action = 'logout.php';
            frm.submit();

            frm.action = 'capa.php';
            frm.target ='conteudo';
            frm.submit();
        }

     function carga_menu(frm) {
            frm.action = "menu.php";
            frm.forca_menu.value=1;
            frm.submit();
        }
     function digitacao(e,o)    {
            var tecla=(window.event)?event.keyCode:e.which;
            if(tecla ==13) {
                o.focus(false);
                busca();
                return false;
            }
            return true;
        }

        function limpar()
        {
            var txt = document.getElementById("texto");
            txt.value = "";
            txt.focus();
        }

    /***********************************************
    * Cool DHTML tooltip script II- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/

    var offsetfromcursorX=12 //Customize x offset of tooltip
    var offsetfromcursorY=10 //Customize y offset of tooltip

    var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
    var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

    document.write('<div id="dhtmltooltip"></div>') //write out tooltip DIV
    //document.write('<img id="dhtmlpointer" src="img/informacao.gif" border="0" height="22px" width="22px">') //write out pointer image
    document.write('<img id="dhtmlpointer" src="" border="0" height="0px" width="0px">') //write out pointer image

    var ie=document.all;
    var ns6=document.getElementById && !document.all;
    var enabletip=false;
    if (ie||ns6) {
      var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""
      var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""
    }

    function ietruebody(){
        return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
    }

    function ddrivetip(thetext, thewidth, thecolor){
        if (ns6||ie){
            if (typeof thewidth!="undefined") { tipobj.style.width=thewidth+"px"; }
            if (typeof thecolor!="undefined" && thecolor!="") { tipobj.style.backgroundColor=thecolor; }
            tipobj.innerHTML=thetext
            enabletip=true
            return false
        }
    }

    function positiontip(e){
        if (enabletip){
            var nondefaultpos=false
            var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
            var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
            //Find out how close the mouse is to the corner of the window
            var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
            var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

            var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
            var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

            var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000;

            //if the horizontal distance isn't enough to accomodate the width of the context menu
            if (rightedge<tipobj.offsetWidth){
                //move the horizontal position of the menu to the left by it's width
                tipobj.style.left="5px"; //curX; //-tipobj.offsetWidth+"px"
                nondefaultpos=true;
            } else if (curX<leftedge){
                tipobj.style.left="5px";
            }else{
                //position the horizontal position of the menu where the mouse is positioned
                tipobj.style.left="5px";//curX+offsetfromcursorX-offsetdivfrompointerX+"px";
                pointerobj.style.left="5px";//curX+offsetfromcursorX+"px";
            }

            //same concept with the vertical position
            if (bottomedge<tipobj.offsetHeight){
                tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px";
                nondefaultpos=true;
            } else{
                tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px";
                pointerobj.style.top=curY+offsetfromcursorY+"px";
            }

            tipobj.style.visibility="visible"
            if (!nondefaultpos) {
                pointerobj.style.visibility="visible"
            } else {
              pointerobj.style.visibility="hidden"
            }
        }
    }

    function hideddrivetip(){
      if (ns6||ie){
        enabletip=false
        tipobj.style.visibility="hidden"
        pointerobj.style.visibility="hidden"
        tipobj.style.left="-1000px"
        tipobj.style.backgroundColor=''
        tipobj.style.width=''
      }
    }
    document.onmousemove=positiontip;


