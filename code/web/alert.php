<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Alert</title>
    <meta content="Alert" property="og:title" />
    <meta content="Alert" property="twitter:title" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <script src="/webfont.js" type="text/javascript"></script>
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
    <link href="https://uploads-ssl.webflow.com/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="https://uploads-ssl.webflow.com/img/webclip.png" rel="apple-touch-icon" />
  </head>
  <body class="body">
    <div class="div-block">
      <h1>Issue Alert</h1>
      <div>The following issues have been<br />reported for this machine:</div>
      <div>&quot;Does not dry&quot;</div>
      <a href="/load.php" class="submit-button w-button">Back</a>
      <a href="/api/load/create.php" class="submit-button w-button">Load Laundry Anyway</a>
    </div>
    <script src="/jquery.js" type="text/javascript"></script>
  </body>
</html>
