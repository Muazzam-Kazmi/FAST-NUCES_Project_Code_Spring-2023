<nav class="site-nav mt-3">
    <div class="container">
        <div class="site-navigation">
            <a href="./" class="logo m-0 mt-2 float-start">
                <img
                    src="https://www.anomoz.com/style/logo.png" 
                    style="height:40px;"
                    alt="Image"
                    class="img-fluid"
                />
            </a>
            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">
                <li class="active"><a href="./">Home</a></li>
                <?if($logged==0){?>
                    <li ><a href="./login.php">Login</a></li>
                <?}else{?>
                    <li ><a href="./home.php">Dashboard</a></li>
                    <li ><a href="./?logout=1">Logout</a></li>
                <?}?>
            </ul>
            <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
    </div>
</nav>
