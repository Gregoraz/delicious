
$( document ).ready(function() {
    $("#displayFilter").click(function(){
        $("#resultForm").show();
        $("#displayFilter").hide();
        $("#displayFilter2").show();
    });
    $("#displayFilter2").click(function(){
        $("#resultForm").hide();
        $("#displayFilter").show();
        $("#displayFilter2").hide();
    });});
