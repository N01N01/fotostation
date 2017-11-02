<nav class="navbar" style="display: none">
    <div class="container<?=session("uid")?"-fluid":""?>">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <?php if(session("uid")){?>
            <a href="javascript:void(0);" class="bars"></a>
            <?php }?>
            <a class="navbar-brand text-center" href="<?=PATH?>"><img src="<?=LOGO?>" title="" alt=""></a>
        </div>
        
        

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav top-menu right mr0">
                <?php if(LOGIN_TYPE == 1){?>
                    <?php if(!session("uid")){?>
                    <?php if(REGISTER_ALLOWED == 1){?>
                    <li class="li-register"><a href="javscript:void(0);" data-toggle="modal" data-target="#registerModal"><?=l('Register')?></a></li>
                    <?php }?>
                    <li style="display: none"><!-- set display none to login, cause the modal is already visible -->
                        <a href="javscript:void(0);" data-toggle="modal" data-target="#loginModal" href="<?=url("payments")?>" class="btn bg-light-green waves-effect" style="padding: 5px 10px;"><?=l('Login')?></a>
                    </li>
                    <?php }?>
                <?php }?>

            </ul>
        </div>
    </div>
</nav>