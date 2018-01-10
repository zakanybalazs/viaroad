function ajaxMent(Id, nev, telep, dij) {
  var PCeg = document.getElementById(nev).innerText;
  var PTelep = document.getElementById(telep).innerText;
  var PDij = document.getElementById(dij).innerText;
  if (PCeg == '' || PTelep == '' || Id == '' ) {
    bootbox.alert({
      title: "Hiba",
      message: "Minden mező kitöltése kötelező!",
    });
  } else {
    $.post( "ajax/ajax.ujcegedit.php", {
      PostCeg : PCeg,
      PostTelep : PTelep,
      id : Id,
      PostDij : PDij
    },
    "json" ).done(function( response ) {
        if (response == "ok") {
          bootbox.alert({
              title: "Siker!",
              size: "small",
              message: "Az adatokat sikeresen rögzítettük!",
              animate: true,
              backdrop: true,
              callback: function() {
                window.location.href = "cegadmin.php";
              },
          }); //bootbox siker
        } else {
          bootbox.alert({
              title: "Hiba",
              size: "small",
              message: "Probléma történt az adatok rögzítésénél!",
              animate: true,
              backdrop: true,
                }); // bootbox hiba
              } // response? ok else
            }); // done(function) end
        }


    }
function torlesc(id) {
  bootbox.confirm({
    title: "Megerősítés",
    message: '<h3>Biztosan törölni akarod a céget az adatbázisből?</h3>',
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Mégsem'
        },
        confirm: {
            label: '<i class="fa fa-check fa-success"></i> Mehet'
        }
    },
    callback: function(result) {
      if (result == true) {
        $.post('ajax/ajax.torlesceg.php',{
          PostId: id
        }, "json").done(function(response){
          if (response == "ok") {
            bootbox.alert({
                title: "Siker!",
                size: "small",
                message: "Az adatokat sikeresen töröltük!",
                animate: true,
                backdrop: true,
                callback: function() {
                  $('#' + id + 'tr').fadeOut(800);
                },
            }); //bootbox siker
          } else {
            bootbox.alert({
                title: "Hiba",
                size: "small",
                message: "Probléma történt az adatok törlésénél!",
                animate: true,
                backdrop: true,
                  }); // bootbox hiba
          }
        });
      }
    }
  });
}

function elrejt() {
  $('#hidewell').removeAttr('hidden');
  $('#click').removeAttr('onclick');
  $('#click').attr('onclick','felfed()');
  $('#buttontext').removeAttr('class');
  $('#buttontext').attr('class', 'glyphicon glyphicon-minus-sign');
}

function felfed() {
  $('#hidewell').attr('hidden', 'hidden');
  $('#click').removeAttr('onclick');
  $('#click').attr('onclick','elrejt()');
  $('#buttontext').removeAttr('class');
  $('#buttontext').attr('class', 'glyphicon glyphicon-plus-sign');
}

function sendNew() {
  var ceg = $('#ceg').val();
  var telep = $('#telep').val();
  var id = $('#id').val();
  var dij = $('#dij').val();
  if (ceg == '' || telep == '' || id == '' || dij == '') {
    bootbox.alert({
      title: "Hiba",
      message: "Minden mező kitöltése kötelező!",
    });
  } else {
    $.post( "ajax/ajax.ujcegsubmit.php", {
      PostCeg : ceg,
      PostTelep : telep,
      PostId : id,
      PostDij : dij
    },
    "json" ).done(function( response ) {
        if (response == "ok") {
          bootbox.alert({
              title: "Siker!",
              size: "small",
              message: "Az adatokat sikeresen rögzítettük!",
              animate: true,
              backdrop: true,
              callback: function() {
                window.location.href = "cegadmin.php";
              },
          }); //bootbox siker
        } else {
          bootbox.alert({
              title: "Hiba",
              size: "small",
              message: "Probléma történt az adatok rögzítésénél!",
              animate: true,
              backdrop: true,
                }); // bootbox hiba
              } // response? ok else
            }); // done(function) end
        }
    }
    function amortizacio() {
      var dij = $('#amortizacio').val();
      var ervenyes = $('#amortizacio_ervenyesseg').val();
      if (dij == '' || ervenyes == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
        return;
      }
      $.post("ajax/ajax.uj_amort.php", {
        dij: dij,
        ervenyes: ervenyes,
      },
      "json").done(function( response ) {
        if (response != "ok") {
          bootbox.alert({
            title: "Siker",
            message: "Sikeresen rögzítettük.",
          });
        }
      });
    }
