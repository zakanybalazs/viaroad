<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <script>
    //hey server! we will do some AJAX here (creating an XMLHTTP req object)
      var xhr = new XMLHttpRequest();
      //this is a callback
      xhr.onreadystatechange = function () {
        if (xhr.readtState === 4) {
          // document.getElementById('ez').innerHTML =
          var rendszamok = JSON.parse(xhr.responseText);
          var tag = '<ul>';
          for (var i = 0; i <rendszamok.length; i++) {
          tag += '<li>';
          tag += rendszamok[i].NDN-239;
          tag += '</li>';
        }
        tag += '</ul>';
        document.getElementById('ajax').innerHTML = tag;
      };
    }
      //Open req
      xhr.open('GET', 'ajax.kilometer-request.php');
      //send req
      xhr.send();
    </script>
    <div id="ajax">

    </div>
  </body>
</html>
