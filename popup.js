function popup(filmId)
{
    var response = "";
    $.ajax({
        type:'GET',
        url:'fulldescription.php?film='+filmId,
        success:function(data) {
            response = data.split("<br/>");
            $("#dialog").html(response[0]);
        }
    });
    $(function(){
        $("#dialog").delay(500).queue(function(next){
            $(this).dialog().dialog('option', 'title', response[1]);
            next();
        });
    });
}