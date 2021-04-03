// Slack
$.ajax({
    'url': config.routes.api_slack_count,
    'success': function (data) {
        $("#slack__online").html(data)
    },
    'error': function () {
        $("#slack__online").html('...')
    }
})

$("#slack__invite").on('click', function () {
    $("#slack__invite").html("Working...")
    $.ajax({
        'url': config.routes.api_slack_invite,
        'success': function (data) {
            $("#slack__invite").html(data).attr("disabled", true)
        },
        'error': function () {
            $("#slack__invite").html('Something went wrong...')
        }
    })
})

//Discord
$.ajax({
    'dataType': "json",
    'url': "https://discordapp.com/api/guilds/"+config.discord_server_id+"/widget.json",
    'success': function (data) {
        $("#discord__online").html(data['presence_count'])
    },
    error: function () {
        $("#discord__online").html('...')
    },
})