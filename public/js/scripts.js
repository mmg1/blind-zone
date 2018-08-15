$(document).ready(function() {

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();

    $(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
            }

        });
    });

    $('#projects').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false
    });

    $('#project_links').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "ordering": true,
        columnDefs: [{
            orderable: false,
            targets: "no-sort"
        }]
    });

    $('#link_interactions').DataTable({
        // "bPaginate": true,
        "pagingType": "simple_numbers",
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 25,
        "ordering": true,
        "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        "fnDrawCallback": function(oSettings) {
            if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            }
        },
        columnDefs: [{
            orderable: false,
            targets: "no-sort"
        }]
    });

    $('#list').DataTable({
        // "bPaginate": true,
        "pagingType": "simple_numbers",
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 25,
        "ordering": true,
        "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        "fnDrawCallback": function(oSettings) {
            if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
            }
        },
        columnDefs: [{
            orderable: false,
            targets: "no-sort"
        }]
    });
} );

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

