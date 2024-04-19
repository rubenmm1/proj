const canvas = document.querySelector("#firma_cliente");
var empty = true; //if its signed

if (canvas) {
  function isCanvasEmpty() {
    var ctx = canvas.getContext("2d");
    var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

    var pixels = imageData.data;
    for (var i = 0; i < pixels.length; i++) {
      if (pixels[i] !== 0) {
        return false; // Canvas is not empty
      }
    }
    return true; // Canvas is empty
  }

  document.addEventListener("mousemove", function () {
    empty = isCanvasEmpty();
    if (empty) {
      document.getElementById("btn-guardar").style.display = "none";
    } else {
      document.getElementById("btn-guardar").style.removeProperty("display");
    }
  });
}

$(document).ready(function () {
  const COLOR_PINCEL = "#1B2F65";
  const GROSOR = 2;

  // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
  window.requestAnimFrame = (function (callback) {
    return (
      window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      window.msRequestAnimaitonFrame ||
      function (callback) {
        window.setTimeout(callback, 1000 / 60);
        // Retrasa la ejecucion de la funcion para mejorar la experiencia
      }
    );
  })();

  // Traemos el canvas mediante el id del elemento html
  if (canvas) {
    var ctx = canvas.getContext("2d");
    // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
    //   var drawImage = document.getElementById("draw-image");
    var clearBtn = document.getElementById("btnLimpiar");
    clearBtn.addEventListener(
      "click",
      function (e) {
        // Definimos que pasa cuando el boton draw-clearBtn es pulsado
        clearCanvas();

        document.getElementById("btn-guardar").style.display = "none";
        // drawImage.setAttribute("src", "");
      },
      false
    );

    // Activamos MouseEvent para nuestra pagina
    var drawing = false;
    var mousePos = { x: 0, y: 0 };
    var lastPos = mousePos;
    canvas.addEventListener(
      "mousedown",
      function (e) {
        /*
      Mas alla de solo llamar a una funcion, usamos function (e){...}
      para mas versatilidad cuando ocurre un evento
    */
        //   var tint = document.getElementById("color");
        //   var punta = document.getElementById("puntero");
        drawing = true;
        empty = false;
        lastPos = getMousePos(canvas, e);
      },
      false
    );
    canvas.addEventListener(
      "mouseup",
      function (e) {
        drawing = false;
      },
      false
    );
    canvas.addEventListener(
      "mousemove",
      function (e) {
        mousePos = getMousePos(canvas, e);
      },
      false
    );

    // Activamos touchEvent para nuestra pagina
    canvas.addEventListener(
      "touchstart",
      function (e) {
        mousePos = getTouchPos(canvas, e);
        e.preventDefault();
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousedown", {
          clientX: touch.clientX,
          clientY: touch.clientY,
        });
        canvas.dispatchEvent(mouseEvent);
      },
      { passive: true }
    );

    canvas.addEventListener(
      "touchend",
      function (e) {
        e.preventDefault(); // Prevent scrolling when touching the canvas
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
      },
      { passive: true }
    );
    canvas.addEventListener(
      "touchleave",
      function (e) {
        // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
        e.preventDefault(); // Prevent scrolling when touching the canvas
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
      },
      false
    );
    canvas.addEventListener(
      "touchmove",
      function (e) {
        e.preventDefault(); // Prevent scrolling when touching the canvas
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousemove", {
          clientX: touch.clientX,
          clientY: touch.clientY,
        });
        canvas.dispatchEvent(mouseEvent);
      },
      false
    );
  } else {
    empty = true;
  }

  // Get the position of the mouse relative to the canvas
  function getMousePos(canvasDom, mouseEvent) {
    var rect = canvasDom.getBoundingClientRect();
    /*
      Devuelve el tamaño de un elemento y su posición relativa respecto
      a la ventana de visualización (viewport).
    */
    return {
      x: mouseEvent.clientX - rect.left,
      y: mouseEvent.clientY - rect.top,
    };
  }

  // Get the position of a touch relative to the canvas
  function getTouchPos(canvasDom, touchEvent) {
    var rect = canvasDom.getBoundingClientRect();
    /*
      Devuelve el tamaño de un elemento y su posición relativa respecto
      a la ventana de visualización (viewport).
    */
    return {
      x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
      y: touchEvent.touches[0].clientY - rect.top,
    };
  }

  // Draw to the canvas
  function renderCanvas() {
    if (drawing) {
      var tint = document.getElementById("color");
      var punta = document.getElementById("puntero");
      ctx.strokeStyle = COLOR_PINCEL;
      ctx.beginPath();
      ctx.moveTo(lastPos.x, lastPos.y);
      ctx.lineTo(mousePos.x, mousePos.y);
      ctx.lineWidth = GROSOR;
      ctx.stroke();
      ctx.closePath();
      lastPos = mousePos;
    }
  }

  function clearCanvas() {
    canvas.width = canvas.width;
    empty = true;
  }

  // Allow for animation
  (function drawLoop() {
    requestAnimFrame(drawLoop);
    renderCanvas();
  })();
});

function guardarFirma(cod_rev) {
  if (empty) {
    return;
  }

  let data = {
    url: canvas.toDataURL("image/png"),
    cod_rev: cod_rev,
  };

  $.ajax({
    type: "POST",
    url: "../admin3770xyp/save_signature.php",
    data: JSON.stringify(data),
    success: function (response) {},
  });
}
