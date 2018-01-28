const pdfMake = require("../node_modules/pdfmake/build/pdfmake.min.js");
const pdfPrinter = require('../node_modules/pdfmake/src/printer.js');
const fs = require('fs');
const Fonts = require("../node_modules/pdfmake/build/vfs_fonts.js");

var cegesTIG = function({text}) {
  for (var i = 0; i < text.length; i++) {
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

function elso_header() {
  var esc = [];
  esc.push([{},{text: 'Teljesített Km',alignment: "center"},{text: 'Egységár', alignment:"left"}]);
  return esc;
}
function teljesites(t) {
  var esc = [];
  esc.push([{text: `${t[i].auto_rendszam} Rendszámú bérelt jármű`},{text: `${t[i].teljesitett_km} Km`},{text: ' * '},{text: `${t[i].egysegar} Ft/Km`},{text: '='},{text: `${t[i].osszeg} Ft`}]);
  return esc;
}
function netto(t) {
  var esc = [];
  esc.push([{text: "Nettó összesen:"},{},{text: `${t[i].osszeg} Ft`}]);
  return esc;
}
function afa(t) {
  var esc = [];
  esc.push([{text: "ÁFA 27%"},{},{text: `${t[i].afa} Ft`, alignment: "left"}]);
  return esc;
}
function global_osszeg(t) {
  var esc = [];
  esc.push([{text: "Teljesítés bruttó értéke:"},{},{text: `${t[i].global_osszeg} Ft`}]);
  return esc;
}


var col1 = 200;
var col2 = 150;
var col3 = 150;

var fejlec = `Alulírottak hivatalosan igazoljuk, hogy a(z) ${t[i].kolcsonbe_ado} ${t[i].kolcsonbe_ado_telep} a ${t[i].kolcsonbe_vevo} ${t[i].kolcsonbe_vevo_telep} számára a következő teljesítést végezte ${t[i].idoszak_kezdet} - ${t[i].idoszak_vege} időszakban:`;
var azaz = `${t[i].osszeg} HUF azaz ${t[i].osszeg_azaz} forint`;
var footer = `A közöttünk létrejött szerződés alapján a(z) ${t[i].kolcsonbe_ado} ${t[i].kolcsonbe_ado_telep} által végzett szolgáltatás határozott időre szóló elszámolásban történik, ezért a 2007. évi CXXVII. számú Áfa törvény 57-58 § alapján a(z)  ${t[i].kolcsonbe_ado} teljesítéséről kiállított számlán szereplő teljesítés időpontjának megegyezik a fizetési határidővel.`;
var kelt = `Kaposvár ${t[i].kelt}`;

var pdf = {
  content: [
    {
      text: `Tejlesítes igazolás\n`,
      style: 'header'
    },
    {
      text: fejlec,
      alignment: 'justify'
    },
    {
      text: "\n",
      lineHeight: 2
    },
    {
      table: {
        widths: [col1,col2,col3],
        body: [
          [{},{text: 'Teljesített Km',alignment: "center"},{text: 'Egységár', alignment:"left"}]
        ]
      },
      layout: "noBorders"
    },
    {
      table: {
        widths: ['auto','auto','auto','auto','auto','*'],
        headerRows: 1,
        body:
          teljesites(t)

      },
        layout: "headerLineOnly"
    },
    {
      text: "\n", lineHeight: 2
    },
    {
      table: {
        widths: [col1,col2,col3],
        body:
          netto(t)

      },
      layout: "noBorders"
    },
    {
      table: {
        widths: [col1,col2 - 10,col3],
        headerRows: 1,
        body:
          afa(t)
      },
        layout: "headerLineOnly"
    },
    {
      text: " "
    },
    {
    table: {
      widths: [col1,col2,col3],
      body:
        global_osszeg(t)

    },
    layout: "noBorders"
  },
  {
    text: " "
  },
  {
    text: "Összesen számlázható:"
  },
  {
    text: " "
  },
  {
    text: azaz
  },
  {
    text: "\n",
    lineHeight: 1
  },
  {
    text: footer
  },
  {
    text: "\n",
    lineHeight: 3
  },
  {
    text: "Fizetés módja: átutalás"
  },
  {
    columns: [
        {
          text: kelt
        },
        {
          text: " "
        },
        {
          text: '                                                                     ', decoration: 'underline', alignment: "center"
        }
    ]
  },
  {
    columns: [
      {},
      {},
      {
        text: "Cégszerű aláírás", alignment: "center"
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
var nev = "cegeselszamolasok/TIG-" + t[i].auto_rendszam + "-" + t[i].kolcsonbe_vevo + "-" + t[i].idoszak_vege + ".pdf";
pdfDoc.pipe(fs.createWriteStream('./../uploads/'+nev));
pdfDoc.end();
}
}
module.exports = {cegesTIG}
