<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>JS Bin</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.1/es6-shim.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://frontenddeveloping.github.io/pdfjs-dist/build/pdf.js"></script>
  <script src="https://frontenddeveloping.github.io/pdfjs-dist/build/pdf.worker.js"></script>
</head>
<body>
  
  <div class="container">
    <p>Select pdf file to check number of pages and links inside.</>
    <form>
      <input type=file id=uploader>
    </form>
  </div>
  
<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">PDF info</h4>
      </div>
      <div class="modal-body">
        <p>Pages: <span class="pdf-pages">in progress</span></p>
        <p>Links: <span class="pdf-links">in progress</span></p>
      </div>
    </div>
  </div>
</div>

<script id="jsbin-javascript">
function processAnnotations(annotationsData) {
  for (var i = 0; i < annotationsData.length; i++) {
    var data = annotationsData[i];
    if (!data) {
      continue;
    }
    if (data.subtype === 'Link') {
      linkCounter++;
    }
  }
}
function readPDFFile(pdf) {
  PDFJS.getDocument({data: pdf}).then(function(pdf) {
    $pdfPages.text(pdf.pdfInfo.numPages);
    var pagesPromisesArray = new Array(pdf.pdfInfo.numPages+1).join('0').split('').map(function(value, index) {
      return pdf.getPage(++index); 
    });
    
    Promise.all(pagesPromisesArray).then(function(pages){
      var pagesAnnotationsPromisesArray = pages.map(function(page) {
        return page.getAnnotations();
      });
      Promise.all(pagesAnnotationsPromisesArray).then(function(annotationsDataArray) {
        annotationsDataArray.forEach(function(pageAnnotationsData) {
          processAnnotations(pageAnnotationsData);
        });
        $pdfLinks.text(linkCounter);
        $modal.modal('show')
      });
    });
  });
}
var linkCounter;
var $modal = $('.modal').modal('hide');
var $pdfPages = $modal.find('.pdf-pages');
var $pdfLinks = $modal.find('.pdf-links');
window.onload = function() {
  document.getElementById('uploader').addEventListener('change', function() {
    var file = this.files[0];
    linkCounter = 0;
    if (!file) {
      return;
    }
    var fileReader = new FileReader();
    fileReader.onload = function (e) {
      readPDFFile(new Uint8Array(e.target.result));
    };
    fileReader.readAsArrayBuffer(file);
  });
};
</script>

</body>
</html>