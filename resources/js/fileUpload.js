//Front end validation and pagecount for price etc before uploading (real calculations are done serverside)
$(document).ready(function(){
  var pagesFound=true;

  document.getElementById('f').oninput = async function() {
    var userPP=$("#pp").val()
    var totalPages=0;
    var totalPrice=0;
    var maxFileSize=40;
    var validFileType=true;
    var validFileSize=true;
    pagesFound=true;

    for (var i = 0; i < this.files.length; i++) {
      if (this.files[i].type != "application/pdf") {
          validFileType=false;
      } else if (this.files[i].size*0.000001>maxFileSize) {
          validFileSize=false;
      }else {
        var pdf = this.files[i];
        var details = await pdfDetails(pdf);
        if (pagesFound) {
          totalPages += details[0].Pages;
        }
      }
    }


    if (this.files.length >= 1) {
      if (!pagesFound) {
        console.log("Er kan helaas geen automatische kostenschatting worden gemaakt");
      } else if (validFileType && validFileSize) {
        console.log(totalPages);
        console.log("€", userPP*totalPages);
        $( "#verzendbtn" ).prop( "disabled", false );
      } else {
        console.log("Ongeldige file(s)");
        $( "#verzendbtn" ).prop( "disabled", true );
      }
    } else {
      console.log("selecteer een document");
      $( "#verzendbtn" ).prop( "disabled", true );
    }

  };

  function pdfDetails(pdfBlob) {
    return new Promise(done => {
      var reader = new FileReader();
      reader.onload = function() {
        var raw = reader.result;
        try {
          var Pages = raw.match(/\/Type[\s]*\/Page[^s]/g).length;
        } catch (e) {
          pagesFound=false;
        }
        // var Pages = raw.match(/\/Type[\s]*\/Page[^s]/g).length;
        var regex = /<xmp.*?:(.*?)>(.*?)</g;
        var meta = [{
          Pages
        }];
        var matches = regex.exec(raw);
        while (matches != null) {
          matches.shift();
          meta.push({
            [matches.shift()]: matches.shift()
          });
          matches = regex.exec(raw);
        }
        done(meta);
      };
      reader.readAsBinaryString(pdfBlob);
    });
  }
});
