<header id="cart-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="index.php" class="navbar-brand">
            <img src="logo.png" class="px-5">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=navbarNavAltMarkup aria-controls="navbarNavAltMarkup" aria-expanded="false"     aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">
                <a href="cosCumparaturi.php" class="nav-item nav-link active">
                    <h5 class="px-5 cart"><i class="fa fa-shopping-cart"></i> Cos 
                        <?php 
                            if(isset($_SESSION['cart'])) {
                                $count = count($_SESSION['cart']);
                                if($count == 1) {
                                    echo "<span class='nr-produse-cos' id=\"nrProduseCart\">$count produs</span>";
                                } else {
                                    echo "<span class='nr-produse-cos' id=\"nrProduseCart\">$count produse</span>";
                                }
                            } else {
                                echo "<span class='nr-produse-cos' id=\"nrProduseCart\">0 produse</span>";
                            }
                        ?>
                    </h5>
                </a>
            </div>

            <!-- logout button --> 
            <button onclick="logoutConfirm()" class="btn btn-outline-success my-2 my-sm-0">Logout</button>
        </div>  
    </nav>  
</header>