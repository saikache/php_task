<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--css-->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>

<!--fontawsome close-->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<!--close-->
<!---js-->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/npm.js"></script>
<!--close-->
<title>QUIN</title>
</head>

<body>
<header>
  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-lg-12"> 
        <!--logo-->
        <div class="col-md-2 col-sm-2 col-xs-4 logo"> <span> <i class="fa fa-bars" aria-hidden="true"></i></span> <span> <img src="images/logo.png" /></span> </div>
        <!--logo-ends--> 
        <!---search-->
        <div class="col-md-6 col-sm-7 col-xs-6 mt-10">
          <input class="search" placeholder="Search" type="search" />
          <button class="search-btn" type="button"> <i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
        <!--search-ends--> 
        <!--signin upload-->
        <div class="col-xs-offset-0 col-md-offset-1 col-md-3 col-sm-2 col-xs-2 pd-0 up-data"> 
          <!-- upload-starts-->
          <div class="col-lg-4 col-md-5 col-sm-6 fileUpload text-center"> <span>Upload</span>
            <input type="file" class="upload" />
          </div>
          <!-- upload-ends--> 
          <!-- notification-starts-->
          <div class="notification col-md-2 text-center col-sm-3 mt-10 pd-0"> <i class="fa fa-bell-o" aria-hidden="true"></i> </div>
          <!-- notification-starts-->
          <div class="col-md-5 col-sm-offset-1 col-sm-4 sign-in pd-0 mt-10">
            <button type="button" class="cum-btn btn">Sign in</button>
          </div>
          <!-- notification-ends--> 
        </div>
        <!--signin upload ends--> 
      </div>
    </div>
  </div>
</header>
<hr class="cstm-hr">
<div class="container cont-bg">
  <div class="row">
  <?php
  /* Function That returns Difference of Time ,$time1 parameter is the timestamp of the created story time */

function datediff($time1)
{

$timestamp2 = StrToTime ( date("Y-m-d h:i:s") );
$hour = round(abs($timestamp2 - $time1)/(60*60));
if($hour>24)
{
  $difval = round(($hour/24));
  $ago = $difval."Days Ago";
	if($difval > 30)
	 {
	  $difval1 = round($difval / 30);
	  $ago =  $difval1." Months ";
		if($difval1 > 12)
			{
				$difval2=($difval1/12);
				$ago=$difval2 ."Years";
			}
	}
}
return $ago;
}

/* Fetches all content from Api in Json Format*/
  $content=file_get_contents("http://sketches.quintype.com/api/v1/stories");

/* Decoding  Json Formated Data into Array Fromat*/
  $allstories=json_decode($content,true);

/* function That returns  All Needed Data To Display in the Front End*/
function getstoryinfo($i)
{
	global $allstories;
	$baseurl="http://sketches.quintype.com/";
	$imgpath="http://quintype-01.imgix.net/";
	$title=$allstories['stories'][$i]['headline'];
	$imagefile=$allstories['stories'][$i]['hero-image-s3-key'];
	$image=$imgpath.$imagefile;
	$createdat=$allstories['stories'][$i]['content-created-at']; 
	$createdate=substr($createdat, 0, -3);
	$category=$allstories['stories'][$i]['sections'][0]['name']; 
	$createdbefore=datediff($createdate)." ago";
	$slug=$allstories['stories'][$i]['slug']; 
	$author=$allstories['stories'][$i]['author-name']; 
	$topicurl=$baseurl.$slug;
	$categoryurl=$baseurl."section/".$category; 

			$arr = array(
					'title'=>$title,
				    'url'=>$topicurl,
					'img'=>$image,
					'createdbefore'=>$createdbefore,
					'category'=>$category,
					'categoryurl'=>$categoryurl,
					'author'=>$author
				
						);
    return $arr;
}
/* Display 1st story */
	$data=getstoryinfo(0);

?>

    <div class="col-lg-12 col-xs-12 pd-0"> 
      <!--layer-->
      <div class="col-lg-6 col-sm-6 pd-0">
        <div class="col-lg-8 col-md-12 col-sm-12 grid-hilt">        
         <img class="img-responsive" src="<?php echo $data['img']; ?>" /> </div>
        <div class="custom-title col-lg-4 col-sm-12 ">
          <label><a href="<?php echo $data['url']; ?>"> <?php echo substr(substr($data['title'], 0, 30) . '...', 0, 30) . '...' ?> </a></label>
          <br/>
          <label class="text-set pt-10"> <a href="<?php echo $data['categoryurl']?> "><?php echo $data['category'] ?></a></label>
          <br/>
          <label class="text-set"><?php echo $data['author'];?> </label>
          
          <label class="text-set"></label>
          
          <label class="text-set"> <?php echo $data['createdbefore'];?> </label>
        </div>
      </div>
      <!--large-video ends--> 
      <!--small-3 videos-starts-->
      <div class="col-lg-6 col-sm-6 pd-0 side-list-grid">
      <?php 
	  /* Display Right 3 Stories*/
	  for($i=1;$i<4;$i++){
		  $data=getstoryinfo($i);
		  ?>  
		<div class="vid-list col-lg-12 mb-10">
          <div class="col-lg-4 col-sm-6 small-video "> <img class="img-responsive" src="<?php echo $data['img']; ?>" /> </div>
          <div class="col-lg-8 col-sm-6 pd-0">
            <label><a href="<?php echo $data['url']; ?>">  <?php echo substr($data['title'], 0, 25) . '...'; ?> </a></label>
            <br>
            <label class="text-set pt-10"> <a href="<?php echo $data['categoryurl']?>"><?php echo $data['category'] ?></a>
            </label>
            <br>
            <label class="text-set"> <?php echo $data['author'];?> </label>
            <label class="text-set"></label>
            <label class="text-set"> <?php echo $data['createdbefore'];?></label>
          </div>
        </div>

<?php } ?>

      </div>
      <!--small-3 videos-ends--> 
      
    </div>
  </div>
</div>
<hr class="cstm-hr">
<div class="container cont-bg">
  <div class="row">
    <div class="col-lg-12 pd-0">
       <?php 
	   /* Display all the 3rd row stories*/
	   for($i=4;$i<16;$i++){
		  $data=getstoryinfo($i);
		  ?> 
	  <div class="col-lg-2 col-sm-3 col-xs-6 mb-20 list-vd-grid"> <img class="img-responsive" src="<?php echo $data['img']; ?>" />
        <label class="pt-10"><a href="<?php echo $data['url']; ?>">  <?php echo substr($data['title'], 0, 25) . '...'; ?></a></label>
        <br>
        <label class="text-set pt-10"> <a href="<?php echo $data['categoryurl']?>"><?php echo $data['category'] ?></a></label>
        <br>
        <label class="text-set"><?php echo $data['author'];?> </label>
        <label class="text-set"></label><BR><BR>
        <label class="text-set"><?php echo $data['createdbefore'];?></label>
      </div>
<?php } ?>
  
    </div>
  </div>
</div>

</body>
</html>
