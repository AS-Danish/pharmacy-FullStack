<?php
    require_once "connection.php";
    include("header.php");

    $sql = "SELECT * from `medicines`";
    $all_meds = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacy</title>
    <link rel="stylesheet" href="CSS/style.css?v=<?php echo time();?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

    <section id = "HOME">
        <div class="container-hero m-5 p-4 my-2 rounded-5 bg-light d-flex justify-content-center align-items-center">
            <div class="hero text-center">
                <h1 class="display-5 fw-bold">Pharmacy Website</h1>
                <p class= "md-8 lead">Step into a Sanctuary of Healing, Where Every Prescription Is Filled with Precision, Guiding You on a Journey Towards Optimal Wellness and Vibrant Living, Because Your Health Is Our Priority.</p>
                <button class="btn btn-primary btn-md" onclick="document.getElementById('CATALOG').scrollIntoView();">PROTECT MYSELF</button>
            </div>
        </div>
    </section>

    <section id="CATALOG">
        <div class="catalog py-5">
        <h1 class="display-5 fw-bold mb-0 text-center">Medicines</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4 py-5 mb-0">

                <?php
                    while($row = mysqli_fetch_assoc($all_meds)){

                ?>
                <div class="col">
                    <form action="manage_cart.php" method="POST">
                        <div class="card">
                            <img src="<?php echo $row['med_img']; ?>" class = "card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['med_name']; ?></h5>
                            </div>
                            <div class="d-flex justify-content-around mb-5">
                                <h3><?php echo $row['med_price']; ?>$</h3>
                                <button name = "Add_to_Cart" class = "btn btn-primary addToCart" type="submit">Add to Cart</button>
                                <input type="hidden" name="Item_Name" value = "<?php echo $row['med_name']; ?>">
                                <input type="hidden" name="Price" value = "<?php echo $row['med_price']; ?>">
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                    }
                ?>
    
            </div>
        </div>
    </section>

    <section id = "ABOUT">
        <div class="container-about m-5 p-4 my-2 rounded-5 bg-light d-flex justify-content-center align-items-center">
            <div class="hero text-center">
                <h1 class="display-5 fw-bold my-2">About Us</h1>
                <p class= "md-8 lead m-5">At our pharmacy, we're dedicated to enhancing lives through personalized care and professional 
                    expertise. With a commitment to your health and well-being, we stand as your trusted partner in achieving 
                    optimal wellness. Welcome to a place where compassion, knowledge, and community 
                    converge for a healthier tomorrow.</p>
                <button class="btn btn-outline-primary btn-lg">Learn More</button>
            </div>
        </div>
    </section>

    <section id = "Contact">
            <h1 class="display-5 fw-bold my-4 text-center">Contact Us</h1>
            <div class="form-area">
                <div class="container">
                    <div class="row single-form g-0">
                        <div class="col-sm-12 col-lg-6">
                            <div class="left">
                                <h2><span>Contact Us For</span> <br>Medicine Purchase</h2>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="right">
                                <div class="fa fa-caret-left">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Your Message</label>
                                        <textarea class="form-control" id="exampleInputPassword1"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <footer class="bg-dark py-5 mt-5">
                    <div class="container text-light text-center">
                        <p class="display-5 mb-3">Pharmacy</p>
                        <small class="text-white-50">&copy; Copyright By ByteGrad. All rights reserved</small>
                    </div>
    </footer>

    <script>
        function scroll(){
            window.location = "#CATALOG";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>