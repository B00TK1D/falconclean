<?php
  include_once($_SERVER["DOCUMENT_ROOT"] . "/functs.php");

  checkAdmin();

  $machines = readObject("machines");

  $takenCodes = [];

  foreach ($machines as $machine) {
    $takenCodes[] = $machine["qr"];
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Codes</title>
    <meta content="Codes" property="og:title" />
    <meta content="Codes" property="twitter:title" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Webflow" name="generator" />
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <script src="/js/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
      WebFont.load({
        google: {
          families: ["Oswald:200,300,400,500,600,700"]
        }
      });
    </script>
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif]-->
    <script type="text/javascript">
      ! function(o, c) {
        var n = c.documentElement,
          t = " w-mod-";
        n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
      }(window, document);
    </script>
    <link href="/img/falconclean-logo-32.png" rel="shortcut icon" type="image/x-icon" />
    <link href="/img/falconclean-logo-256.png" rel="apple-touch-icon" />
  </head>
  <body class="print-body">
    <div class="sheet">
      <div id="w-node-_785a7e9d-39f3-951d-47b3-925a59acc53a-0464d932" class="print-label">
        <div id="w-node-_80a8a6c5-b4b0-f625-0271-88617f7f7277-0464d932" class="qr-label">FalconClean</div>
        <div id="w-node-b4382de3-57ce-29fe-561e-c49e74bbef82-0464d932" class="qr-code"></div>
      </div>
    </div>
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="/js/qrcode.js"></script>
    <script>
      function multiplyNode(node, count, deep) {
        for (var i = 0, copy; i < count - 1; i++) {
          copy = node.cloneNode(deep);
          node.parentNode.insertBefore(copy, node);
        }
      }

      multiplyNode(document.querySelector('.print-label'), 30, true);

      multiplyNode(document.querySelector('.sheet'), 5, true);

      var qr = 0;
      var taken = <?php echo json_encode($takenCodes); ?>;
      var codes = document.getElementsByClassName("qr-code");
      for (var i = 0; i < codes.length; qr++) {
        if (taken.includes(qr)) {
          continue;
        }
        new QRCode(codes.item(i), {
          text: "https://falconclean.app/q?r=" + qr,
          correctLevel: QRCode.CorrectLevel.L
        });
        i++;
      }

      qr = 0;
      var labels = document.getElementsByClassName("qr-label");
      for (var i = 0; i < labels.length; qr++) {
        if (taken.includes(qr)) {
          continue;
        }
        labels.item(i).innerHTML = "FalconClean #" + (qr + 1);
        i++;
      }
    </script>
  </body>
</html>