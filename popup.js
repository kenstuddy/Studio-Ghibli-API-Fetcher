function popup(filmId)
{
    var title = "";
    var description = "";
    $.ajax({
        type:'GET',
        url:'fulldescription.php?film='+filmId,
        success:function(data) {
            title = data.title;
            description = data.description;
            $("#dialog").html(description);
        }
    });
    $(function(){
        $("#dialog").delay(500).queue(function(next){
            $(this).dialog().dialog('option', 'title', title);
            next();
        });
    });
}