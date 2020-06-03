@extends('layouts.app')

@push('script')
<script>
    $(document).ready(function(){
        // $('input[type="file"]').change(function(e){
        //     // var fileName = e.target.files[0].name;
        //
        //     for (var i = 0; i < e.target.files.length; i++) {
        //       if (e.target.files[i].type != "application/pdf") {
        //           console.log("Ongeldige file(s)");
        //       } else {
        //         // Count pages
        //         var reader = new FileReader();
        //         reader.readAsBinaryString(e.target.files[i]);
        //         reader.onloadend = function(){
        //             var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
        //             console.log('Number of Pages:',count);
        //             // console.log(e.target.files);
        //             console.log(reader.result);
        //         }
        //       }
        //     }

        // $('input[type="file"]').change(function(e){
        //     // var fileName = e.target.files[0].name;
        //
        //     for (var i = 0; i < e.target.files.length; i++) {
        //       if (e.target.files[i].type != "application/pdf") {
        //           console.log("Ongeldige file(s)");
        //       } else {
        //         // Count pages
        //         var reader = new FileReader();
        //         reader.readAsBinaryString(e.target.files[i]);
        //         reader.onloadend = function(){
        //             var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
        //             console.log('Number of Pages:',count);
        //             // console.log(e.target.files);
        //             console.log(reader.result);
        //         }
        //       }
        //     }
        //   });


            // if (e.target.files[0].type != "application/pdf") {
            //     console.log("Ongeldige file(s)");
            // } else {
            //   // Count pages
            //   var reader = new FileReader();
            //   reader.readAsBinaryString(e.target.files[0]);
            //   reader.onloadend = function(){
            //       var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
            //       console.log('Number of Pages:',count);
            //       console.log(e.target.files);
            //   }
            // }



            document.getElementById('f').oninput = async function() {
              var totalPages=0;
              for (var i = 0; i < this.files.length; i++) {
                if (this.files[i].type != "application/pdf") {
                    console.log("Ongeldige file(s)");
                } else {
                  var pdf = this.files[i];
                  var details = await pdfDetails(pdf);
                  totalPages += parseInt(details[0].Pages);
                  // console.log(parseInt(details[0].Pages));
                }
              }
              console.log(totalPages);
            };

            function pdfDetails(pdfBlob) {
              return new Promise(done => {
                var reader = new FileReader();
                reader.onload = function() {
                  var raw = reader.result;
                  var Pages = raw.match(/\/Type[\s]*\/Page[^s]/g).length;
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
</script>
@endpush

@section('content')
<div class="container">
  <span>Ik ga de opdracht verwerken: </span>{{$userThatPrintsName}}
  <br>
  <span>Ik ben de aanvrager: </span>{{$requesterName}}
  <br><br>
  <div class="form-group">
       <label class="col-sm-3 control-label">
           Attachment(s)
           (Attach multiple files.)
       </label>
       <div class="col-sm-9">
           <span class="btn btn-default btn-file">
               <input id="f" name="input2[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
           </span>
       </div>
   </div>

</div>
@endsection
