// Front end validation and pagecount for price etc before uploading (real calculations are done serverside)
$(document).ready(function(){
  var pagesFound=true;

  $('#fileBtnHidden').change(function(){
      var files = $(this)[0].files;
      if (files.length==1) {
        $('.fileUpload').val(files.length + " bestand geselecteerd").css('background-image', 'none');
      } else if (files.length==0){
        $('.fileUpload').val("").css('background-image', 'url(https://image.flaticon.com/icons/svg/54/54565.svg)');
      } else {
        $('.fileUpload').val(files.length + " bestanden geselecteerd").css('background-image', 'none');
      }

  });

  // Empty input when user presses "back".
  $("#fileBtnHidden").replaceWith($("#fileBtnHidden").val('').clone(true));

  document.getElementById('fileBtnHidden').oninput = async function() {
    var userPP=$("#pp").val();
    var userPPRounded=parseFloat(userPP).toFixed(2)
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
        $("#calculations").html("Wij kunnen helaas geen automatische kostenschatting maken");
      } else if (validFileType && validFileSize) {
        console.log(totalPages);
        console.log("€", userPP*totalPages);
        $("#calculations").html(totalPages + " pagina's x " + userPPRounded + " per pagina");
        $("#priceTotal").html("€" + (userPP*totalPages).toFixed(2));
        $( "#verzendbtn" ).prop( "disabled", false );
      } else {
        console.log("Ongeldige file(s)");
        $("#calculations").html("Ongeldige file, te groot (max 40mb) of verkeerd formaat (alleen pdf).");
        $( "#verzendbtn" ).prop( "disabled", true );
      }
    } else {
      console.log("selecteer een document");
      $( "#verzendbtn" ).prop( "disabled", true );
      $("#calculations").html(" ");
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
