<?php

  include_once($_SERVER["DOCUMENT_ROOT"] . "/functs.php");

  $machineID = param("machineID", ["sticky" => true]);

  $machine = readObject("machines", ["id" => $machineID], 1);
  
  $currentLoad = readObject("loads", ["machineID" => $machineID], 1);
  $machineType = readObject("types", ["id" => $machine["typeID"]], 1);

  $timeLeft = $machineType["cycleTime"] - time_elapsed_minutes($currentLoad["load"]);

  $alternatives = readObject("machines", ["typeID" => $machine["typeID"]]);
  $recommendedAlternative = $machine;
  $bestTime = time_elapsed_minutes($currentLoad["load"]);


  foreach ($alternatives as $alternative) {
    $load = readObject("loads", ["machineID" => $alternative["id"]], 1);
    if ($load != null) {
      $time = time_elapsed_minutes($load["load"]);
      if ($time > $bestTime) {
        $recommendedAlternative = $alternative;
        $bestTime = $time;
      }
    } else {
      $recommendedAlternative = $alternative;
      $bestTime = $machineType["cycleTime"];
    }
  }

  $bestTime = $machineType["cycleTime"] - $bestTime;

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Alert</title>
    <meta content="Busy" property="og:title" />
    <meta content="Busy" property="twitter:title" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
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
  <body class="body">
    <div class="div-block">
      <h1>Busy</h1>
      <div>This machine is currently busy.</div>
      <?php if ($bestTime > 0) { ?>
        <?php if ($recommendedAlternative["qr"] == $machine["qr"]) { ?>
          <div>This will be the next machine to open up, in <?php echo $bestTime; ?> minutes.</div>
        <?php } else { ?>
          <div>The next machine open will be #<?php print($recommendedAlternative["qr"]) ?>, in <?php print($bestTime) ?> minutes.</div>
        <?php } ?>
      <?php } else { ?>
        <div>However, machine #<?php print($recommendedAlternative["qr"]) ?> is open now.</div>
      <?php } ?>
    </div>
    <script src="/js/jquery.js" type="text/javascript"></script>
  </body>
</html>