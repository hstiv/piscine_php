$(document).ready(function(){
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = ca.length - 1; i >= 0 && ca != ''; i--) {
		cookie = ca[i].split('=');
		var new_element = $("<li>");
		var_text = document.createTextNode(cookie[1]);
		$(new_element).append(var_text);
		$(new_element).attr('id', cookie[0]);
		$('#ft_list').append($(new_element));
	}
	$('.btn').click(function(){
		var todo = prompt("fill in a new TO DO");
		if (todo != '' && todo != null) {
			var new_element = $("<li>");
			var_text = document.createTextNode(todo);
			$(new_element).append(var_text);
			$(new_element).attr('id', "cus" + Date.now());
			document.cookie = $(new_element).attr('id') + "=" + todo;
			$('#ft_list').prepend($(new_element));
			location.reload(true);
	  	}
	});
	$('li').click(function(){
		var yn = prompt("Y/n").toLowerCase();
		if (yn == 'y' || yn == 'yes')
		{
			document.cookie = $(this).attr('id') + "=; expires= Thu, 21 Aug 2014 20:00:00 UT";
			$(this).remove();
		}
		else if (yn == 'n')
			return;
	});
});

