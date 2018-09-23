        <div class="footer" >
            <footer class="section footer-classic context-dark bg-image" style="background: #2d3246; margin-top:20px">
        <div class="container">
          <div class="row row-30">
            <div class="col-md-4 col-xl-5">
              <div class="pr-xl-4" style="margin-top:20px;">
                <p>We are an award-winning creative agency, dedicated to the best result in web design, promotion, business consulting, and marketing.</p>
                <!-- Rights-->
                <p class="rights"><span>©  </span><span class="copyright-year">2018</span><span> </span><span>Waves</span><span>. </span><span>All Rights Reserved.</span></p>
              </div>
            </div>
            <div class="col-md-4">
              <h5>Contacts</h5>
              <dl class="contact-list">
                <dt>Address:</dt>
                <dd>47 Ibrahim radi street</dd>
              </dl>
              <dl class="contact-list">
                <dt>email:</dt>
                <dd><a href="mailto:#">Omarbnzaky@gmail.com</a></dd>
              </dl>
              <dl class="contact-list">
                <dt>phones:</dt>
                <dd><a href="tel:#">+91 7568543012</a> <span>or</span> <a href="tel:#">+91 9571195353</a>
                </dd>
              </dl>
            </div>
            <div class="col-md-4 col-xl-3">
              <h5>Links</h5>
              <ul class="nav-list">
 <?php          foreach($myCats as $Cat){
                  echo '<li class="nav-item "><a  href="categories.php?pageid='.$Cat['ID'].'&pagename='.str_replace(' ','-',$Cat['Name']).'"> >>'
                      .$Cat['Name'].
                      '</a>
                      </li>';
       } ?>
              </ul>
            </div>
              
              	<div class="row text-center">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
					<ul class="list-unstyled list-inline social text-center">
						<li class="list-inline-item"><a href="https://www.facebook.com/mortadawia"><i class="fa fa-facebook"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-codepen"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-youtube-play"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-google-plus"></i></a></li>
						<li class="list-inline-item"><a href="javascript:void();" target="_blank"><i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
          </div>
        </div>
            </footer>
        </div>
        <script src="<?php echo $js;?>jquery-1.12.4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
            
        <script src="<?php echo $js;?>bootstrap.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script src="<?php echo $js;?>front.js"></script>
        <script src="<?php echo $js;?>charge.js"></script>
   </body>
</html>