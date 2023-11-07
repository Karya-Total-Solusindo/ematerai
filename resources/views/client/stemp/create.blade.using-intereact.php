
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
{{-- <script src="//mozilla.github.io/pdf.js/build/pdf.mjs" type="module"></script> --}}
{{-- <script src="{{ asset("assets/js/plugin/pdf/pdf.js") }}" type="module"></script> --}}
<script src="{{ asset("assets/js/plugins/pdf/pdf.js") }}" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.2.9/interact.min.js'></script>
<script>
  var  url = {};
    $('#resume').on('change', function (e) {
    e.preventDefault();

    var reader = new FileReader(),
        file = $('#file')[0];

    if (!file.files.length) {
        alert('no file uploaded');
        return false;
    }

    reader.onload = function () {
        var data = reader.result,
            base64 = data.replace(/^[^,]*,/, ''),
            info = {
                resume: base64 //either leave this `basae64` or make it `data` if you want to leave the `data:application/pdf;base64,` at the start
            };
            console.log('render');
            renderPage(1);
        // $.ajax({
        //     url: "http://example.com",
        //     type: "POST",
        //     dataType: "JSON",
        //     data: info,
        //     success: function (response) {}
        // });
    };

    reader.readAsDataURL(file.files[0]);
    console.log(reader);
});


// function readFileAsync(file) {
//     return new Promise((resolve, reject) => {
//       let reader = new FileReader();
//       reader.onload = () => {
//         resolve(reader.result);
//       };
//       reader.onerror = reject;
//       reader.readAsArrayBuffer(file);
//     });
//   }
</script>


<script type="module">
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  // var  url = '{{ asset('/docs/file.pdf') }}';
 
 // Loaded via <script> tag, create shortcut to access PDF.js exports.
  var { pdfjsLib } = globalThis;

  // The workerSrc property shall be specified.
  pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("assets/js/plugins/pdf/pdf.worker.js") }}';

  var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 1,
      canvas = document.getElementById('the-canvas'),
      ctx = canvas.getContext('2d');

  /**
   * Get page info from document, resize canvas accordingly, and render page.
   * @param num Page number.
   */
  function renderPage(num) {
    pageRendering = true;
    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
      var viewport = page.getViewport({scale: scale});
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      var renderTask = page.render(renderContext);

      // Wait for rendering to finish
      renderTask.promise.then(function() {
        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }
      });
    });

    // Update page counters
    document.getElementById('page_num').textContent = num;
  }

  /**
   * If another page rendering in progress, waits until the rendering is
   * finised. Otherwise, executes rendering immediately.
   */
  function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
  }

  /**
   * Displays previous page.
   */
  function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }
  document.getElementById('prev').addEventListener('click', onPrevPage);

  /**
   * Displays next page.
   */
  function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  }
  document.getElementById('next').addEventListener('click', onNextPage);

  const fileInput = document.getElementById('file');

// This is for storing the base64 strings
let myFiles = {}
// if you expect files by default, make this disabled
// we will wait until the last file being processed
let isFilesReady = true;
var w = 0;
var h = 0;

fileInput.addEventListener('change', async (event) => {
  // clean up earliest items
  myFiles = {}
  // set state of files to false until each of them is processed
  isFilesReady = false

  // this is to get the input name attribute, in our case it will yield as "picture"
  // I'm doing this because I want you to use this code dynamically
  // so if you change the input name, the result also going to effect
  const inputKey = fileInput.getAttribute('name')
  var files = event.srcElement.files;

  const filePromises = Object.entries(files).map(item => {
    return new Promise((resolve, reject) => {
      const [index, file] = item
      const reader = new FileReader();
      reader.readAsBinaryString(file);

      reader.onload = function(event) {
        // if it's multiple upload field then set the object key as picture[0], picture[1]
        // otherwise just use picture
        const fileKey = `${inputKey}${files.length > 1 ? `[${index}]` : ''}`
        // Convert Base64 to data URI
        // Assign it to your object
        myFiles[fileKey] = `data:${file.type};base64,${btoa(event.target.result)}`

        pdfjsLib.getDocument(myFiles[fileKey]).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages; 
        var w = $('#the-canvas').width();
        var h = $('#the-canvas').height();
        // Initial/first page rendering
        renderPage(pageNum);
      });

        resolve()
      };
      reader.onerror = function() {
        console.log("can't read the file");
        reject()
      };
    })
  })

  Promise.all(filePromises)
    .then(() => {
      console.log('ready to submit')
      isFilesReady = true
    })
    .catch((error) => {
      console.log(error)
      console.log('something wrong happened')
    })
})

const formElement = document.getElementById('formcarryForm')

const handleForm = async (event) => {
  event.preventDefault();

  if(!isFilesReady){
    console.log('files still getting processed')
	return
  }
}

// formElement.addEventListener('submit', handleForm)
  /**
   * Asynchronously downloads PDF.
   */
  // pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
  //   pdfDoc = pdfDoc_;
  //   document.getElementById('page_count').textContent = pdfDoc.numPages;

  //   // Initial/first page rendering
  //   renderPage(pageNum);
  // });


  window.dragMoveListener = dragMoveListener;
    
    interact('.ematerai')
      .draggable({
        onmove: dragMoveListener,
        inertia: true,
        autoScroll: false,
        restrict: {
          elementRect: {
            top: 0,
            left: 0,
            bottom: 1,
            right: 1
          }
        }
      })
    //   .resizable({
    //     onmove: resizeMoveListener,
    //     inertia: true,
    //     edges: {
    //       left: false,
    //       right: false,
    //       bottom: false,
    //       top: false
    //     }
    //   })
    
    const boxes = document.getElementsByClassName("ematerai");
    
    function dragMoveListener(event) {
      console.log(event);
     
       
      const self = {
        x: (parseFloat(event.target.getAttribute('data-x')) || 0) + event.dx,
        y: (parseFloat(event.target.getAttribute('data-y')) || 0) + event.dy,
        width: event.target.offsetWidth,
        height: event.target.offsetHeight
      };

      // document.getElementById('test-result').value = event.velocityX+' - '+event.velocityY+' '+event.x0+' - '+event.y0;
    
      if (!collides(self, event)) {
        var target = event.target;
        var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
        var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
        target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
    
        computeSignerBoxPosition(event.target);
      }
    }
    
    function resizeMoveListener(event) {
    
      // const self = {
      //   x: (parseFloat(event.target.getAttribute('data-x')) || 0) + event.deltaRect.left,
      //   y: (parseFloat(event.target.getAttribute('data-y')) || 0) + event.deltaRect.top,
      //   width: event.rect.width,
      //   height: event.rect.height
      // }
    
      // if (!collides(self, event)) {
      //   var target = event.target;
      //   var x = (parseFloat(target.getAttribute('data-x')) || 0);
      //   var y = (parseFloat(target.getAttribute('data-y')) || 0);
      //   x += event.deltaRect.left;
      //   y += event.deltaRect.top;
    
      //   target.style.width = event.rect.width + 'px';
      //   target.style.height = event.rect.height + 'px';
      //   target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px,' + y + 'px)';
      //   target.setAttribute('data-x', x);
      //   target.setAttribute('data-y', y);
    
      //   computeSignerBoxPosition(event.target);
      // }
    }
    
    function collides(self, event, tag = "") {
      var w = $('#the-canvas').width();
      var h = $('#the-canvas').height();  
        console.log(event.target);
      for (const box of boxes) {
        if (box < event.target) {
          continue;
        }
        
        const other = {
          x: (parseFloat(box.getAttribute('data-x')) || 0),
          y: (parseFloat(box.getAttribute('data-y')) || 0),
          width: box.offsetWidth,
          height: box.offsetHeight
        }
    
        const collisionX = Math.max(self.x + self.width, other.x + other.width) - Math.min(self.x, other.x) < self.width + other.width;
        const collisionY = Math.max(self.y + self.height, other.y + other.height) - Math.min(self.y, other.y) < self.height + other.height;
        let visURX = (self.x + self.width-7); // visual under rigth X 
        let visURY = (self.y + self.height-7); // visual under height Y 
        console.log(w,self.x,h,self.y);
        console.log('W '+ w,self.width, 'self.x '+self.x+' self.y '+self.y);
        
        if(visURX >= w || self.x<0){
            console.log('rigth stop',visURX, w,self.x,self.y);
            return true;
        }
        if(visURY >= h || self.y <0 ){
            console.log('bottom stop','visURY','h','self.x','self.y');
            console.log('bottom stop',visURY,h,self.x,self.y);
            return true;
        }

        if (collisionX && collisionY) {
        //   return true;
        }
      }
      return false;
    }
    
    function computeSignerBoxPosition(signer) {
      var $signatureBox = $(signer);
      var sbDataX = parseFloat($signatureBox.attr('data-x'));
      var sbDataY = parseFloat($signatureBox.attr('data-y'));
      var sbOuterWidth = $signatureBox.outerWidth();
      var sbOuterHeight = $signatureBox.outerHeight();

      var w = $('#the-canvas').width();
      var h = $('#the-canvas').height();
    
      var top = sbDataX / w;
      var left = sbDataY / h;
      var width = sbOuterWidth / w;
      var height = sbOuterHeight / h;
      
    //   console.log(w,h,top,left,sbDataY);
    //   if(top<0 ){
    //     console.log('stop',w,top);
    //     return false;
    //   }
      document.getElementById("widthValue").value = sbDataX; // sbDataX/w;//width;
      document.getElementById("heightValue").value = sbDataY;//height;
      document.getElementById("coorX").value = top;// top;
      document.getElementById("coorY").value = left;//left;
      document.getElementById("dotLX").style.transform = 'translate(' + sbDataX + 'px,' + sbDataY + 'px)';
      document.getElementById("dotLY").style.transform = 'translate(' + sbDataX + 'px,' + sbDataY + 'px)';
      document.getElementById("dotUX").style.transform = 'translate(' + sbDataX + 'px,' + sbDataY + 'px)';
      document.getElementById("dotUY").style.transform = 'translate(' + sbDataX + 'px,' + sbDataY + 'px)';
      
    }
// const position = { x: 0, y: 0 }

</script>
<style>
  #the-canvas{
    border: solid gray;
    /* width: 100%; */
  }
  .ematerai{
    background-image: url({{asset('assets/img/meterai.png') }});
    background-size: cover;
    /* height: 81.766px; 
    width: 81.766px; */
    margin: 0px;
    color:red;
    padding: 20px 0px;
    border: solid gray;
    transform: translate(0px, 0px);
    position: absolute;
    opacity: 0.7;
    touch-action: none;
    aspect-ratio: 1;
    border-style: dotted;
    background-repeat: no-repeat;
    font-size: 9px;
    text-align: center;
  }
  /* .ematerai{
    block-size: auto;
    width: 11%;
    border-radius: 3px;
    border: .1% dotted #000;
    opacity: .7;
    color: #000;
    text-align: center;
    font-size: 12px;
    font-family: sans-serif;
    position: absolute;
    touch-action: none;
    aspect-ratio: 1
  } */
  #corX, #corY{
    width: 100px;
  }
</style>

<div class="card">
    <div class="card-header pb-0">
      <input type="file" class="form-control" name="file" id="file" accept=".pdf"/><br>
      <button class="btn " id="prev">Previous</button>
      <button  class="btn " id="next">Next</button>
      <span style="position: fixed;z-index: 999999; right:100px; bottom:40px;">
        <input type="text" id="corX" width="20">
        <input type="text" id="corY">
        <button id="send">Submit</button>
        {{-- <div id="signer-1" class="signer-box" data-x="379" data-y="279" style="position: absolute; transform: translate(379px, 279px); width: 148px; height: 90px; --content:&quot;Firma número 1&quot; ;"></div> --}}
        {{-- <div id="signer-2" class="signer-box" data-x="17" data-y="30" style="position: absolute; transform: translate(17px, 30px); width: 238px; height: 121px; --content:&quot;Firma número 2&quot; ;"></div> --}}
    
        <div id="values">
          <label>X:
               <input id="coorX" readonly>
               </label>
          <label>Y:
               <input id="coorY" readonly>
               </label>
          <label>Width:
               <input id="widthValue" readonly>
               </label>
          <label>Height:
               <input id="heightValue" readonly>
               </label>
        </div>
      </span>
      &nbsp; &nbsp;
      <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
    </div>
  <div class="card-body">
    <div class="row">
      <div style="col-6">
        <span id="dotLX" class="dot" style="position:absolute; color:red; z-index:9999999;">LX</span>
        <span id="dotLY" class="dot" style="position:absolute; color:red; z-index:9999999;">LY</span>
        <span id="dotUX" class="dot" style="position:absolute; color:red; z-index:9999999;">UX</span>
        <span id="dotUY" class="dot" style="position:absolute; color:red; z-index:9999999;">UY</span>
        <div draggable="true" class="ematerai" data-x="100" data-y="100" style="">Ematerai Pointing</div>
        <canvas id="the-canvas" dir="ltr"></canvas>
        <div class="card col-3" style="position: fixed;
        z-index: 99999 !important;
        right: 5px !important;
        bottom: 100px;">
           <input type="text" class="form-control" name="dokumen_height" placeholder="dokumen_height" id="dokumen_height">
           <input type="text" class="form-control" name="dokumen_width" placeholder="dokumen_width" id="dokumen_width">
           <input type="text" class="form-control" name="dokumen_page" placeholder="dokumen_page" id="dokumen_page">
        </div>
        <textarea name="test-result" id="test-result" cols="5" rows="5" style="position: fixed"></textarea>
  
      </div>
    </div>
  </div>
</div>

<script>
var sendBtn =  document.getElementById('send');
sendBtn.addEventListener('click', (e)=>{
 var cX = document.getElementById('corX').value;
 var cY = document.getElementById('corY').value;
 console.log(cX,cY);
});

</script>