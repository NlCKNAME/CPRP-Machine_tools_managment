var TIME_RELOAD=1000;

function display_(file)
{
var obj=document.getElementById(file);
	if(obj.style.display=="none")
obj.style.display="block";
	else
obj.style.display="none";
}

function load(nameid)
{
var obj=document.getElementById(nameid);

obj.onkeyup=function ()
{
   var id= window.setTimeout(function () { f(obj.value); },TIME_RELOAD);	

	}
	
obj.onkeydown=function ()
{
      window.clearTimeout(id);

	}

}

window.onload=function ()
{
	load("larecherche");
	}

function f(recherche)
{

document.getElementById('recherche').innerHTML=""; /*Vide le contenu  de la recherche*/
if(recherche!="" && recherche!=" ")
{

var i;
var out=document.getElementById('recherche');
var obj=document.body;
var a=obj.innerHTML.split('\n');
var maReg = new RegExp( recherche+".*<a href", "g" ) ;

for (i=0; i<a.length; i++){ 
	
	if(a[i]!=""){ 
	 var rslt=a[i].search(maReg);
		if(rslt!= -1)
		{
			out.innerHTML+=a[i];
		}

	}

 }
}
}


var buttonstate=0;
function onoff(element)
{
  buttonstate= 1 - buttonstate;
  var blabel, bstyle, bcolor;
  if(buttonstate)
  {
    blabel="on";
    bstyle="green";
    bcolor="lightgreen";
  }
  else
  {
    blabel="off";
    bstyle="lightgray";
    bcolor="gray";
  }
  var child=element.firstChild;
  child.style.background=bstyle;
  child.style.color=bcolor;
  child.innerHTML=blabel;
}