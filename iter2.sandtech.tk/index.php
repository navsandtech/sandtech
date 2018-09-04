<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" href="img/favicon.ico" />
  <title>Sandtech-Smart Travebility</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/fontAwesome.css">
  <link rel="stylesheet" href="css/light-box.css">
  <link rel="stylesheet" href="css/owl-carousel.css">
  <link rel="stylesheet" href="css/mystylesheet.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <script src="js/modernizr-2.8.3-respond-1.4.2.min.js"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
  <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

</head>

<body>

  <!-- PHP Script for database connection and getting data -->
  <?php
$servername = "pdb28.awardspace.net";
$username = "2793439_sandtechschema";
$password = "mathematics91";
$dbname = "2793439_sandtechschema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
  
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else  {
  $sqlLocation = "SELECT loc_id,name,theme,sub_theme, X(coordinate) as lat,Y(coordinate) as lon FROM location";
  $sqlParking = "SELECT park_id,name,total_disable_park FROM parking";
  $sqlToilet = "SELECT toilet_id,name,total_no,wheelchair FROM public_toliet";
  $sqlFeatures = "SELECT feat_id,name,des,sub_des FROM features";
}  
  $resultLocation = $conn->query($sqlLocation);
  $resultParking = $conn->query($sqlParking);
  $resultToilet = $conn->query($sqlToilet);
  $resultFeatures = $conn->query($sqlFeatures);
  
/* creating local objects */   
   echo "
            <script type=\"text/javascript\">
               var objectLocation = [];
               var objectParking = [];
               var objectToilet = [];
               var objectFeatures = [];
            </script>
        ";
/* fetch object arrays */   
if ($resultLocation->num_rows > 0) {
    // output data of each row
   while ($objLocation = $resultLocation->fetch_object()) {       
        $myJSONLocation = json_encode($objLocation); 
         echo "
            <script type=\"text/javascript\">    
                objectLocation.push($myJSONLocation);
            </script>
        ";
    }
}
 else {
    echo "Database Error1";
}
  if ($resultParking->num_rows > 0) {
    // output data of each row
   while ($objParking = $resultParking->fetch_object()) {       
        $myJSONParking = json_encode($objParking); 
         echo "
            <script type=\"text/javascript\">    
                objectParking.push($myJSONParking);
            </script>
        ";
    }
}
 else {
    echo "Database Error2";
}
  if ($resultToilet->num_rows > 0) {
    // output data of each row
   while ($objToilet = $resultToilet->fetch_object()) {       
        $myJSONToilet = json_encode($objToilet); 
         echo "
            <script type=\"text/javascript\">    
                objectToilet.push($myJSONToilet);
            </script>
        ";
    }
}
 else {
    echo "Database Error3";
}
  
  if ($resultFeatures->num_rows > 0) {
    // output data of each row
   while ($objFeatures = $resultFeatures->fetch_object()) {       
        $myJSONFeatures = json_encode($objFeatures); 
         echo "
            <script type=\"text/javascript\">    
                objectFeatures.push($myJSONFeatures);
            </script>
        ";
    }
}
 else {
    echo "Database Error4";
}
$conn->close();
?>

    <div id="loadingpage" class="loader"></div>

    <div id="myNav" class="overlay">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <h1 class="popupdata">
          <b><div id="popupTitle" style="text-decoration: underline"></div></b><br>
        </h1>
        <h4 class="popupdata">
          <div id="popupData"></div><br><br>
          
<!--           <div id="popupTheme"></div><br>
          <div id="popupSubTheme"></div><br>
          <div id="popupParking"></div><br>
          <div id="popupToilet"></div><br>
          <div id="popupWheelchairAccess"></div><br> -->
          <br>
        More Info at:
        <a href="" id="popupLink" target="_blank" style="font-size: 20px"></a>
        </h4>
           
      </div>
    </div>


    <header class="nav-down responsive-nav hidden-lg hidden-md">
      <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
      <!--/.navbar-header-->
      <div id="main-nav" class="collapse navbar-collapse">
        <nav>
          <ul class="nav navbar-nav">
            <li><a href="#top">Home</a></li>
            <li><a href="#location">Featured Locations</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#aboutus">About Smart Travebility</a></li>
            <li><a href="#contact">Contact Us</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="sidebar-navigation hidde-sm hidden-xs">
      <div class="logo">
        <a href="#"><img id="logoimage" src="img/logosandtech.png" alt="SandTech">
        <div> <h4 style="color:white">
          Smart Travebility
          </h4>  
        </div>   
        </a>
      </div>

      <nav>
        <ul>
          <li>
            <a href="#top">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            Home
                        </a>
          </li>
       
          <li>
            <a href="#location">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            Featured Locations
                        </a>
          </li>
          <li>
            <a href="#gallery">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            Gallery
                        </a>
          </li>
             <li>
            <a href="#aboutus">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            About Smart Travebility
                        </a>
          </li>
          <li>
            <a href="#contact">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            Contact Us
                        </a>
          </li>
        </ul>
      </nav>
     <!--  <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-google"></i></a></li>
               <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-rss"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
          </ul>-->
    </div>

    <div class="slider">
      <div class="Modern-Slider content-section" id="top">
        <!-- Item -->
        <div class="item item-1">
          <div class="img-fill">
            <div class="image"></div>             
            <div class="info">
              <div>
                 <div class="searchClass">
                    <h3>Don't Know Where to Go?</h3>
                <p></p>
                <div class="white-button button">
                  <a href="#location">Search</a>
                </div>
                </div>
               
                
                <h1>Smart<br>Travebility</h1>
                <p></p>
                <div class="white-button button">
                  <a href="#location">Discover More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- // Item -->
        <!-- Item -->
        <div class="item item-2">
          <div class="img-fill">
            <div class="image"></div>
            <div class="info">
              <div>
                <h1>Easy and<br> Convenient<br></h1>
                <p></p>

                <div class="white-button button">
                  <a href="#location">Discover More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- // Item -->
        <!-- Item -->
        <div class="item item-3">
          <div class="img-fill">
            <div class="image"></div>
            <div class="info">
              <div>
                <h1>Travel<br>with Ease</h1>
                <p></p>

                <div class="white-button button">
                  <a href="#location">Discover More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- // Item -->
      </div>
    </div>

    <div class="page-content">
   
      
      <section id="location" class="content-section">
        <div class="section-heading">

          <h1>Featured <em>Locations</em></h1>
          <p></p>
        </div>
        <div class="section-content">
          <div id="mapid"></div>
        </div>        
      </section>
      
  

      <section id="gallery" class="content-section">
        <div class="section-heading">
          <h1><em>Gallery</em></h1>
          <p></p>
        </div>
        <div class="section-content">
          <div class="masonry">
            <div class="row">

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1MelbMeuAccsToilet.jpg" data-lightbox="image"><img src="img/MelbMeuAccsToilet.jpg" alt="image 2"></a>
                </div>
              </div>

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1BotanicD.JPG" data-lightbox="image"><img src="img/BotanicD.JPG" alt="image 1"></a>
                </div>
              </div>

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1MelbMeuCarParkGate.JPG" data-lightbox="image"><img src="img/MelbMeuCarParkGate.jpg" alt="image 5"></a>
                </div>
              </div>

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1MelbMeuWalkway.JPG" data-lightbox="image"><img src="img/MelbMeuWalkway.jpg" alt="image 3"></a>
                </div>
              </div>

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1BotanicC.JPG" data-lightbox="image"><img src="img/BotanicC.JPG" alt="image 4"></a>
                </div>
              </div>

              <div class="item">
                <div class="col-md-4">
                  <a href="img/1ZooStairs.jpeg" data-lightbox="image"><img src="img/ZooStairs.jpeg" alt="image 4"></a>
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>    
    </section>
  
     <section id="aboutus" class="content-section">
        <div class="section-heading">
          <h1>About <em>Smart Travebility</em></h1>
        </div>
        <div class="section-content">
          <p align="left">Getting out and about in a city the size of Melbourne with a disability has its challenges.
             <br><br><br>A truly accessible city would strive to implement as many aids around the city to help the disabled.  Thankfully, current technology has enabled people to find accessible amenities with a simple internet search.  The problem is, all this information is sitting in disparate places.  At Smart Travebility, we are not just bringing all this information into one website, but also telling you about the unexpected things.  Things like narrow ramps that were built in the 70's and toilet blocks surrounded by grass which are difficult to traverse in a wheelchair.  It is the unexpected things that cause the most inconvenience.  Smart Travebility provides you with easy access to this information so that your trip around the great city of Melbourne can be pleasant.
              <br><br><br>The Australian Standards for Access and Mobility (AS 1428) prescribes the basic requirements for physical access which should be considered in the planning, development and construction of buildings and facilities.  Not all premises currently comply with these standards.  Descriptions of a venue and its facilities on this website does not imply that the venue currently meets the requirements for access, as required under AS 1428.  Rather, this website is intended to provide you with information that can assist you to choose a venue that fits in with your individual requirements.</p>
        </div>
      </section>
  
    <section id="contact" class="content-section">
      <div id="contact-content">
        <div class="section-heading">
          <h1>Contact <em>Us</em></h1>
          <h4>SandTech-Smart Travebility</h4>
        </div>
        <p align="left" style="font-size: 14px"><b>Email Us at</b>
          <br> <a href="mailto:admin@sandtech.tk?Subject=" target="_top">admin@sandtech.tk</a>
          <br><a href="mailto:monashsandtech@gmail.com?Subject=" target="_top">monashsandtech@gmail.com</a>
          <br>Team Details: TP262
        </p>
        <br><br><br><br>
        <h5>
          Disclaimer
        </h5>
        <p style="font-size: 13px">An access audit has not been undertaken of the premises featured on this website. SandTech do not take responsibility for any omissions, errors or actions taken as a result of the information provided, nor any decisions made by patrons based on this information.<p>
      </div>
    </section>
  
    <section class="footer">
      <p>Copyright &copy; 2018 SandTech.</p>
    </section>
 
    </div>
  </div>

    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="js/indexcontroller.js"></script>

    <script>
      // Hide Header on on scroll down
      var didScroll;
      var lastScrollTop = 0;
      var delta = 5;
      var navbarHeight = $('header').outerHeight();

      $(window).scroll(function(event) {
        didScroll = true;
      });

      setInterval(function() {
        if (didScroll) {
          hasScrolled();
          didScroll = false;
        }
      }, 250);

      function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
          return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
          // Scroll Down
          $('header').removeClass('nav-down').addClass('nav-up');
        } else {
          // Scroll Up
          if (st + $(window).height() < $(document).height()) {
            $('header').removeClass('nav-up').addClass('nav-down');
          }
        }

        lastScrollTop = st;
      }
    </script>

    <script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

</body>
</html>