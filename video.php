<html>
<head>
    <meta name="referrer" content="never">
    <meta name="referrer" content="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
    $title = "Video";
    $a=$_GET;
    if(array_key_exists("title",$a)){
      $title=$a["title"];
    }
    echo "<title>". $title."</title>"
     ?>

    <style>
        a {
            color: #AAAAAA;
        }
        .gene{
          display:block;width:300px;max-width:100%;margin-bottom:5px;
        }
        </style>
</head>

<?php if (array_key_exists("head",$_GET)||array_key_exists("link",$_GET)) {?>
  <body style="margin: 0;background: black">

  <div style="font-size: 12px;display: inline-block;text-align: center;color: gray;width: 100%">如需要保存、全屏或者出现视频无法播放、外星人入侵地球等情况，请使用浏览器打开</div>
  <?php
  $a=$_GET;
  $links=$_GET['link'];

  if( array_key_exists("title",$a)){
    echo "<h2 style=\"text-align: center;color:white\">".  $a['title']."</h2>";
  }
  ?>
  <!-- <div style="text-align:center;margin-bottom:10px"> -->
    <!-- <button id="addbm">添加本页到书签</button> -->
  <!-- </div> -->
  <?php

  if(array_key_exists("head",$a)){
    $head=$_GET['head'];
    foreach ($links as &$value) {
      $value =$head . $value;
  }

  }

  foreach($links as $key=>$item) {

      echo "<div id=\"".($key+1)."\" style=\"color:white;width:100%;text-align:center\">".($key+1)."/".count($_GET['link'])."</div>";

        echo "<video id=\"v".($key+1)."\" preload=\"none\" controls style=\"max-width: 100% ;max-height:95vh;display: block;margin-left: auto;margin-right: auto;margin-top: 10px\" >";
      echo "<source src=\"".$item."\" type=\"video/mp4\">";
      echo "</video>";
      echo "<div style=\"text-align: center;color: white;width: 100%;height: 30px;line-height: 30px\"><a href=".$item.">下载上面的视频</a></div>";

  }
  ?>
  <div style="height:30px"></div>
  <div style="color:white;text-align:center">本站没有保存或提供任何视频和用户信息。本站只负责播放您提供的视频地址。如果您在本页发现违规内容，请<a href="/video.php">点击这里</a>以消除您亲自输入的违规内容。</div>
  <div style="color:white;text-align:center">DMCA complaint: the site does not store or provide any video or user content. The site only plays the video provided by yourself in the URL. If you found any unsuitable or illegal content, please click <a href="/video.php">here</a>.</div>
</body >
<script>

function init() {
  var last = localStorage.getItem(window.location.search);
  if (last!==null){
    var p = last.split(",");
    var video = document.getElementById(p[0]);
    if (video.readyState !== 4) {
      video.load();
      video.currentTime=p[1]
    }
    document.getElementById(p[0].replace("v","")).scrollIntoView({behavior: 'smooth'});
    document.getElementById(p[0].replace("v","")).innerText="上次看到这里 "+document.getElementById(p[0].replace("v","")).innerText

  }
}
try {
  init()
} catch (e) {
  console.log(e);
} finally {

}

// document.getElementById("addbm").addEventListener("click",function(){
//   var createBookmark = browser.bookmarks.create({
//     title: document.title,
//       url: window.location.href
//     });
//
// })

var playing=null;
var medias = Array.prototype.slice.apply(document.querySelectorAll('audio,video'));
medias.forEach(function(media) {
  media.addEventListener('play', function(event) {
    playing=event.target;
    medias.forEach(function(media) {
      if(event.target != media) media.pause();
    });
  });
});
function record(){
  setInterval(function(){
    if (playing!==null) {
      localStorage.setItem(window.location.search,playing.id+","+playing.currentTime)
    }
  }, 1000);
}
record();
</script>
<?php }else { ?>

  <body style="text-align: center;margin: 0;margin-top: 20px;background: black;color:white">
    <h3>生成视频页面</h3>
    <h5>你需要：每行一个视频直链</h5>
<div style="display:inline-block">
  <input class="gene" id="title" placeholder="页面标题" ></input>
  <textarea class="gene" id="tx" placeholder="每行一个视频直链"></textarea>
  <button class="gene" id="go">生成地址</button>
  <input class="gene" id="ip" />

  <input class="gene" id="kw" placeholder="（可选）/s/???????????????????"/>
  <button class="gene" id="gst">生成短地址</button>
  <div class="gene" id="status"></div>

  <input class="gene" id="st" />


</div>
  </body>
  <script>

  var ajax = {};
  ajax.x = function () {
      if (typeof XMLHttpRequest !== 'undefined') {
          return new XMLHttpRequest();
      }
      var versions = [
          "MSXML2.XmlHttp.6.0",
          "MSXML2.XmlHttp.5.0",
          "MSXML2.XmlHttp.4.0",
          "MSXML2.XmlHttp.3.0",
          "MSXML2.XmlHttp.2.0",
          "Microsoft.XmlHttp"
      ];

      var xhr;
      for (var i = 0; i < versions.length; i++) {
          try {
              xhr = new ActiveXObject(versions[i]);
              break;
          } catch (e) {
          }
      }
      return xhr;
  };

  ajax.send = function (url, callback, method, data, async) {
      if (async === undefined) {
          async = true;
      }
      var x = ajax.x();
      x.open(method, url, async);
      x.onreadystatechange = function () {
          if (x.readyState == 4) {
              callback(x.responseText)
          }
      };
      if (method == 'POST') {
          x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      }
      x.send(data)
  };

  ajax.get = function (url, data, callback, async) {
      var query = [];
      for (var key in data) {
          query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
      }
      ajax.send(url + (query.length ? '?' + query.join('&') : ''), callback, 'GET', null, async)
  };

  ajax.post = function (url, data, callback, async) {
      var query = [];
      for (var key in data) {
          query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
      }
      ajax.send(url, callback, 'POST', query.join('&'), async)
  };

function short(){
  ajax.get('/s/yourls-api.php', {
    action:   "shorturl",
       format:   "json",
       url:      document.getElementById("ip").value,
       keyword:document.getElementById("kw").value
    }, function(e) {
      var res= JSON.parse(e)
      if (res.status==="success") {
        document.getElementById("status").innerText="OwO"
        document.getElementById("st").value=res.shorturl

      }else {
        document.getElementById("status").innerText="＞︿＜"
      }
    });


}
document.getElementById("gst").addEventListener("click",function(){
  clk();
  short();
})


      function lcss(arr1){
        var arr= arr1.concat().sort(),
        a1= arr[0], a2= arr[arr.length-1], L= a1.length, i= 0;
        while(i< L && a1.charAt(i)=== a2.charAt(i)) i++;
        return a1.substring(0, i);
      }
      function clk(){
        var ttl =document.getElementById("title").value.trim();
          var v =document.getElementById("tx").value;
          var nv=v.trim().split(/\r?\n/);
          nv.forEach(function(e,i){
            nv[i] = encodeURIComponent(e)
          })

          var ret=window.location.href.split("?")[0]+"?";
          if (ttl!="") {
            ret=ret+"title="+encodeURIComponent(ttl)+"&"
          }
          if (nv.length>=2) {
            var prefix = lcss(nv);
            if (prefix!="") {
              var ret=ret+"head="+prefix+"&";
              nv.forEach(function(e,i){
                nv[i]=e.slice(prefix.length)
              })
            }
          }
          nv.forEach(function (e,i) {
              ret+="link[]="+e+"&"
          });
          document.getElementById("ip").value=ret;
      }
      document.getElementById("go").addEventListener("click",clk)
  </script>

<?php } ?>
</html>
