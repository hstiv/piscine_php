$(document).ready(function(){
	$.get('select.php', function(data){
		var ca = data.split('|');
		for (var i = ca.length - 1; i >= 0 && ca != ''; i--)
		{
			todo = ca[i].split(';');
			var new_element = $("<li>");
			var_text = document.createTextNode(todo[1]);
			$(new_element).append(var_text);
			$(new_element).attr('id', todo[0]);
			$('#ft_list').append($(new_element));
		}
	});

	// var decodedCookie = decodeURIComponent(document.cookie);
	// var ca = decodedCookie.split(';');
	// for (var i = ca.length - 1; i >= 0 && ca != ''; i--) {
	// 	cookie = ca[i].split('=');
	// 	var new_element = $("<li>");
	// 	var_text = document.createTextNode(cookie[1]);
	// 	$(new_element).append(var_text);
	// 	$(new_element).attr('id', cookie[0]);
	// 	$('#ft_list').append($(new_element));
	// }
	$('.btn').click(function(){
		var todo = prompt("fill in a new TO DO");
		if (todo != '' && todo != null) {
			$.get("insert.php?id=cus" + Date.now() + '&todo=' + todo, function(data){
				ca = data.split(';');
				var new_element = $("<li>");
				var_text = document.createTextNode(ca[1]);
				$(new_element).append(var_text);
				$(new_element).attr('id', ca[0]);
				$('#ft_list').prepend($(new_element));
			});
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

