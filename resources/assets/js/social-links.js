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