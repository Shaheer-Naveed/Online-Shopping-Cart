<?php
include('connection.php');
include('header.php');

$q2 = "SELECT * FROM feedback ORDER BY id DESC LIMIT 4";
$result2 = mysqli_query($conn, $q2);

if (!$result2 || mysqli_num_rows($result2) == 0) {
    echo '<p>No testimonials available</p>'; // Fallback message
}

$q= "select * from add_category";
$result = mysqli_query($conn, $q);

$query = "select add_product.Id,add_product.Product_Code,add_product.Product_Name,add_category.Category AS Product_Category,add_sub_category.Category AS Product_Sub_Category,add_product.Price,add_product.Warranty,add_product.Description,add_product.Product_Image from add_product
Join add_category on add_product.Product_Category = add_category.Id
Join add_sub_category on add_product.Product_Sub_Category = add_sub_category.Id
LIMIT 3";
$result = mysqli_query($conn, $query);
?>
	<!-- end features list section -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Our</span> Products</h3>
						<p>Discover a world of style and convenience with our curated collection of makeup, wallets, bags, and pots. Elevate your everyday essentials with quality and elegance!"</p>
					</div>
				</div>
				</div>
			<div class="row">
			<?php          
                            while ($data = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
					<div class="single-product-item mb-50 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                    <div class="popular-img">
                        <img src="../admin/<?php echo $data['Product_Image']?>" height="300px" >
                        <div class="favorit-items">
                            <!-- <span class="flaticon-heart"></span> -->
                            <img src="assets/img/gallery/favorit-card.png" alt="">
                        </div>
                    </div>
                        <h3><?php echo $data['Product_Name']; ?></h3>
						<p class="product-price">Rs:<?php echo $data['Price']; ?> </p>
						<a href="shop.php" class="cart-btn"><i class="fas fa-eye"></i>  View Product</a>
                </div>
                 </div>  
				 <?php }?>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- cart banner section -->
	<section class="cart-banner pt-100 pb-100">
    	<div class="container">
        	<div class="row clearfix">
            	<!--Image Column-->
            	<div class="image-column col-lg-6">
                	<div class="image">
                    	<div class="price-box">
                        	<div class="inner-price">
                                <span class="price">
                                    <strong>30%</strong> <br> off per kg
                                </span>
                            </div>
                        </div>
                    	<img src="assets/img/bg3.jpg" alt="">
                    </div>
                </div>
                <!--Content Column-->
                <div class="content-column col-lg-6">
					<h3><span class="orange-text">Deal</span> of the month</h3>
                    <h4>Office Files</h4>
                    <div class="text">"Unlock unbeatable savings on our exclusive file sale! Choose from premium-quality folders, organizers, and document holders at discounted prices. Keep your workspace tidy and professional—shop now before the deal ends!"</div>
                    <!--Countdown Timer-->
                </div>
            </div>
        </div>
    </section>
    <!-- end cart banner section -->

<!-- testimonail-section -->
<div class="testimonail-section mt-150 mb-150 bg-light p-5">
		<div class="container ">
			<div class="row">
					<div class="col-lg-8 offset-lg-2 text-center">
						<div class="section-title">	
						<h3>Testomonials</h3>
					</div>
				</div>
				<div class="col-lg-10 offset-lg-1 text-center">
					<div class="testimonial-sliders">
						<?php
							while($row = mysqli_fetch_assoc($result2)) {
						?>
							<div class="single-testimonial-slider">
								<div class="client-avater">
									<img src="<?php echo $row['Picture']; ?>" alt="Client Avatar">
								</div>
								<div class="client-meta">
									<h3><?php echo $row['Name']; ?></h3>
									<p class="testimonial-body">
										<?php echo $row['Feedback']; ?>
									</p>
									<div class="last-icon">
										<i class="fas fa-quote-right"></i>
									</div>
								</div>
							</div>
						<?php
							}
						?>
					</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end testimonail-section -->
	

	<!-- shop banner -->
	<section class="shop-banner">
    	<div class="container">
        	<h3>December sale is on! <br> with big <span class="orange-text">Discount...</span></h3>
            <div class="sale-percent"><span >Sale! <br> Upto</span>50% <span>off</span></div>
            <a href="shop.php" class="cart-btn btn-lg" style="margin-left: 65%;">Shop Now</a>
        </div>
    </section>
	<!-- end shop banner -->


	<!-- footer -->
	<?php
    include('footer.php');
    ?>