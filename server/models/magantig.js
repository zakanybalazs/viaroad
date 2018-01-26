const pdfMake = require("../node_modules/pdfmake/build/pdfmake.min.js");
const pdfPrinter = require('../node_modules/pdfmake/src/printer.js');
const fs = require('fs');
const Fonts = require("../node_modules/pdfmake/build/vfs_fonts.js");

var maganTIG = function({text}) {
var fonts = {
      Roboto: {
          normal: 'fonts/Roboto-Regular.ttf',
          bold: 'fonts/Roboto-Medium.ttf',
          italics: 'fonts/Roboto-Italic.ttf',
          bolditalics: 'fonts/Roboto-MediumItalic.ttf'
      }
  };
var printer = new pdfPrinter(fonts);

var t = JSON.stringify({text});
var t = JSON.parse(t);
var t = (t.text);
console.log(t.auto_rendszam);
/* TODO : ki kell találni, hogyan lehetne választ küldeni a requestre */

function kikuldott(t) {
  var esc = [];
  esc.push([{text: 'A kiküldött ', alignment: 'center',colSpan:2, lineHeight : 2, fontSize: 16},{}]);
  esc.push([{text: 'Neve: '+ t.tulaj , fontSize: 9},{text: 'Lakcíme: ' + t.tulaj_lakcim, fontSize: 9}]);
  esc.push([{text: 'Adószáma: ' + t.tulaj_adoszam, fontSize: 9},{text: 'Szül.idő, hely: ' + t.tulaj_szul_ido + ", " +t.tulaj_szul_hely, fontSize: 9}]);
  esc.push([{text: 'Beosztása: '+ t.tulaj_beosztas , fontSize: 9},{text: 'Szolg. hely: ' + t.tulaj_szolg_hely, fontSize: 9}]);
  esc.push([{text: 'F.Rendszám: ' + t.auto_rendszam, fontSize: 9},{text: 'Márka, típus: ' + t.auto_marka + ", " +t.auto_tipus, fontSize: 9}]);
  esc.push([{text: 'Üzemanyag ár: '+ t.uzemanyag_ar + " Ft/l", fontSize: 9},{text: 'Norma: ' + t.auto_fogyasztas + "l/100Km", fontSize: 9}]);
  esc.push([{text: 'Löktérfogat: '+ t.auto_terfogat + " cm3", fontSize: 9},{text: 'Üzemanyag: ' + t.auto_uzemanyag, fontSize: 9}]);
  esc.push([{text: ' ', fontSize: 9},{text: ' ', fontSize: 9}]);

  return esc;
}
function utak(t) {
  var esc = [];
  esc.push([{text: 'Kiküldetési utasítás', alignment: 'center',colSpan:7,  fontSize: 16},{},{},{},{},{},{}]);
  esc.push([{text: 'VID'},{text: 'Dátum'},{text: 'Indulási hely'},{text: 'Érkezési hely'},{text: 'Záró km'},{text: 'Utazás célja / parter'},{text: 'Megtett km'}]);
for (var i = 0; i < t.utak.length; i++) {
  esc.push([
    {text: t.utak[i].ut_id, fontSize: 9},
    {text: t.utak[i].ut_datum, fontSize: 9},
    {text: t.utak[i].ut_honnan, fontSize: 9},
    {text: t.utak[i].ut_hova, fontSize: 9},
    {text: t.utak[i].ut_zaro_km, fontSize: 9},
    {text: t.utak[i].ut_cel, fontSize: 9},
    {text: t.utak[i].ut_km, fontSize: 9},
  ]);
}
    return esc;
}

var osszegzes = (t) => {
  var esc = [];
  esc.push([{
    text: t.uzemanyag_ar + " Ft / liter x " + t.auto_terfogat + " liter / 100 km x " + t.ossz_km + " km = "}
    ,{
    text: t.ossz_koltseg + " Ft", alignment: "right"
  }]);
  esc.push([{text: t.amortizacio + ".- Ft / km x " + t.ossz_km + " km = "}, {text: t.ossz_amortizacio + " Ft", alignment: "right"}]);
  return esc;
}

var ossz_km = `Összesen megtett km: ${t.ossz_km}`;
var osszesen_megtett = `Összesen:     ${t.global_osszeg} Ft`;
var alairas = `${t.tulaj} aláírása`;
var pdf = {
  content: [
    {
      text: `KIKÜLDETÉSI RENDELVÉNY (A hivatali, üzleti utazás költségtérítéséhez)\n`,
      style: 'header'
    },
    {
      text: t.ceg,
      style: "header"
    },
    {
      table: {
        body: [
                [
                {
                  table: {
                    widths: [250,250],
                    body:
                      kikuldott(text)
                  },
                  layout: 'noBorders'
                }
            ]
        ]
      }
    },
    {
      text: '\n',
      lineHeight: 1
    },
    {
        table: {
          widths: ['auto','auto','auto','auto','auto','auto','auto'],
          body:
            utak(text)
        }
    },
    {
      text: " ",
      lineHeight: 1
    },
    {
      text: ossz_km,
      alignment: 'right'
    },
    {
      text: "Költségelszámolás",
      lineHeight: 2
    },
    {
      table:
      {
        widths: ['*', 50],
        body: osszegzes(text)
      }
    },
    {
      text: osszesen_megtett, alignment: "right", lineHeight: 3
    },
    {
			alignment: 'justify',
			columns: [
				{
          width: 305,
					 table: {
             widths: [200],
             body: [
               [
                 {
                   table: {
                     widths: [200],
                     body: [
                       [{text: 'költségelszámolás végösszegét', alignment: "center", fontSize: 12}],
                       [{text: 'felvettem:', alignment: "center", lineHeight: 2}],
                       [{text: 'dátum:', alignment: "center", lineHeight: 2}]
                     ]
                   },
                   layout: 'noBorders'
                 }
               ],
               [
                 {
                   table: {
                     widths: [200],
                     body: [
                        [{text: alairas, alignment: "center"}]
                     ]
                   },
                   layout: "noBorders"
                 }
               ]
             ]
           }
				},
        {
          alignment: "right",
          table: {
            widths: [200],
            body: [
              [
                {
                  alignment: "right",
                  table: {
                    widths: [200],
                    body: [
                      [{text: 'Kiküldetést elrendelő bélyegzője', alignment: "center", fontSize: 12}],
                      [{text: 'és aláírása:', alignment: "center", lineHeight: 4.25}]
                    ]
                  },
                  layout: 'noBorders'
                }
              ],
              [
                {
                  alignment: "right",
                  table: {
                    widths: [200],
                    body: [
                       [{text: "aláírás, Ph", alignment: "center"}]
                    ]
                  },
                  layout: "noBorders"
                }
              ]
            ]
          }
        }
			]
		}
  ],
  styles: {
    header: {
      fontSize: 14,
      alignment: "center",
      lineHeight: 2
    },
    tableRow: {
      fontSize: 8
    }
  }
}
// pdfMake.createPdf(pdf).print();
var pdfDoc = printer.createPdfKitDocument(pdf);
var nev = "TIG-" + t.auto_rendszam + "-" + t.vege + ".pdf";
pdfDoc.pipe(fs.createWriteStream('./../uploads/elszamolasok/'+nev));
pdfDoc.end();
}
module.exports = {maganTIG}
