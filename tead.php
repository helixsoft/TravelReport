function do_replace($matches){
      return $matches[0].($matches[1]?'<p style="text-align:right; margin: 0;">'.$matches[1].'</p>':'');
    }
    $content = get_the_content();
    $arrContent = apply_filters('the_content', $content);
    $arrContent = explode("</p>", $arrContent);
    $nMax = count($arrContent);
    $bSetIntro = false;
    for ($i = 0; $i < $nMax; $i++) {
      $sContent = $arrContent[$i];
      if (!$bSetIntro && strpos ($sContent, "<p><a") === false) {
        $sContent = str_replace ("<p>", "<p class=\"intro\">", $sContent) . "</p>";
        $bSetIntro = true;
      }
      if($i!=1){
        if($i<$nMax){
          echo $sContent;
        }
        if($i==$nMax-2){
          $myadcode = '<div class="entry-author-info clearfix">';
            $myadcode .='<div class="author-avatar">';
              $myadcode .='<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">';
                $myadcode .= get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'travelmedia_author_bio_avatar_size', 60 ) );
              $myadcode .='</a>';
            $myadcode .='</div>';
            $myadcode .='<div class="author-info">';
              $myadcode .='<p>'.ucfirst(get_the_author_meta('display_name')).'</p>';
              $myadcode .='<span>'.get_the_author_meta( 'user_email' ).'</span>';          
            $myadcode .='</div>';
          $myadcode .='</div>';
          echo $myadcode;
        }
      }
      if($i==1){
          $myadcode ='<div class="additional-content">';
            $myadcode .='<p>Fler artiklar om:</p>';   
            $myadcode .='<div class="news">'.TravelReport_categorylist($post->ID,'<li>&nbsp;,&nbsp;</li>').'</div>';
            $myadcode .='<div id="example">';
              $myadcode .='<div id="twitter" data-url="http://sharrre.com/" data-text="Make your sharing widget with Sharrre (jQuery Plugin)" data-title="Tweet"></div>';
              $myadcode .='<div id="facebook" data-url="http://sharrre.com/" data-text="Make your sharing widget with Sharrre (jQuery Plugin)" data-title="Like"></div>';
              $myadcode .='<div id="googleplus" data-url="http://sharrre.com/" data-text="Make your sharing widget with Sharrre (jQuery Plugin)" data-title="+1"></div>';
            $myadcode .='</div>';
            $myadcode .='<div class="tip clearfix">';
              $myadcode .='<div class="mic"></div>';
              $myadcode .='<p>Tipsa oss om nyheter!</p>';
            $myadcode .='</div>';
          $myadcode .='</div>';
      $filteredcontent = $myadcode .'<div class="text-container">' .$sContent.'</div>';
      echo $filteredcontent;
      }
    }