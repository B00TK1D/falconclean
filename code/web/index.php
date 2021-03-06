<?php

  include_once($_SERVER["DOCUMENT_ROOT"] . "/functs.php");

  $rooms = readObject("rooms");
  $types = readObject("types");

  foreach ($rooms as $key => $room) {
    $rooms[$key]["machines"] = readObject("machines", ["roomID" => $room["id"]]);
    foreach ($rooms[$key]["machines"] as $key2 => $machine) {
      $rooms[$key]["machines"][$key2]["issues"] = readObject("issues", ["machineID" => $machine["id"]]);
    }
  }

  foreach ($rooms as $key => $room) {
    $rooms[$key]["total-wait"] = 0;
    $rooms[$key]["busy-machines"] = 0;
    $rooms[$key]["total-cycle"] = 0;
    $rooms[$key]["total-machines"] = 0;
    $minWait = [];
    foreach ($room["machines"] as $key2 => $machine) {
      $load = readObject("loads", ["machineID" => $machine["id"]], 1);
      $machineType = readObject("types", ["id" => $machine["typeID"]], 1);
      if ($load != null && $machineType != null) {
        $time = $machineType["cycleTime"] - time_elapsed_minutes($load["load"]);
        if ($time > 0) {
          $rooms[$key]["total-wait"] += $time;
          $rooms[$key]["busy-machines"]++;
        }
        if (isset($minWait[$machine["typeID"]])) {
          if ($time < $minWait[$machine["typeID"]]) {
            $minWait[$machine["typeID"]] = $time;
          }
        } else {
          $minWait[$machine["typeID"]] = $time;
        }
      }
      $rooms[$key]["total-cycle"] += $machineType["cycleTime"];
      $rooms[$key]["total-machines"]++;
    }
    $rooms[$key]["wait"] = 0;
    $rooms[$key]["capacity"] = 0;
    if (count($minWait) > 0) {
      $rooms[$key]["wait"] = max(min($minWait), 0);
    }
    if ($rooms[$key]["total-machines"] > 0) {
      $rooms[$key]["capacity"] = ($rooms[$key]["busy-machines"] / $rooms[$key]["total-machines"]) * 100;
    }
  }



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Status</title>
    <meta content="Status" property="og:title" />
    <meta content="Status" property="twitter:title" />
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
  <body class="dashboard">
    <div class="dashboard-section">
      <h1>Current Usage</h1>
      <div class="list">
        <?php foreach ($rooms as $room) { ?>
          <div class="list-item">
            <div><?php print($room["name"] . " - " . (int)$room["capacity"] . "% capacity (Estimated wait time: " . (int)$room["wait"] . " minutes)") ?></div>
          </div>
        <?php } ?>
      </div>
      <div class="horizontal-line"></div>
    </div>
    <!--
    <div data-current="Tab 1" data-easing="ease" data-duration-in="0" data-duration-out="0" class="tabs w-tabs">
      <div class="tabs-menu w-tab-menu"><a class="tab-link-tab-1 w-inline-block w-tab-link w--current" onclick="">
          <div>Sijan</div>
        </a><a class="tab-link-tab-1 w-inline-block w-tab-link">
          <div>Vandy</div>
        </a></div>
      <div class="w-tab-content">
        <div class="tab-pane-tab-1 w-tab-pane w--tab-active">
          <div class="map">
            <div class="machine-icon">
              <div class="icon-status dark"></div>
            </div>
            <div class="machine-icon _2"></div>
            <div class="door-icon"></div>
          </div>
        </div>
        <div class="tab-pane-tab-1 w-tab-pane">
          <div class="map">
            <div class="machine-icon">
              <div class="icon-status dark"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    -->
    <script src="/js/jquery.js" type="text/javascript"></script>
  </body>
</html>
