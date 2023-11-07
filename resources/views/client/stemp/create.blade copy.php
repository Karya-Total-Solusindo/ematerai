
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<div class="pdf-toolbar">
    <div id="navigation_controls">
       <button class="pdf-toolbar-button" id="previous">Previous</button>
       <input class="pdf-input" id="current_page" value="1" type="number"/>
       <button class="pdf-toolbar-button" id="next">Next</button>
     </div>
 
    <div id="zoom_controls">  
      <button class="pdf-toolbar-button" id="zoom_in">+</button>
      <button class="pdf-toolbar-button" id="zoom_out">-</button>
     </div>
 </div>

 <div id = "canvas_container">
    <canvas id="pdf_renderer" style="border: solid;"> </canvas>
 </div>

 <script>

var defaultState = {
    pdf: null,
    currentPage: 1,
    zoom: 1
}

// GET OUR PDF FILE
pdfjsLib.getDocument('{{ asset('/docs/file.pdf') }}').then((pdf) => {

    defaultState.pdf = pdf;
    render();

});

// RENDER PDF DOCUMENT
function render() {
    defaultState.pdf.getPage(defaultState.currentPage).then((page) => {

        var canvas = document.getElementById("pdf_renderer");
        var ctx = canvas.getContext('2d');

        var viewport = page.getViewport(defaultState.zoom);

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        page.render({
            canvasContext: ctx,
            viewport: viewport
        });
    });
}

// FUNCTION GO TO PREVIOUS SITE
document.getElementById('previous').addEventListener('click', (e) => {
    if (defaultState.pdf == null || defaultState.currentPage == 1)
        return;
    defaultState.currentPage -= 1;
    document.getElementById("current_page").value = defaultState.currentPage;
    render();
});

// FUNCTION GO TO PREVIOUS NEXT
document.getElementById('next').addEventListener('click', (e) => {
    if (defaultState.pdf == null || defaultState.currentPage > defaultState.pdf._pdfInfo.numPages)
        return;
    defaultState.currentPage += 1;
    document.getElementById("current_page").value = defaultState.currentPage;
    render();
});

// FUNCTION GO TO CUSTUM SITE
document.getElementById('current_page').addEventListener('keypress', (e) => {
    if (defaultState.pdf == null) return;

    var code = (e.keyCode ? e.keyCode : e.which);

    if (code == 13) { // ON CLICK ENTER GO TO SITE TYPED IN TEXT-BOX
        var desiredPage =
            document.getElementById('current_page').valueAsNumber;

        if (desiredPage >= 1 && desiredPage <= defaultState.pdf._pdfInfo.numPages) {
            defaultState.currentPage = desiredPage;
            document.getElementById("current_page").value = desiredPage;
            render();
        }
    }
});

// FUNCTION FOR ZOOM IN
document.getElementById('zoom_in').addEventListener('click', (e) => {
    if (defaultState.pdf == null) return;
    defaultState.zoom += 0.5;
    render();
});

// FUNCTION FOR ZOOM OUT
document.getElementById('zoom_out').addEventListener('click', (e) => {
    if (defaultState.pdf == null) return;
    defaultState.zoom -= 0.5;
    render();
});
 </script>



{{-- <script src="//mozilla.github.io/pdf.js/build/pdf.mjs" type="module"></script> --}}
{{-- <script src="{{ asset("assets/js/plugin/pdf/pdf.js") }}" type="module"></script> --}}
<script src="{{ asset("assets/js/plugins/pdf/pdf.js") }}" type="module"></script>

<script type="module">
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  var url = 'test.pdf';

  // Loaded via <script> tag, create shortcut to access PDF.js exports.
  var { pdfjsLib } = globalThis;

  // The workerSrc property shall be specified.
  pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("assets/js/plugins/pdf/pdf.worker.js") }}';

  var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 0.8,
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

  /**
   * Asynchronously downloads PDF.
   */
  pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Initial/first page rendering
    renderPage(pageNum);
  });
</script>

<h1>PDF.js Previous/Next example</h1>

<p>Please use <a href="https://mozilla.github.io/pdf.js/getting_started/#download"><i>official releases</i></a> in production environments.</p>

<div>
  <button id="prev">Previous</button>
  <button id="next">Next</button>
  &nbsp; &nbsp;
  <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
</div>

<canvas id="the-canvas"></canvas>