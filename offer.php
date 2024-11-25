<?php
include("header.php");

$con = new connec();
$offers = $con->select_all("offer");
?>

<section class="mt-5">
    <div class="container">
        <h5 class="text-center" style="color:maroon;">Khuyến Mãi Mới Khả Dụng</h5>

        <!-- Display Offers Section -->
        <div class="row mt-4">
            <?php
            if ($offers->num_rows > 0) {
                while ($offer = $offers->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <img src="images/offer.jpg" class="card-img-top img-fluid" alt="<?= htmlspecialchars($offer['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($offer['title']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($offer['description']); ?></p>
                                <p class="text-muted">Hạn sử dụng: <?= htmlspecialchars($offer['expiry_date']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>Không có khuyến mãi khả dụng.</p>";
            }
            ?>
        </div>
    </div>
</section>



<?php
include("footer.php");
?>