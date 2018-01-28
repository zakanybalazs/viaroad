const pdfMake = require("../node_modules/pdfmake/build/pdfmake.min.js");
const pdfPrinter = require('../node_modules/pdfmake/src/printer.js');
const fs = require('fs');
const Fonts = require("../node_modules/pdfmake/build/vfs_fonts.js");

var kartyasTIG = function({text}) {
var fonts = {
      Roboto: {
          normal: 'fonts/Roboto-Regular.ttf',
          bold: 'fonts/Roboto-Medium.ttf',
          italics: 'fonts/Roboto-Italic.ttf',
          bolditalics: 'fonts/Roboto-MediumItalic.ttf'
      }
  };
var te = {text};
for (var global_i = 0; global_i < te.text.length; global_i++) {
var printer = new pdfPrinter(fonts);

var t = JSON.stringify({text});
var t = JSON.parse(t);
var t = t.text;
var t = t[global_i];
console.log("t");
// console.log(t);


/* TODO : ki kell találni, hogyan lehetne választ küldeni a requestre */

function kikuldott(t) {
  var esc = [];
  esc.push([{text: 'A kiküldött ', alignment: 'center',colSpan:2, lineHeight : 2, fontSize: 16},{}]);
  esc.push([{text: 'Neve: '+ t.tulaj , fontSize: 12},{text: 'Lakcíme: ' + t.tulaj_lakcim, fontSize: 12}]);
  esc.push([{text: 'Adószáma: ' + t.tulaj_adoszam, fontSize: 12},{text: 'Szül.idő, hely: ' + t.tulaj_szul_ido + ", " +t.tulaj_szul_hely, fontSize: 12}]);
  esc.push([{text: 'Beosztása: '+ t.tulaj_beosztas , fontSize: 12},{text: 'Szolg. hely: ' + t.tulaj_szolg_hely, fontSize: 12}]);
  esc.push([{text: 'F.Rendszám: ' + t.auto_rendszam, fontSize: 12},{text: 'Márka, típus: ' + t.auto_marka + ", " +t.auto_tipus, fontSize: 12}]);
  esc.push([{text: 'Löktérfogat: '+ t.auto_terfogat + " cm3", fontSize: 12},{text: 'Norma: ' + t.auto_fogyasztas + "l/100Km", fontSize: 12}]);
  esc.push([{text: ' ', fontSize: 12},{text: 'Üzemanyag: ' + t.auto_uzemanyag, fontSize: 12}]);
  esc.push([{text: ' ', fontSize: 12},{text: ' ', fontSize: 12}]);

  return esc;
}
function utak(t) {
  var esc = [];

  esc.push([{text: 'Kiküldetési utasítás', alignment: 'center',colSpan:10,  fontSize: 16},{},{},{},{},{},{},{},{},{}]);
  esc.push([{text: 'VID'},{text: 'Dátum'},{text: 'Indulási hely'},{text: 'Érkezési hely'},{text: 'Induló km'},{text: 'Érkező km'},{text: 'Megtett km'},{text: 'Cél'},{text: 'Üzemanyag költség'},{text: 'Amortizációs díj'}]);
for (var i = 0; i < t.utak.length; i++) {
  esc.push([
    {text: t.utak[i].ut_id, fontSize: 9},
    {text: t.utak[i].ut_datum, fontSize: 9},
    {text: t.utak[i].ut_honnan, fontSize: 9},
    {text: t.utak[i].ut_hova, fontSize: 9},
    {text: t.utak[i].ut_kezdo_km, fontSize: 9},
    {text: t.utak[i].ut_zaro_km, fontSize: 9},
    {text: t.utak[i].ut_km, fontSize: 9},
    {text: t.utak[i].ut_cel, fontSize: 9},
    {text: t.utak[i].ut_koltseg, fontSize: 9},
    {text: t.utak[i].ut_amortizacio, fontSize: 9},
  ]);
}
    return esc;
}

var kilometerek = (t) => {
  var esc = [];
  var esc2 = [];
  esc.push([{text: `Üzleti kilométer: ${t.ossz_km_uzleti} km`}]);
  esc.push([{text: `Magán kilométer: ${t.ossz_km_magan} km`}]);
  esc.push([{text: `Összesen: ${t.ossz_km} km`}]);
  esc2.push(esc);
  return esc2;
}
var koltsegek = (t) => {
  var esc = [];
  var esc2 = [];
  esc.push([{text: `Összes üzemanyagköltség: ${t.ossz_km} Ft`}]);
  esc.push([{text: `Üzleti üzemanyagköltség összesen: ${t.ossz_koltseg_uzleti} Ft`}]);
  esc.push([{text: `Magán üzemanyagköltség összesen: ${t.ossz_koltseg_magan} Ft`}]);
  esc.push([{text: `Amortizációs költség összesen: ${t.ossz_amortizacio} Ft`}]);
  esc2.push(esc);
  return esc2;
}

var elso_nap = `Első nap kilométer: ${t.elso_nap}`;
var utolso_nap = `Utolsó nap kilométer: ${t.utolso_nap}`;
var ossz_km = `Összesen: ${t.ossz_koltseg_uzleti} Ft - ${t.ossz_amortizacio} Ft`;
var brutto_szamlazando = `Bruttó számlázandó:     ${t.ossz_koltseg_magan} azaz ${t.ossz_koltseg_magan_azaz} Ft`;
var kelt = `Dátum: ${t.kelt}`;
var pdf = {
  pageOrientation: 'landscape',
  content: [
    {
      text: `ÚTNYILVÁNTARTÁS `,
      style: 'header'
    },
    {
      text: t.ceg,
      style: "header"
    },
    {
      columns: [
        {
          width: 110, text: ''
        },
        {
      table: {
        body: [
                [
                {
                  table: {
                    widths: [250,250],
                    body:
                      kikuldott(t)
                  },
                  layout: 'noBorders'
                }
            ]
          ]
        }
      },
      {
        width: '*', text: ''
      }
    ]
    },
    {
      text: '\n',
      lineHeight: 1
    },
    {
      columns : [
        {
          text: elso_nap
        },
        {

        },
        {
          text: utolso_nap
        }
      ]
    },
    {
      text: '\n'
    },
    {
        table: {
          widths: ['auto','auto','auto','auto','auto','auto','auto','auto','auto','auto'],
          body:
            utak(t)
        }
    },
    {
      columns: [
        {

        },
        {
          text: ossz_km,
          alignment: 'center'
        }
      ]
    },
    {
      text: "\n"
    },
    {
      columns: [
        {
          table:
            {
              widths: ['*'],
              body: [
                [
                  {
                  table: {
                      body:
                      [
                         kilometerek(t)
                      ]
                    },
                    layout: 'noBorders'
                  }
              ]
              ]
            }
        },
        {
          width: 200,
          text: " "
        },
        {
          table:
            {
              widths: ['*'],
              body: [
                [
                  {
                  table: {
                      body:
                      [
                         koltsegek(t)
                      ]
                    },
                    layout: 'noBorders'
                  }
              ]
              ]
            }
        },
        {
          width: 50,
          text: " "
        }
      ]
    },
    {
      text: " ", lineHeight: 2
    },
    {
      text: brutto_szamlazando, lineHeight: 3
    },
    {
      columns: [
        {
          text: "                                          ", decoration: 'underline', alignment: 'center'
        },
        {},
        {
            text: "                                         ", decoration: 'underline', alignment: "center"
        }
      ]
		},
    {
    columns: [
      {
          text: "Kártyabirtokos", alignment: "center", lineHeight: 3
      },
      {},
      {
          text: "Utalványozó", alignment: "center"
      }
    ]
  },
  {
  columns: [
    {
        text: kelt,decoration: 'underline', alignment: "center"
    },
    {},
    {
    }
  ]
  }
  ],
  styles: {
    header: {
      fontSize: 14,
      alignment: "center",
      lineHeight: 1
    },
    tableRow: {
      fontSize: 8
    }
  }
}
// pdfMake.createPdf(pdf).print();
var pdfDoc = printer.createPdfKitDocument(pdf);
var nev = "TIG-" + t.auto_kartyaszam + "-" + t.utolso_nap + ".pdf";
pdfDoc.pipe(fs.createWriteStream('./../uploads/elszamolasok/'+nev));
pdfDoc.end();
}
}
module.exports = {kartyasTIG}
