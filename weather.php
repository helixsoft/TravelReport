<?php

  switch ($sWeatherCity) {
    case "Goteborg":
      $sWeatherWidget = '<div id="c_8ab8634db1c14d245bd258f9c9413008" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/8ab8634db1c14d245bd258f9c9413008"></script>';
      break;

    case "Malm&ouml:":
      $sWeatherWidget = '<div id="c_f557f72e824ddad88e5080126433101b" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/f557f72e824ddad88e5080126433101b"></script>';
      break;

    case "Uppsala":
      $sWeatherWidget = '<div id="c_fa3583e56be310aceb3d9b7411e20526" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/fa3583e56be310aceb3d9b7411e20526"></script>';
      break;

    case "V&auml;ster&aring;s":
      $sWeatherWidget = '<div id="c_2c3d6506484b7716757e35626c9f3d5f" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/2c3d6506484b7716757e35626c9f3d5f"></script>';
      break;

    case "Orebro":
      $sWeatherWidget = '<div id="c_477f54eb10229f8d662bff6bc3f4fd8c" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/477f54eb10229f8d662bff6bc3f4fd8c"></script>';
      break;

    case "Linkoping":
      $sWeatherWidget = '<div id="c_b7538dc8df02a6b395a88412ff6bf7d4" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/b7538dc8df02a6b395a88412ff6bf7d4"></script>';
      break;

    case "Helsingborg":
      $sWeatherWidget = '<div id="c_a4cf25ab3a38c4cd8a8f42e1f773c685" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/a4cf25ab3a38c4cd8a8f42e1f773c685"></script>';
      break;

    case "Jonkoping":
      $sWeatherWidget = '<div id="c_4fb2fc9588aea9a7a631eb33f2bc0d82" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/4fb2fc9588aea9a7a631eb33f2bc0d82"></script>';
      break;

    case "Norrkoping":
      $sWeatherWidget = '<div id="c_fda44fb3607023048021fe3186ba2139" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/fda44fb3607023048021fe3186ba2139"></script>';
      break;

    case "Lund":
      $sWeatherWidget = '<div id="c_091b0c11ec76c8fd40c4afd0d8d94f5f" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/091b0c11ec76c8fd40c4afd0d8d94f5f"></script>';
      break;

    case "Ume&aring;":
      $sWeatherWidget = '<div id="c_db439b4725d1b8eb4a57db64f316cc67" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/db439b4725d1b8eb4a57db64f316cc67"></script>';
      break;

    case "Gavle":
      $sWeatherWidget = '<div id="c_1e5b115fe82d17b67fbadcf2e6bdb61d" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/1e5b115fe82d17b67fbadcf2e6bdb61d"></script>';
      break;

    case "Boras":
      $sWeatherWidget = '<div id="c_19cce0e7bb85b7fefd71f776836deba7" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/19cce0e7bb85b7fefd71f776836deba7"></script>';
      break;

    case "Sodertalje":
      $sWeatherWidget = '<div id="c_bc88a5e92a91e1edfde10837828bbcb1" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/bc88a5e92a91e1edfde10837828bbcb1"></script>';
      break;

    default:
      $sWeatherWidget = '<div id="c_3249d96fd776953e195ad1e9eb28b85e" class="mini"></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/3249d96fd776953e195ad1e9eb28b85e"></script>';
  }

/*
$sWeatherWidget = '<div id="c_6a5ef38c5d6969e9bf912737e81e9252" class="normal"><h2 style="color: #000000; margin: 0 0 3px; padding: 2px; font: bold 13px/1.2 Verdana; text-align: center;">Vädret Stockholm</h2></div><script type="text/javascript" src="http://www.klart.se/widget/widget_loader/6a5ef38c5d6969e9bf912737e81e9252"></script>';

*/
?>