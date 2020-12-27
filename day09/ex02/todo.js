var list = document.getElementById("ft_list");
var decodedCookie = decodeURIComponent(document.cookie);
var ca = decodedCookie.split(';');
for (var i = ca.length - 1; i >= 0 && ca != ''; i--) {
	cookie = ca[i].split('=');
	var new_element = document.createElement("li");
	var_text = document.createTextNode(cookie[1]);
	new_element.appendChild(var_text);
	new_element.setAttribute('id', cookie[0]);
	new_element.setAttribute('onclick', "remove(\"" + new_element.id + "\")");
	list.appendChild(new_element);
}

function newElement()
{
	var list = document.getElementById("ft_list");
	var todo = prompt("fill in a new TO DO");
	if (todo != '' && todo != null) {
		var new_element = document.createElement("li");
		var_text = document.createTextNode(todo);
		new_element.appendChild(var_text);
		new_element.setAttribute('id', "cus" + Date.now());
		document.cookie = new_element.id + "=" + todo;
		new_element.setAttribute('onclick', "remove(\"" + new_element.id + "\")");
		list.insertBefore(new_element, document.getElementById(getLastToDoId()));
		location.reload();
  	}
}

function remove(id)
{
	var yesornot = prompt("Y/n").toLowerCase();
	if (yesornot == 'y' || yesornot == 'yes')
	{
		var list = document.getElementById("ft_list");
		var this_element = document.getElementById(id);
		removeCookie(this_element.id);
		list.removeChild(this_element);
	}
	else if (yesornot == '')
		remove(id);
}

function getLastToDoId()
{
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	if (ca.length == 0)
		return null;
	else 
		return ca[0].split("=")[0];
}

function removeCookie(cname)
{
	document.cookie = cname + "=; expires= Thu, 21 Aug 2014 20:00:00 UT";
}