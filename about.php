<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/globalHead.html'); ?>
    <title>Discussion Board &mdash; About</title>
    <script>
        $(document).ready(function() {
            $('.ui.embed').embed({
                source      : 'youtube',
                id          : '752tGFuihzM',
                placeholder : 'src/img/videoPlaceholder.jpg'
            });
        });
    </script>
</head>
<body>

<?php 
    include('includes/menu.php');
    drawMenu("about");
?>

<div id="mainContainer">
  
    <div class="ui vertical segment">
        <h2 class="ui header">
            <i class="photo icon"></i>
            <div class="content">
                Photos
            </div>
        </h2>
        <h4>Look at some of these interesting things</h4>
        <div class="ui medium images">
            <img class="ui bordered image" src="src/img/img1.jpg">
            <img class="ui bordered image" src="src/img/img2.jpg">
            <img class="ui bordered image" src="src/img/img3.jpg">
            <img class="ui bordered image" src="src/img/img4.jpg">
        </div>
    </div>
    
    <div class="ui vertical segment">
        <h2 class="ui header">
            <i class="film icon"></i>
            <div class="content">
                Multimedia
            </div>
        </h2>
        <h4>A representation of trying to finish this project on time</h4>
        <div class="ui embed"></div>
    </div>
    
</div>

<?php //include('includes/footer.html'); ?>

</body>
</html>
