<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?> > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->
<?php 
if (isset($_POST['selWeatherCity'])) {
  setcookie("WeatherCity", $_POST['selWeatherCity']);
}
?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
  	<meta name="viewport" content="width=device-width">
  	<title><?php wp_title( '|', true, 'right' ); ?></title>
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  	<link rel="shortcut icon" href=""  type="image/x-icon"/>
  	<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
  	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
  	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  	<?php wp_head();?>
</head>
<body <?php body_class('cbp-spmenu-push'); ?>>
	<div class="top_ads"></div>
	<header>
		<div class="row">
			<div class="large-12 columns ">
				<button id="showLeftPush" class="showLeftPush">Show/Hide Left Push Menu</button>
				<div class="header-top hide-mobile">
				    <div class="date_time"><?php echo date('l, F jS, Y'); ?></div>
				    <?php

          			?>
				    <?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu' => 'Toppmeny','menu_class' => 'menu', 'container' =>'nav','container_class' => 'top-nav' ) ); ?>
				</div><!-- #access -->
			</div>
		</div>
		<div class="row margin-top-25">
			<div class="large-6 small-12 small-centered large-uncentered columns"><div class="image-container logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo IMAGES?>/logo.png"></a></div></div>
			<div class="large-4 small-12 small-centered large-uncentered columns hide-mobile">
				<div class="row">
					<div class="large-12 columns">
					<dl class="tabs" data-tab>
					  <dd class="active"><a href="#panel2-1">SENASTE NYTT</a></dd>
					  <dd><a href="#panel2-2">MEST LÄST</a></dd>
					</dl>
					<div class="tabs-content">
					  <div class="content active" id="panel2-1">
					    <?php
					  			// antal tecken
					  			$browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
								if ($browser == true)  
									$fNChar = 20;
								else
									$fNChar = 39;
								$fNChar2 = $fNChar - 2;
						        $args = array(
						          'showposts' => 4,
						          'category__in' => array(14, 843),
						        );
				        		$my_query = new WP_Query($args);
				        		$nAlternate = 1;
				        		$arrRows = array ("even", "odd");
				        		while ($my_query->have_posts()) {
				          			$my_query->the_post();
				          			$nAlternate = abs($nAlternate - 1);
				          			$sDate = get_the_date("j M");
							        if ($sDate == date("j M")) {
							           	$sDate = "";
							        }
							        if ($sDate != "") {
							            $sDate = " (" . strtolower($sDate) . ") ";
							        }
							        $sTitle = get_the_title();
							        if (strlen($sTitle) > $fNChar) {
							            $nStart = strpos($sTitle, " ", $fNChar2);
							            if (!$nStart) $nStart = $fNChar2;
							            $sTitle = trim(substr($sTitle, 0, $nStart)) . "...";
							        }
				          		?>
				            		<li class="<?php echo $arrRows[$nAlternate]; ?>"><?php the_time(); echo $sDate; ?> - <a href="<?php the_permalink() ?>"><?php echo $sTitle; ?></a></li>
				          		<?php
				        		}

				          	?>
				          	<li class="smallLink"><a class="redlink" href="<?php echo site_url('/mostviewed/')?>">&nbsp;</a></li>
					  </div>
					  <div class="content" id="panel2-2">
					    <?php
								$sql = "SELECT p.id, p.post_title, p.post_modified, ppd.pageviews
				                FROM `wp_posts` p
				                  INNER JOIN wp_popularpostsdata ppd ON p.id = ppd.postid
				                WHERE p.post_status = 'publish'
				                  AND p.post_type = 'post'
				                  # AND p.post_date >= '" . gmdate("Y-m-d") . "' - INTERVAL 30 DAY
				                ORDER BY ppd.pageviews DESC
				                LIMIT 4";
				        		$result = mysql_query($sql) or die('Fr?gan misslyckades: ' . mysql_error());
				        		$nAlternate = 1;
				        		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				          			$nAlternate = abs($nAlternate - 1);
				          			$sTitle = $row['post_title'];
				          			if (strlen($sTitle) > $fNChar) {
				            			$nStart = strpos($sTitle, " ", $fNChar2);
				            			if (!$nStart) $nStart = $fNChar2;
				            				$sTitle = trim(substr($sTitle, 0, $nStart)) . "...)";
				          			}

				          		?>
				         			<li class="<?php echo $arrRows[$nAlternate]; ?>"><?php echo $row['pageviews'];?> visningar - <a href="<?php echo get_permalink($row['id']); ?>"><?php echo $sTitle ?></a></li>
				          		<?php
				        		}
				        		mysql_free_result($result);
				        	?>
								<li class="smallLink"><a class="redlink" href="<?php echo site_url('/mostviewed/')?>">Visa alla</a></li>
					    </div>
				    </div>
				    </div>
				</div>
			</div>
			<div class="large-2 small-12 small-centered large-uncentered columns hide-mobile">
				<!--Weather Widget Area-->
				<div class="weather">
			        <div class="weather-city">
			          <form method="post" style="margin-bottom: 15px;">
			            <select name="selWeatherCity" onchange="submit();"> 
			              	<?php
			              	$sWeatherCity ="";
			                if (isset($_COOKIE['WeatherCity'])) {
			                  $sWeatherCity = $_COOKIE['WeatherCity'];
			                }
			                if (isset($_POST['selWeatherCity'])) {
			                  $sWeatherCity = $_POST['selWeatherCity'];
			                }
			                $arrWeatherCities = array ("Stockholm", "G&ouml;teborg", "Malm&ouml;","Uppsala","V&auml;ster&aring;s","&Ouml;rebro","Link&ouml;ping","Helsingborg", "J&ouml;nk&ouml;ping","Norrk&ouml;ping", "Lund", "Ume&aring;", "G&auml;vle", "Bor&aring;s", "S&ouml;dert&auml;lje");
							$arrWeatherCities2 = array ("Stockholm", "Goteborg", "Malmo","Uppsala","Vasteras","Orebro","Linkoping","Helsingborg", "Jonkoping","Norrkoping", "Lund", "Umea", "Gavle", "Boras", "Sodertalje");
			                $sWeatherCity = RemoveSwedishLetters($sWeatherCity);
							$fN2 = 0;
			                foreach ($arrWeatherCities as $sCity) {	
			                  $sOption = RemoveSwedishLetters($sCity);
			                  //$sCity = htmlentities($sCity);
			                  $sSel =  $arrWeatherCities2[$fN2] == $sWeatherCity ? "selected" : "";
			                ?>
			                  <option <?php echo $sSel; ?> value="<?php echo $arrWeatherCities2[$fN2]; ?>"><?php echo $sCity; ?></option>
			                <?php
								  $fN2++;
			                }
			              ?>
			            </select>
			          </form>
			          <?php
			            include ("weather.php");
			            echo $sWeatherWidget;
			          ?>
			        </div>
		        </div>
			</div>
		</div>	
		<div class="row">
			<div class="large-12 columns">
				<nav class="main-nav">	
				<?php TravelReport_navigation(); ?>
				</nav>		
			</div>
		</div>
	</header>