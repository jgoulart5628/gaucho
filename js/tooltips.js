//OFT1.1


///////////////////////////////////////
//
//  Onfocus tooltips by Brothercake
//  http://www.brothercake.com/
//
///////////////////////////////////////



//global object and initial properties
var tip = {
	'tooltip' : null,
	'parent' : null,
	'timer' : null
	};



//initialisation function
tip.init = function()
{
	//if the necessary collection is supported
	if(typeof document.getElementsByTagName != 'undefined')
	{
		//get all tags 
		tip.tags = document.getElementsByTagName('*');
		tip.tagsLen = tip.tags.length;
	
		for (var i=0; i < tip.tagsLen; i++)
		{
	
			//if tag has a title attribute
			if(tip.tags[i].title)
			{
				//attach handlers
				tip.tags[i].onfocus = tip.focusTimer;
				tip.tags[i].onblur = tip.blurTip;
				tip.tags[i].onmouseover = tip.blurTip;

			}
	
		}
	}
}



//setup initialisation function
if(typeof window.addEventListener != 'undefined')
{
	//.. gecko, safari, konqueror and standard
	window.addEventListener('load', tip.init, false);
}
else if(typeof document.addEventListener != 'undefined')
{
	//.. opera 7
	document.addEventListener('load', tip.init, false);
}
else if(typeof window.attachEvent != 'undefined')
{
	//.. win/ie
	window.attachEvent('onload', tip.init);
}



//find object position
tip.getRealPosition = function(ele, dir)
{
	tip.pos = (dir=='x') ? ele.offsetLeft : ele.offsetTop;
	tip.tmp = ele.offsetParent;
	while(tip.tmp != null)
	{
		tip.pos += (dir=='x') ? tip.tmp.offsetLeft : tip.tmp.offsetTop;
		tip.tmp = tip.tmp.offsetParent;
	}
	return tip.pos;
}




//delay timer
tip.focusTimer = function(e)
{
	//second loop	
	if(tip.timer != null)
	{
		//clear timer
		clearInterval(tip.timer);
		tip.timer = null;
	
		//pass object to create tooltip
		tip.focusTip(e);
	}
	//first loop
	else
	{
		//get focussed object to pass back through timer
		tip.tmp = (e) ? e.target : event.srcElement;
	
		//set interval
		tip.timer = setInterval('tip.focusTimer(tip.tmp)',400);
	}
}


//create tooltip
tip.focusTip = function(obj)
{

	//remove any existing tooltip
	tip.blurTip();

	//if tooltip is null
	if(tip.tooltip == null)
	{
		//get window dimensions
		if(typeof window.innerWidth!="undefined")
		{
			tip.window = {
				x : window.innerWidth,
				y : window.innerHeight
				};
		}
		else if(typeof document.documentElement.offsetWidth!="undefined")
		{
			tip.window = {
				x : document.documentElement.offsetWidth,
				y : document.documentElement.offsetHeight
				};
		}
		else 
		{
			tip.window = {
				x : document.body.offsetWidth,
				y : document.body.offsetHeight
				};
		}

		//create toolTip, detecting support for namespaced element creation, in case we're in the XML DOM
		tip.tooltip = (typeof document.createElementNS != 'undefined') ? document.createElementNS('http://www.w3.org/1999/xhtml', 'div') : document.createElement('div');

		//add classname
		tip.tooltip.setAttribute('class','');
		tip.tooltip.className = 'tooltip';

		//get focussed object co-ordinates
		if(tip.parent == null)
		{
			tip.parent = {
				x : tip.getRealPosition(obj,'x') - 3,
				y : tip.getRealPosition(obj,'y') + 2
				};
		}

		// offset tooltip from object
		tip.parent.y += obj.offsetHeight;

		//apply tooltip position
		tip.tooltip.style.left = tip.parent.x + 'px';
		tip.tooltip.style.top = tip.parent.y + 'px';

		//write in title attribute 
		tip.tooltip.appendChild(document.createTextNode(obj.title));

		//add to document
		document.getElementsByTagName('body')[0].appendChild(tip.tooltip);

		//restrict width
		if(tip.tooltip.offsetWidth > 300)
		{
			tip.tooltip.style.width = '300px';
		}

		//get tooltip tip.extent
		tip.extent = {
				x : tip.tooltip.offsetWidth,
				y : tip.tooltip.offsetHeight
				};

		//if tooltip exceeds window width
		if((tip.parent.x + tip.extent.x) >= tip.window.x)
		{
			//shift tooltip left
			tip.parent.x -= tip.extent.x;
			tip.tooltip.style.left = tip.parent.x + 'px';
		}
		
		//get scroll height
		if(typeof window.pageYOffset!="undefined")
		{
			tip.scroll = window.pageYOffset;
		}
		else if(typeof document.documentElement.scrollTop!="undefined")
		{
			tip.scroll = document.documentElement.scrollTop;
		}
		else 
		{
			tip.scroll = document.body.scrollTop;
		}

		//if tooltip exceeds window height
		if((tip.parent.y + tip.extent.y) >= (tip.window.y + tip.scroll))
		{
			//shift tooltip up
			tip.parent.y -= (tip.extent.y + obj.offsetHeight + 4);
			tip.tooltip.style.top = tip.parent.y + 'px';
		}


	}

}


//remove tooltip
tip.blurTip = function()
{
	//if tooltip exists
	if(tip.tooltip != null)
	{
		//remove and nullify tooltip
		document.getElementsByTagName('body')[0].removeChild(tip.tooltip);
		tip.tooltip = null;
		tip.parent = null;
	}
	
	//cancel timer
	clearInterval(tip.timer);
	tip.timer = null;
}



