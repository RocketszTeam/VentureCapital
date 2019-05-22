<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php if(isset($bannerList)):?>
          <?php foreach($bannerList as $keys => $row):?>
            <div class="item <?php if($keys==0) echo ' active'?>">
                <img src="<?php echo UPLOADS_URL?>/banner/<?php echo $row["pic"]?>" alt="<?php echo $row["subject"]?>">
            </div>
          <?php endforeach;?>
        <?php endif;?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
