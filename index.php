<?php

include_once('framework_ajax.php');

/******************************************************************/



echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PIRATEN MV IT-Status</title>
    <meta name="description" content="IT-Status der PIRATEN MV">
    <meta name="author" content="Niels Lohmann">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="html5.js"></script>
    <![endif]-->
    
    <script src="jquery-1.7.1.min.js"></script>

    <!-- Le styles -->
    <link href="bootstrap.css" rel="stylesheet">
    <link href="docs.css" rel="stylesheet">
  </head>

  <body>

  <div class="topbar">
    <div class="fill">
      <div class="container">
        <a class="brand" href="#">IT Status</a>
        <ul class="nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#bund">Bundes-IT</a></li>
          <li><a href="#other">Leih-IT</a></li>
          <li><a href="#land">Landes-IT</a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="container">

  <section id="bund">
    <div class="page-header">
      <h1>Bundes-IT <small>Systeme, die vom Bundesverband betrieben werden</small></h1>
    </div>
    <div class="row">
      <div class="span14">';

echo '<h2>Wiki <small>wiki.piratenpartei.de</small></h2>';
assertStatusEQ("http://wiki.piratenpartei.de", "301");
assertStatusEQ("http://wiki.piratenpartei.de/Hauptseite", "200");
assertStatusEQ("https://wiki.piratenpartei.de/Hauptseite", "200");
assertTitleEQ("http://wiki.piratenpartei.de/Hauptseite", "Hauptseite – Piratenwiki");
assertStatusEQ("http://wiki.piraten-mv.de", "301");
assertTitleEQ("http://wiki.piraten-mv.de", "");


echo '<h2>Mailinglisten <small>news.piratenpartei.de</small></h2>';

assertStatusEQ("http://news.piratenpartei.de", "200");
assertStatusEQ("https://news.piratenpartei.de", "200");
assertTitleEQ("https://news.piratenpartei.de", "Sync-Forum Piratenpartei Deutschland");

assertStatusEQ("https://service.piratenpartei.de/listinfo", 200);
assertTitleEQ("https://service.piratenpartei.de/listinfo", " Mailinglisten auf service.piratenpartei.de");

assertPortUp("news.piratenpartei.de", 119);


echo '<h2>Pads <small>piratenpad.de</small></h2>';

assertStatusEQ("http://meck-pom.piratenpad.de", "302");
assertStatusEQ("https://meck-pom.piratenpad.de", "302");
assertStatusEQ("http://pad.piratenpartei-mv.de", "301");
assertStatusEQ("http://pad.piraten-mv.de", "301");


echo '<h2>Liquid Feedback (Bundesinstanz) <small>lqfb.piratenpartei.de</small></h2>';
assertStatusEQ("https://lqfb.piratenpartei.de", "200");
assertStatusEQ("http://lqfb.piratenpartei.de", "301");
assertTitleEQ("https://lqfb.piratenpartei.de", "LiquidFeedback in der Piratenpartei Deutschland");


echo '<h2>Jabber <small>jabber.piratenpartei.de</small></h2>';

assertPortUp("jabber.piratenpartei.de", 5222);
assertPortUp("jabber.piratenpartei.de", 5269);
assertPortUp("jabber.piratenpartei.de", 5223);


echo '
      </div><!-- /span14 -->
    </div><!-- /row -->
  </section>

  <section id="other">
    <div class="page-header">
      <h1>Leih-IT <small>Systeme, die von anderen Landesverbänden betrieben werden</small></h1>
    </div>
    <div class="row">
      <div class="span14">';


echo '<h2>Mumble <small>mumble.piratenpartei-nrw.de</small></h2>';

assertPortUp("mumble.piratenpartei-nrw.de", 64738);


echo '<h2>Liquid Feedback (Landesinstanz) <small>lqpp.de/mv</small></h2>';
assertStatusEQ("https://lqpp.de/mv/", "303");
assertStatusEQ("http://lqpp.de/mv/", "301");
assertTitleEQ("https://lqpp.de/mv", " LiquidFeedback (Piratenpartei Mecklenburg-Vorpommern)");


echo '
      </div><!-- /span14 -->
    </div><!-- /row -->
  </section>

  <section id="land">
    <div class="page-header">
      <h1>Landes-IT <small>Systeme, die vom Landesverband betrieben werden</small></h1>
    </div>
    <div class="row">
      <div class="span14">';


echo '<h2>Website <small>piratenpartei-mv.de</small></h2>';

assertStatusEQ("http://piratenpartei-mv.de", "200");

assertRedirectionEQ('http://piraten-mv.de', 'http://piratenpartei-mv.de/');
assertRedirectionEQ('http://www.piraten-mv.de', 'http://piratenpartei-mv.de/');
assertRedirectionEQ('http://www.piratenpartei-mv.de', 'http://piratenpartei-mv.de/');

assertRedirectionEQ('https://piratenpartei-mv.de', 'http://piratenpartei-mv.de/');
assertRedirectionEQ('https://piraten-mv.de', 'http://piratenpartei-mv.de/');
assertRedirectionEQ('https://www.piratenpartei-mv.de', 'http://piratenpartei-mv.de/');
assertRedirectionEQ('https://www.piraten-mv.de', 'http://piratenpartei-mv.de/');

assertTitleEQ("http://piratenpartei-mv.de", "Piratenpartei Mecklenburg-Vorpommern");


echo '<h2>E-Mail <small>mail.piratenpartei-mv.de</small></h2>';

// web mail
assertStatusEQ("http://mail.piraten-mv.de", "200");
assertStatusEQ("https://mail.piraten-mv.de", "301");
assertStatusEQ("http://mail.piratenpartei-mv.de", "200");
assertStatusEQ("https://mail.piratenpartei-mv.de", "301");

assertPortUp("pop3.piraten-mv.de", 110);
assertPortUp("imap.piraten-mv.de", 143);
assertPortUp("smtp.piraten-mv.de", 25);
assertPortUp("smtp.piraten-mv.de", 587);

assertPortUp("pop3.piratenpartei-mv.de", 110);
assertPortUp("imap.piratenpartei-mv.de", 143);
assertPortUp("smtp.piratenpartei-mv.de", 25);
assertPortUp("smtp.piratenpartei-mv.de", 587);


echo '<h2>Streaming <small>streaming.piratenpartei-mv.de</small></h2>';

assertStatusEQ("http://streaming.piratenpartei-mv.de:8000", "200");
assertStatusEQ('http://streaming.piratenpartei-mv.de', '200');
assertStatusEQ("http://streaming.piratenpartei-mv.de/live", "200");
assertStatusEQ("http://streaming.piratenpartei-mv.de/admin/", "401");
assertStatusEQ("http://streaming.piratenpartei-mv.de/status2.xsl", "200");

assertRedirectionEQ('http://streaming.piraten-mv.de', 'http://streaming.piratenpartei-mv.de/');


echo '<h2>Helpdesk <small>helpdesk.piratenpartei-mv.de</small></h2>';

assertStatusEQ("https://helpdesk.piratenpartei-mv.de/otrs/index.pl", "200");
assertRedirectionEQ('http://helpdesk.piratenpartei-mv.de', 'https://helpdesk.piratenpartei-mv.de/');
assertRedirectionEQ('http://helpdesk.piraten-mv.de', 'https://helpdesk.piratenpartei-mv.de/');


echo '<h2>Storage <small>storage.piratenpartei-mv.de</small></h2>';

assertStatusEQ("https://storage.piratenpartei-mv.de", "404");
assertStatusEQ("https://storage.piratenpartei-mv.de/webdav", "401");
assertStatusEQ("https://storage.piratenpartei-mv.de/webdav/vorstand", "401");

assertRedirectionEQ('http://storage.piratenpartei-mv.de/webdav', 'https://storage.piratenpartei-mv.de/webdav');
assertRedirectionEQ('http://storage.piraten-mv.de/webdav', 'https://storage.piratenpartei-mv.de/webdav');


echo '<h2>Lime Survey <small>service.piratenpartei-mv.de/limesurvey</small></h2>';

assertStatusEQ("https://service.piratenpartei-mv.de/limesurvey/", "200");

assertRedirectionEQ('http://service.piratenpartei-mv.de/limesurvey', 'https://service.piratenpartei-mv.de/limesurvey/');
assertRedirectionEQ('http://service.piraten-mv.de/limesurvey', 'https://service.piratenpartei-mv.de/limesurvey/');


echo '<h2>Vorstandsportal <small>vorstand.piratenpartei-mv.de</small></h2>';

assertStatusEQ("http://vorstand.piratenpartei-mv.de", "200");
assertStatusEQ("http://vorstand.piratenpartei-mv.de/wp-admin", "301");
assertStatusEQ("http://vorstand.piratenpartei-mv.de/wp-login.php", "200");
assertStatusEQ("http://vorstand.piratenpartei-mv.de/wp-content/plugins/_umlaufbeschluss/umlauf.php", "200");
assertStatusEQ("http://vorstand.piratenpartei-mv.de/kontakt/antrag-stellen/", "200");
assertStatusEQ("http://vorstand.piratenpartei-mv.de/wp-content/plugins/_antrag/antrag.php", "302");

echo '<h2>FTP <small>ftp.piratenpartei-mv.de</small></h2>';

assertPortUp("service.piratenpartei-mv.de", 21);

echo '<h2>Redmine <small>redmine.piratenpartei-mv.de</small></h2>';

assertStatusEQ("https://redmine.piratenpartei-mv.de/", "200");
assertRedirectionEQ('https://redmine.piratenpartei-mv.de/redmine/', 'https://redmine.piratenpartei-mv.de/');
assertRedirectionEQ('http://redmine.piratenpartei-mv.de/redmine/', 'https://redmine.piratenpartei-mv.de/');
assertRedirectionEQ('http://redmine.piraten-mv.de/redmine', 'https://redmine.piratenpartei-mv.de');
assertTitleEQ("https://redmine.piratenpartei-mv.de/", "Piraten MV");
assertStatusEQ("https://redmine.piratenpartei-mv.de/projects/arbeitsamt/issues.json", "200");
assertStatusEQ("https://redmine.piratenpartei-mv.de/projects/vorstand/issues/new", "302");

echo '<h2>Jenkins <small>service.piratenpartei-mv.de:8080</small></h2>';

assertStatusEQ("http://service.piratenpartei-mv.de:8080", "403");

echo '<h2>Dashboard <small>dashboard.piratenpartei-mv.de</small></h2>';

assertStatusEQ("http://dashboard.piratenpartei-mv.de", "200");
assertStatusEQ("http://dashboard.piraten-mv.de", "301");


echo '
      </div><!-- /span14 -->
    </div><!-- /row -->
  </section>

  </div> <!-- /container -->

  <footer class="footer">
       <div class="container">
         <p class="pull-right"><a href="#">zurück nach oben</a></p>
         <p>
           Designed and built with all the love in the world <a href="http://twitter.com/twitter" target="_blank">@twitter</a> by <a href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a href="http://twitter.com/fat" target="_blank">@fat</a>.<br />
           Code licensed under the <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>.
         </p>
       </div>
     </footer>

      </body>
    </html>

';


?>
