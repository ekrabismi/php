function selallyes(id)
{
	var id = id;
	
	var chks = document.getElementsByName('yes_photo_' + id + '[]');
	var chks2 = document.getElementsByName('no_photo_' + id + '[]');

	for (var i = 0; i < chks.length; i++)
	{
	 if (chks[i].checked)
	 {
	  chks[i].checked = false;
	  chks2[i].checked = true;
	 }
	 else
	 {
	  chks[i].checked = true;
	  chks2[i].checked = false;
	 }
	
	}

}

function selallno(id)
{
	var id = id;
	
	var chks = document.getElementsByName('no_photo_' + id + '[]');
	var chks2 = document.getElementsByName('yes_photo_' + id + '[]');

	for (var i = 0; i < chks.length; i++)
	{
	 if (chks[i].checked)
	 {
	  chks[i].checked = false;
	  chks2[i].checked = true;
	 }
	 else
	 {
	  chks[i].checked = true;
	  chks2[i].checked = false;
	 }
	
	}

}

function delyes(key,id)
{
    var id = id;
	var key = parseInt(key,10) - 1;
	
	var chks = document.getElementsByName('yes_photo_' + id + '[]');
   if(chks[key].checked == true)
	  chks[key].checked = false;

}

function delno(key,id)
{
    var id = id;
	var key = parseInt(key,10) - 1;
	
	var chks = document.getElementsByName('no_photo_' + id + '[]');
   if(chks[key].checked == true)
	  chks[key].checked = false;

}

function selallfrd(id)
{
	var id = id;
	
	var chks = document.getElementsByName('frd_' + id + '[]');

	for (var i = 0; i < chks.length; i++)
	{
	 if (chks[i].checked)
	  chks[i].checked = false;
	 else
	  chks[i].checked = true;
	
	}

}
  
	  
function applimit(value,id)
	  {
		  var value = parseInt(value);
		  var id = id;
		  //alert(value + "i: " + id);
		  window.location = "cpanel.php?limit="+value+"&id="+id;

	  }	  
function appsuspend(value,id)
	  {
		  var value = parseInt(value);
		  var id = id;
		  //alert(value + "i: " + id);
		  window.location = "cpanel.php?suspend="+value+"&id="+id;

	  }	  	  
