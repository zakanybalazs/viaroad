<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta charset="utf-8">
    <title></title>
  </head>
    <script>
$(function(ready){
    $('#rendi').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var rendszam = this.value;

    // var rendszam = "NDN-239";
    var rendszamQ = "rdn="+rendszam;
// $('#ajax').load('ajax.kilometer-json.php');
$.get('ajax.kilometer-json.php', rendszamQ, function(response) {
  // $('#kil').html(response+);
  var result = response.map(function (x) {
    return parseInt(x, 10);
});
  $('input[id=kil]').val(result);
});

  $('#load').hide();
 //sendAjax vege
}
);
});

</script>
<!-- <button type="button" id="load" onclick="sendAjax()">click me</button> -->
<div id="ajax">
<select id="rendi">
<option>valami</option>
<option>NDN-239</option>
</select>
</div>
<input type="text" name="kil" value="" id="kil">
  </body>
</html>
