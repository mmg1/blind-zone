$("#panel_form").submit(function(event){
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
