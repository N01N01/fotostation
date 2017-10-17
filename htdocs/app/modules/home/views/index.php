<?php if(LOGIN_TYPE == 2){?>
<div class="box-login">
  <div class="login-form">
    <ul class="login-nav" >
        <li class="bg-<?=THEME?> left active">
            <a href="<?=url("")?>"><?=l('Login')?></a>
        </li>
        <li class="right bg-<?=THEME?>">
            <a href="<?=url("register")?>"><?=l('Register')?></a>
        </li>
    </ul>
    <div class="clearfix"></div>
    <form action="<?=url('user_management/ajax_login')?>" data-redirect="<?=current_url()?>">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">person</i>
            </span>
            <div class="form-line">
                <input type="text" class="form-control" name="email" placeholder="<?=l('Email')?>" required autofocus>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
                <input type="password" class="form-control" name="password" placeholder="<?=l('Password')?>" required>
            </div>
        </div>
        <div class="input-group">
          <div class="another_action pull-left text-left">
            <input type="checkbox" id="md_checkbox_38" name="remember" class="filled-in chk-col-grey">
            <label for="md_checkbox_38"><?=l('Remember me')?></label><br/>
            <a href="<?=url("forgot_password")?>"><?=l('Forgot password')?></a>
          </div>
          <button type="submit" class="right btn bg-light-green waves-effect btnActionUpdate"><?=l('Login')?></button>
        </div>

        <?php if((FACEBOOK_ID != "" && FACEBOOK_SECRET != "") || (GOOGLE_ID != "" && GOOGLE_SECRET != "") || (TWITTER_ID != "" && TWITTER_SECRET != "")){?>
        <div class="clearfix"></div>
        <div class="login-social">
            <fieldset>
                <legend><span><?=l('OR LOGIN VIA')?></span></legend>
            </fieldset>
            <div class="list-social">
                <?php if(FACEBOOK_ID != "" && FACEBOOK_SECRET != ""){?>
                <a href="<?=url("oauth/facebook")?>" title=""><img src="<?=BASE?>assets/images/btn-facebook.png" title="" alt=""></a>
                <?php }?>
                <?php if(GOOGLE_ID != "" && GOOGLE_SECRET != ""){?>
                <a href="<?=url("oauth/google")?>" title=""><img src="<?=BASE?>assets/images/btn-google.png" title="" alt=""></a>
                <?php }?>
                <?php if(TWITTER_ID != "" && TWITTER_SECRET != ""){?>
                <a href="<?=url("oauth/twitter")?>" title=""><img src="<?=BASE?>assets/images/btn-twitter.png" title="" alt=""></a>
                <?php }?>
            </div>
        </div>
        <?php }?>
    </form>
  </div>
  <div class="copyright"><?=l('2017-till eternity © Magica Emi. All rights reserved.')?></div>
</div>
<?php }else{?>
<div class="homepage">
  <div id="hero">           
      <div class="container herocontent">               
          <div class="title uc"><?=l('THE ULTIMATE WAY TO HELP YOUR MARKETING EFFECTIVENESS ON FACEBOOK TODAY')?></div>                
          <div class="description">
            <?=l('Using social media is a fun and sure way to get new friends, customers and fans. Getting your Facebook profile out there for everyone to see is a hard and tedious task and time is very precious for all of us and promoting yourself on Facebook is a time-consuming everyday activity. Let it help you automate your daily activity and get you the crowd you deserve and desire')?>
          </div>            
      </div>
      <img class="heroshot" src="<?=BASE?>assets/images/hero-img.jpg">
  </div>

  <div id="services">
    <div class="container">
        <div class="sectionhead  row ">
            <span class="bigicon icon-cup "></span>
            <div class="title"><?=l('This is what can do for you')?></div>
            <hr class="separetor">
         </div>
        <div class="row">
           <div class="col-md-4 item">
               <img src="<?=BASE?>assets/images/s1.png" alt="">
               <h4><?=l('Post/Schedule')?></h4>
               <p><?=l('Post link, image, video and text to multi profiles, multi page, multi groups and special is post link to closed/secret groups')?></p>
            </div> 
            <div class="col-md-4 item">
               <img src="<?=BASE?>assets/images/s10.png" alt="">
               <h4><?=l('Report Schedule')?></h4>
               <p><?=l('Report all info for posted. For example: post success, failure, processing, repeat, ...')?></p>
            </div>

            <div class="col-md-4 item">
               <img src="<?=BASE?>assets/images/s12.png" alt="">
               <h4><?=l('Preview Post')?></h4>
               <p><?=l('Help you preview your post before publishing them')?></p>
            </div>
        </div>
        <div class="row">
          <p class="more text-center col-light-green uc"><?=l('And many more another feature...')?></p>
        </div>
    </div>
  </div>
</div>
<?=modules::run("blocks/footer")?>
<?php }?>

