<?php 
session_start();
// error_reporting(0);
$ghabli = "";
if(isset($_COOKIE['ghabli']))
  $ghabli = '<a style="font-size:11px;" download="output.txt" href="txt/'.$_COOKIE['ghabli'].'" class="btn btn-primary btn-xs" id="txt-eg" onclick="saveastxt()"> '.$_COOKIE['ghabli'].'</a>';

if(isset($_GET['lang']))
  if($_GET['lang']=="fa" || $_GET['lang']=="en")
    $_SESSION['lang'] = $_GET['lang'];


  if(isset($_SESSION['lang']))
    $lang = $_SESSION['lang'];

  else $lang = "fa";

  include_once 'langs/'.$lang.'.php';

  ?>
<!-- 
  
  ========================================================================================================
  ========================================================================================================
  ==================================== Farid Froozan - www.faridfr.ir ====================================
  ================================== info@faridfr.ir | froozan@yahoo.com =================================
  ========================================================================================================
  ========================================================================================================

-->


<?php include_once 'analysis.php'; ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

  <script src="source/jquery-2.0.3.min.js"></script>
  <script src="source/cytoscape.min.js"></script>
  <script src="source/dagre.min.js"></script>
  <script src="source/cytoscape-dagre.js"></script>
  <link rel="stylesheet" href="source/css/font-awesome.css">
  <link rel="stylesheet" href="source/css/bootstrap.css">
  <link rel="stylesheet" href="source/css/customise.css">

  <?php 
  if($lang=="fa")
    echo "  <link rel='stylesheet' href='source/css/bootstrap-rtl.min.css'> ";

  else {
    echo"<style> *{direction:ltr;} </style>";
  }
  ?>

  <link rel="stylesheet" href="source/css/animate.css">

  <meta charset="UTF-8">
  <title><?=BROWSER_TITLE?></title>

</head>
<body>

<img src="source/496.gif"  alt="loading" style="display:none; width:100%;" class="img-responsive">


  <?php 
  if(!empty($error)) 
  {
    ?>
    <script>
      $(window).load(function(){
        $('#myModal').modal('show');
      });

    </script>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">خطا</h4>
          </div>
          <div class="modal-body">
            
            <?php echo $error; ?>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
  ?>
  


  <script>
    function showleft(){
      $("#draw").hide();
      $("#show").hide();
      $("#img-left").fadeOut('500');
      $("#cih").delay('800').fadeIn('2000');

    }

    function drawfunc(){

      $("#show").hide();
      $("#cih").hide();

      $("#img-left").fadeOut('500');
      $("#draw").delay('800').fadeIn('2000');

    }


    function showwhat(){
      $("#draw").hide();
      $("#img-left").fadeOut('500');


      $("#cih").hide();
      $("#show").delay('800').fadeIn('2000');

    }


  </script>

  <div class="container">

    <div class="row faridfrshadow animated fadeInDown" style="margin-top:70px; margin-bottom:45px; ">
      <div class="col-lg-4" ><a href="" style=" z-index:99999999; color:#272822;"><h1 style="text-align:<?=ALIGN_R?>;"><?=TITLE?><sub>
        <h6 style="text-align:<?=ALIGN_R?>; font-size:9px; margin-top:-5px;">
          <i class="fa fa-github" aria-hidden="true"></i> <?=FREE_IN_GITHUB?> </h6></sub>


        </h1></a></div>

        <?php if(!$draw) { ?>
        <div class="col-lg-7 "> 
          <hr  style=" margin-<?=ALIGN?>:35px; margin-top:40px; border-top: 0.1px dashed grey; opacity:0.6; ">
        </div>
        <?php } else { ?>
        <div class="col-lg-7  animated flash" style="margin-top:30px;"> 
         <center>  <a style="font-size:11px;" download="FaridFr.ir.png" href="" class="btn btn-primary btn-xs" id="png-eg" onclick="saveaspng()" data-toggle="tooltip" data-placement="bottom" title="<?=DLNOTICE?>"> <?=SAVEAS?> PNG</a>  
          <a style="font-size:11px;" download="FaridFr.ir.jpg" href="" class="btn btn-primary btn-xs" id="jpg-eg" onclick="saveasjpg()"  data-toggle="tooltip" data-placement="bottom" title="<?=DLNOTICE?>"> <?=SAVEAS?> JPG</a> 
          <a style="font-size:11px;" download="output.txt" href="txt/<?php echo $_FILES['myfile']['name'];?>" class="btn btn-primary btn-xs" id="txt-eg" onclick="saveastxt()"> <?=SAVEAS?> TXT</a>
          <a style="font-size:11px;" download="FaridFr.ir.jpg" href="" class="btn btn-info btn-xs" disabled="disabled" id="jpg-eg" onclick="saveasjpg()"> <?=SAVEAS?> JSON</a>
          <a style="font-size:11px;" download="output.txt" href="" class="btn btn-info btn-xs" disabled="disabled" id="jpg-eg" onclick="saveasjpg()"> <?=SAVEAS?> LATEX</a>
        </center> 
      </div>
      <?php } ?>
      <div class="col-lg-1" style="padding-top:33px;  z-index:99999999;">
        <?php 

        if($lang=="fa")
          echo '<a href="?lang='.LANG_CHANGE.'" style=" float:'.ALIGN_R.'; font-size:12px; color:grey;"> English <img src="source/en.png"  class="img-responsive" style="margin:auto; display:inline;">  </a>';


        else 
          echo '<a href="?lang='.LANG_CHANGE.'" style=" float:'.ALIGN_R.'; font-size:12px; color:grey;"> فارسی <img src="source/fa.png"  class="img-responsive" style="margin:auto; display:inline;">  </a>';


        ?> 
      </div>

    </div>



    <div class="row animated fadeIn" style="margin-top:30px; background-color:#272822;    border: 2px solid;    border-radius: 15px;"> 
     <div class="col-lg-5 ">

      <style>
       input[type='file'] {
        opacity:0    
      }
    </style>


    
    <form action="" method="POST"  enctype="multipart/form-data">
     <input type="file" name="myfile"  class="form-control">
     <div class="alert alert-info ">

       <i class="fa fa-upload" aria-hidden="true"></i>  <?=SELECT_FILE?> 
       <a class="btn btn-primary btn-xs" style="float:<?=ALIGN_R?>;" onclick="showleft()"><?=CIH?></a>
     </div>
     <input type="submit" id="val" value="<?=SELECT_FIRST?>" class="form-control" style="display:none; margin-bottom:15px;">
     
     
   </form>


   <div id="rightinfo">



     <!--collapse start-->
     <div class="panel-group m-bot20" id="accordion" >

       <?php 
       if($draw)
       {
        ?>

        <script>
          

          $(function () {
            
            $('[data-toggle="popover"]').popover({
              html:true
            })

          }) 

          $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          })           
        </script>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseinfo"><i class="fa fa-bars" aria-hidden="true"></i> <?=INFO?>  

              </a> 
              <p id="aghafarid" style="display:inline;" type="button" class="" data-container="#aghafarid" data-toggle="popover" data-placement="top" data-content="
              <p style='font-size:12px; text-align:<?=ALIGN?>'> <?=FILE_NAME?>: <?=$_FILES['myfile']['name']?><br>
                <?=FILE_SIZE?> : <?=$_FILES['myfile']['size']?> <?=KB?><br>
                <?=FILE_TYPE?> : <?=$_FILES['myfile']['type']?><br>
                <?=FILE_UPTIME?> : <?php date_default_timezone_set('Asia/Tehran'); 
                echo date('h:i:s'); ?>

              </p>

              ">
              <a  style="display:inline; font-size:10px; float:<?=ALIGN_R?>;"> ( <i class="fa fa-info-circle" aria-hidden="true"></i> <?=FILE_INFO?> )  </a>
            </p>
          </h4>
        </div>
        <div id="collapseinfo" class="panel-collapse collapse in">
          <div class="panel-body">

            <style>
              .nopadding {
               padding: 0 !important;
               margin: 0 !important;
             }
           </style>



           
           <div class="row" style="margin-left:2px; margin-right:2px; margin-top:0px;">
            <div class="col-lg-6 nopadding"> <p style="color: white;background-color: #00B16A; text-align:center; font-size:10px; padding-top:5px; padding-bottom:5px;"><?=START_STATE?></p></div>
            <div class="col-lg-6 nopadding"> <p style="color: white;background-color: #F64747; text-align:center; font-size:10px; padding-top:5px; padding-bottom:5px;"><?=FINAL_STATE?></p></div>
          </div>
          <div class="row" style="margin-left:2px; margin-right:2px; margin-top:0px;">
           <div class="col-lg-12 nopadding"> <p style="color: white;background-color: #286090; text-align:center; font-size:10px; padding-top:5px; padding-bottom:5px;">

            <?=ALPHA?> : <?=$number_of_alphabets_character?> - <?=STATES?> : <?=$number_of_states?>
          </p></div>
        </div>

        

        <div class="col-lg-6 nopadding">

          <div class="panel panel-default">
            <div class="panel-heading" style="font-size:10px;"><?=FINAL_STATES?></div>
            <div class="panel-body">
              <?php echo "<pre style='direction:ltr; font-size:10px; color: red; height:160px; overflow-y:scroll;'>";
              foreach ($final_for_search as $na) {
                echo $na."<br>"  ;
              }
              echo "</pre>";
              ?> 
            </div>
          </div>


          
        </div>
        <div class="col-lg-6 nopadding">

          <div class="panel panel-default">
            <div class="panel-heading" style="font-size:10px;"><?=FINAL_ARROWS?></div>
            <div class="panel-body">
              <?php echo "<pre style='direction:ltr; font-size:10px; color: red; height:160px; overflow-y:scroll;'>";
              echo $output_line1."<br>";
              echo $output_line2."<br>";
              foreach ($final_for_search as $state) {

                foreach ($alphabets as $char) {
                  $output_line = $state." ".$arrows[$state][$char]." ".$char;                     
                  echo $output_line."<br>";          

                } }

                echo "</pre>";
                ?> 
              </div>
            </div>

            
          </div>
          
        </div>
      </div>
    </div>
    <?php
  }
  ?>
  


  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
         <i class="fa fa-info" aria-hidden="true"></i> <?=HELP?></a>
       </h4>
     </div>
     <div id="collapseOne" class="panel-collapse collapse ">
      <div class="panel-body">
        <p style="text-align:justify;">
          <?=COLLAPSE_ONE?>               
        </p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-hdd-o" aria-hidden="true"></i>  <?=PREVIOUS?> 
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">

        <?php echo $ghabli; ?>

      </div>
    </div>
  </div>




  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-user" aria-hidden="true"></i> <?=ABOUT_ME?> 
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">


        <aside class="profile-nav alt green-border">
          <section class="panel">
            <div class="user-heading alt green-bg">
              <a href="#">
                <img alt="" src="source/f1.jpg">
              </a>
              <h1><?=MY_NAME?> </h1> 
              <p>www. FaridFr .ir</p>

              <a style="color:black;" target="_blank" href="http://instagram.com/faridfroozan"><i class="fa fa-instagram" aria-hidden="true"></i></a>  
              <a style="color:black;" target="_blank" href="https://github.com/faridfr"><i class="fa fa-github" aria-hidden="true"></i></a>  
              <a style="color:black;" target="_blank" href="https://ir.linkedin.com/in/faridfroozan"><i class="fa fa-linkedin" aria-hidden="true"></i></a> <br>

              <?=THANKS?>
            </div>



          </section>
        </aside>


      </div>
    </div>
  </div>
</div>
<!--collapse end-->


</div>
<script>
 $('#button').click(function(){
   $("input[type='file']").trigger('click');
 })

 $("input[type='file']").change(function(){
   $('#val').val(this.value.replace(/C:\\fakepath\\/i, '') + ' > <?=CLICK_FOR_UPLOAD?>')
   $('#val').css('display','inline')
 })  

</script>	

</div>



<?php include_once 'leftcolumn.php'; ?>





<div class="row  animated fadeInUp" style="margin:0px; padding-top:10px;">

 <?php 
 if($lang=="fa")
  echo '  <div class="col-lg-6" style="text-align:right;   font-size:9px; margin-left:-10px;">کپی رایت برای فرید فروزان محفوظ است @1395 تحت لایسنس : <a href="https://opensource.org/licenses/MIT" target="_blank" style="color:black;">MIT</a> برای پروژه های متن باز </div>  <div class="col-lg-6" style="text-align:left;  font-size:10px;">

</div>  <div class="col-lg-6" style="text-align:left; font-size:9px;" onclick="drawfunc()"> بیایید یک آتاماتا بکشیم :) </div> ';

else {
  echo '<div class="col-lg-6" style="text-align:left;   font-size:9px;">Copyright for Farid Froozan @2015 under license : <a href="https://opensource.org/licenses/MIT" target="_blank" style="color:black;">MIT</a> for open source projects  </div>  <div class="col-lg-6" style="text-align:right;  font-size:10px;">

</div><div class="col-lg-6" style="text-align:right; font-size:9px;" onclick="drawfunc()">  Lets draw an automata :) </div> ';
}
?>




<h6 style="text-align:left; margin-left:-15px; margin-top:20px; font-size:9px;"> </h6>
<h6 style="display:inline-block; text-align:right; margin-right:-15px; margin-top:20px; font-size:9px;"> </h6>

</div>
</div>

</div>

    <script src="source/js/bootstrap.min.js"></script>
    

</body>
</html>