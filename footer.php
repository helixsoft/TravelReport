	<footer>
		<div class="row">
			<div class="row">
				<div class="large-5 columns margin-top-25">
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
							<a href="<?php TravelReport_Footer_menulink(0) ?>"><h1 class="news"><?php TravelReport_Footer_menutitle(0)?></h1></a>
							<ul>
								<?php TravelReport_Footer_submenu(0);?>
							</ul>
						</div>
					</div>
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
							<a href="<?php TravelReport_Footer_menulink(1) ?>"><h1 class="magazine"><?php TravelReport_Footer_menutitle(1)?></h1></a>
							<ul>
								<?php TravelReport_Footer_submenu(1);?>
							</ul>
        				</div>
					</div>
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
				          	<a href="<?php TravelReport_Footer_menulink(2) ?>"><h1 class="coverage"><?php TravelReport_Footer_menutitle(2)?></h1></a>
					        <ul>
								<?php TravelReport_Footer_submenu(2);?>
							</ul>
						</div>
					</div>
				</div>
				<div class="large-2 columns margin-top-25">
					<div class="large-12 small-6  columns">
						<div class="footer_menu">
							<a href="<?php TravelReport_Footer_menulink(3) ?>"><h1 class="work"><?php TravelReport_Footer_menutitle(3)?></h1></a>
							<ul>
								<?php TravelReport_Footer_submenu(3);?>
							</ul>
        				</div>
					</div>
				</div>
				<div class="large-5 columns margin-top-25">
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
          					<a href="<?php TravelReport_Footer_menulink(4) ?>"><h1 class="travelguide"><?php TravelReport_Footer_menutitle(4)?></h1></a>
						    <ul>
								<?php TravelReport_Footer_submenu(4);?>
							</ul>
        				</div>
					</div>
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
							<a href="<?php TravelReport_Footer_menulink(5) ?>"><h1 class="entertainment"><?php TravelReport_Footer_menutitle(5)?></h1></a>
							<ul>
								<?php TravelReport_Footer_submenu(5);?>
							</ul>
						</div>
					</div>
					<div class="large-4 small-4 columns">
						<div class="footer_menu">
				          	<a href="<?php echo home_url()?>"><h1 class="travelreport">TRAVEL REPORT</h1></a>
				          	<ul>
								<?php TravelReport_Footer_lastmenu();?>
							</ul>
        				</div>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="large-4 small-4 columns">
					<p style="word-wrap: break-word;">
					Travel Media Scandinavia AB<br>
					Copyright © 2011 | 
					Ansvarig Utgivare: Kjell Santesson.<br>
					Redaktör:  Christian von Essen
					</p>
				</div>
				<div class="large-4 small-4   columns">
					<p style="word-wrap: break-word;">Adress: Nybrogatan 16, SE-114 39 Stockholm<br>Tel: +46(0)8-545 660 00 <br>Fax: +46(0)8 545 660 01<br><a href="http://www.travelmedia.se">www.travelmedia.se</a></p>
				</div>
				<div class="large-4 small-4  columns">
					<p style="word-wrap: break-word;">E-post: <a href="mailto:press@travelreport.se">press@travelreport.se</a><br>E-post till medarbetare: förnamn@travelreport.se<br>Design och utveckling av <a target="_blank" href="http://www.langustus.com">Langustus Industrier AB</a></p>
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer();?>
</body>
</html>