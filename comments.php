<button class="btn btn-info w-100" id="show-comments" onclick="disqus();return false;">Thảo luận về bài này</button>

<div id="disqus_thread"></div>

<script>
  var disqus_loaded = false;
  var disqus_shortname = '<?php echo get_option('site_disqus'); ?>'; //Add your shortname here
  function disqus() {
      if (!disqus_loaded)  {
          disqus_loaded = true;
          var e = document.createElement("script");
          e.type = "text/javascript";
          e.async = true;
          e.src = "//" + disqus_shortname + ".disqus.com/embed.js";
          (document.getElementsByTagName("head")[0] ||
          document.getElementsByTagName("body")[0])
          .appendChild(e);
          //Hide the button after opening
          document.getElementById("show-comments").style.display = "none";
          // Hide the disqus footer 
      }
  }
  //Opens comments when linked to directly
  var hash = window.location.hash.substr(1);
  if (hash.length > 8) {
      if (hash.substring(0, 8) == "comment-") {
          disqus();
      }
  }
  //Remove this if you don't want to load comments for search engines
  if(/bot|google|baidu|bing|msn|duckduckgo|slurp|yandex/i.test(navigator.userAgent)) {
    disqus();
  }
</script>