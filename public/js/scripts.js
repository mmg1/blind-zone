$("#login").submit(function(event){
	event.preventDefault();

	$.ajaxSetup({
		headers:{
			'X-CSRF-PROTECTION': $("#token").val()
		}
	});

	var url = $(this).attr("action");
	var data = $(this).serialize();

	var request = $.post(url, data);

	request.done(function(data){
		var data = JSON.parse(JSON.stringify(data));
		if(data){
			if(data.boolean == true)
                window.location = '/';
            else {
                if (data.status == null)
                    alert('Unknown error, pls check your request and try again!');
                else
                    alert(data.status);
            }

		}
	});
});

$("#register").submit(function(event){
	event.preventDefault();

	$.ajaxSetup({
		headers:{
			'X-CSRF-PROTECTION': $("#token").val()
		}
	});

	var url = $(this).attr("action");
	var data = $(this).serialize();

	var request = $.post(url, data);

	request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
		if(data){
			if(data.boolean == true)
				window.location = '/';
			else
                alert(data.status);
		}
	});
});

$("#new_project").submit(function(event){
    event.preventDefault();

    $.ajaxSetup({
        headers:{
            'X-CSRF-PROTECTION': $("#token").val()
        }
    });

    var url = $(this).attr("action");
    var data = $(this).serialize();

    var request = $.post(url, data);

    request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
        if(data){
            alert(data.status);
            if(data.boolean == true)
                window.location = '/projects';
        }
    });
});

$("#create_link").submit(function(event){
    event.preventDefault();

    $.ajaxSetup({
        headers:{
            'X-CSRF-PROTECTION': $("#token").val()
        }
    });

    var url = $(this).attr("action");
    var data = $(this).serialize();

    var request = $.post(url, data);

    request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
        if(data){
            alert(data.status);
            if(data.boolean == true)
                window.location = window.location.href;
        }
    });
});

$("#password_change_form").submit(function(event){
    event.preventDefault();

    $.ajaxSetup({
        headers:{
            'X-CSRF-PROTECTION': $("#token_password_form").val()
        }
    });

    var url = $(this).attr("action");
    var data = $(this).serialize();

    var request = $.post(url, data);

    request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
        if(data){
            alert(data.status);
            if(data.boolean == true)
                window.location = window.location.href;
        }
    });
});

$("#payload_change_form").submit(function(event){
    event.preventDefault();

    $.ajaxSetup({
        headers:{
            'X-CSRF-PROTECTION': $("#token_payload_form").val()
        }
    });

    var url = $(this).attr("action");
    var data = $(this).serialize();

    var request = $.post(url, data);

    request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
        if(data){
            alert(data.status);
            if(data.boolean == true)
                window.location = window.location.href;
        }
    });
});

$("#new_payload").submit(function(event){
    event.preventDefault();

    $.ajaxSetup({
        headers:{
            'X-CSRF-PROTECTION': $("#token").val()
        }
    });

    var url = $(this).attr("action");
    var data = $(this).serialize();

    var request = $.post(url, data);

    request.done(function(data){
        var data = JSON.parse(JSON.stringify(data));
        if(data){
            alert(data.status);
            if(data.boolean == true)
                window.location = '/payloads';
        }
    });
});