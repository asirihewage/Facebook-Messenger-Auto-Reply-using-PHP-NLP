<?php
/*
  NLP and Wikipedia based Auto reply for Facebook Messenger using PHP
  @author : Asiri Hewage - https://github.com/asirihewage
*/

$configs = include('config/config.php');

?>
<!DOCTYPE html>
<html><head>
  <title> Chat Bot</title>
  <meta charset="UTF-8">
  <meta name="description" content="Facebook Messenger Chat Bot" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <meta property="og:url"                content="https://github.com/asirihewage/Facebook-Messenger-Auto-Reply-using-PHP-NLP" />
  <meta property="og:type"                content="website" />
  <meta property="og:title"              content="Facebook Messenger Chat Bot" />
  <meta property="og:description"        content="Simply ask him what you want to know about. (Messenger Bot)" />
  <meta property="og:image"              content="https://scontent.fcmb2-1.fna.fbcdn.net/v/t1.0-9/120377305_103200441558198_8655569129738664804_o.png?_nc_cat=109&_nc_sid=e3f864&_nc_ohc=IzSZwVaoe5oAX8_BgAg&_nc_ht=scontent.fcmb2-1.fna&oh=98ce1e8dd9cb9f92e31bdea6917f5438&oe=5F9E8B48" />

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:creator" content="@asirihewage">
  <meta name="twitter:title" content="Facebook Messenger Chat Bot">
  <meta name="twitter:description" content="Simply ask him what you want to know about. (Messenger Bot)">
  <meta name="twitter:image" content="https://scontent.fcmb2-1.fna.fbcdn.net/v/t1.0-9/120377305_103200441558198_8655569129738664804_o.png?_nc_cat=109&_nc_sid=e3f864&_nc_ohc=IzSZwVaoe5oAX8_BgAg&_nc_ht=scontent.fcmb2-1.fna&oh=98ce1e8dd9cb9f92e31bdea6917f5438&oe=5F9E8B48">

<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  background-image: url("https://scontent.fcmb2-1.fna.fbcdn.net/v/t1.0-9/120377305_103200441558198_8655569129738664804_o.png?_nc_cat=109&_nc_sid=e3f864&_nc_ohc=IzSZwVaoe5oAX8_BgAg&_nc_ht=scontent.fcmb2-1.fna&oh=98ce1e8dd9cb9f92e31bdea6917f5438&oe=5F9E8B48");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>


  </head><body>

<div class="bg"></div>



    <!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v8.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="<?php  $configs -> page_id ;?>"
  logged_in_greeting="Ask me something. Ex: Dogs"
  logged_out_greeting="Ask me something. Ex: Dogs">
      </div>
      
</body></html>