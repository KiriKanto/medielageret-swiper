<form method="post" id="search__Bar">
    <input type="search" name="search" placeholder="Search">
    <select name="filter">
        <option></option>
        <?php

        //PDO option values
        $stmt = $link->query('SELECT * FROM categories');

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            ?>
            <option value="<?php echo $row['cat__Id']; ?>">
                <?php echo $row['cat__Name']; ?>
            </option>
            <?php
        } //PDO option values end
        ?>
    </select>
    <input type="submit" name="submit" value="Go!">
</form>
<?php
    //____RETURN WHATEVER YOU SEARCHED FOR start
//IF SUBMIT!!!!__________________
?>
<script>
    $(document).ready(function () {
        var windowsize    = $(window).width();
        if(windowsize == 375)
        {
            var all__Text = $(".text__Box p span");

            $.each(all__Text, function (k, v) {
                let text = $(v).html();
                var result = text.substring(0, 100);
                $(this).html(result + "...");
            });
        }

    });
    </script>
<?php
if(isset($_POST['submit']))
{
    //if both fields are empty
    if(empty($_POST['search']) && empty($_POST['filter']))
    {
        header("location:index.php?page=products");
    }

    //if neither is empty
    if (!empty($_POST['search']) && !empty($_POST['filter'])) {
        $search__Value = $_POST['search'];
        $option__Value = $_POST['filter'];

        $stmt = $link->prepare("SELECT * FROM
                        products
                        INNER JOIN
                        cat__prod
                        ON 
                        products.product__Id = 
                        cat__prod.fk__Product__Id
                        INNER JOIN
                        categories
                        ON 
                        cat__prod.fk__Categories__Id = 
                        categories.cat__Id
                        WHERE product__Name
                        LIKE ?
                        OR categories.cat__Id
                        LIKE ?
                        GROUP BY
                        product__Name
                        ORDER BY
                        (product__Name =
                        '$search__Value')
                        DESC, 
                        product__Name
                        ");

        $stmt->execute(array("%{$search__Value}%", "%{$option__Value}%"));
        while ($row__Everything = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="single__Product"><img src="product__Img/<?php echo $row__Everything['product__Img']; ?>">
                <div class="text__Box">
                    <h2><?php echo $row__Everything['product__Name']; ?>
                    </h2>
                    <p>

                        <span>
                        <?php

                        echo substr($row__Everything['product__Desc'], 0, 200) . '...';

                        ?>
                        </span>
                        <a href="index.php?page=specific__Product&id=
                        <?php echo $row__Everything['product__Id']; ?>">
                            <?php echo 'Read more'; ?>
                        </a>
                    </p>
                </div><!--text box slut-->
            </div>
            <?php
        }
    }

        //only the search field has been filled____
        //if dropdown is empty
        if (empty($_POST['filter']))
        {

            //IF select field is empty run this SQL
            $search__Value = $_POST['search'];
            $option__Value = NULL;

            $stmt = $link->prepare("SELECT * FROM products
         INNER JOIN
         cat__prod
         ON 
         products.product__Id = 
         cat__prod.fk__Product__Id
         INNER JOIN
         categories
         ON 
         cat__prod.fk__Categories__Id = 
         categories.cat__Id
         WHERE product__Name
         LIKE ?
         OR categories.cat__Id
         IS ?
         ORDER BY 
         (product__Name = '$search__Value') 
         DESC, 
         product__Name
        ");


            $stmt->execute(array("%{$search__Value}%", NULL));

            while ($row__Search = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <div class="single__Product"><img src="product__Img/<?php echo $row__Search['product__Img']; ?>">
                    <div class="text__Box">
                        <h2><?php echo $row__Search['product__Name']; ?>
                        </h2>
                        <p>

                        <span>
                        <?php

                        echo substr($row__Search['product__Desc'], 0, 200) . '...';

                        ?>
                        </span>
                            <a href="index.php?page=specific__Product&id=
                        <?php
                            echo $row__Search['product__Id']; ?>">
                                <?php echo 'Read more';
                                ?>
                            </a>
                        </p>
                    </div><!--text box slut-->
                </div>
                <?php
            }
        }
        //only the dropdown has been chosen________
        //if search bar is empty
        if (empty($_POST['search']))
        {

            // ny sql der er dynamisk og passer til kun 1 parameter
            //IF seaarch field is empty run this SQL
            $option__Value = $_POST['filter'];
            $search__Value = NULL;

            $stmt = $link->prepare("SELECT * FROM products
                    INNER JOIN
                    cat__prod
                    ON 
                    products.product__Id = 
                    cat__prod.fk__Product__Id
                    INNER JOIN
                    categories
                    ON 
                    cat__prod.fk__Categories__Id = 
                    categories.cat__Id
                    WHERE product__Name
                    IS ?
                    OR categories.cat__Id
                    LIKE ?
                    ORDER BY 
                    product__Name 
                    DESC
                    ");


            $stmt->execute(array(NULL, "%{$option__Value}%"));
            while ($row__Categori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="single__Product"><img src="product__Img/<?php echo $row__Categori['product__Img']; ?>">
                    <div class="text__Box">
                        <h2><?php echo $row__Categori['product__Name']; ?>
                        </h2>
                        <p>
                            <span>
                        <?php

                        echo substr($row__Categori['product__Desc'], 0, 200) . '...';

                        ?>
                        </span>
                            <a href="index.php?page=specific__Product&id=
                        <?php echo $row__Categori['product__Id']; ?>">
                                <?php echo 'Read more';
                                ?>
                            </a>
                        </p>
                    </div><!--text box slut-->
                </div>
                <?php
            }
        }

}
    //____Return ends___________________________
?>
    <h2 class="top__10">
        Top 10 Most ordered movies
    </h2>
    <!--most bought start-->
<div id="most__Bought">

    <!--slide container start-->
    <div class="swiper-container s2">
        <!--slider wrapper start-->
        <div class="swiper-wrapper">
    <?php
    $stmt = $link->query('SELECT * FROM products
                          ORDER BY 
                          product__Sold 
                          DESC
                          LIMIT 10
                            ');
    $stmt->execute();

    while($row  = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        ?>
        <div class="swiper-slide ">
            <a href="index.php?page=specific__Product&id=<?php echo $row['product__Id']; ?>"><img src="product__Img/<?php echo $row['product__Img']; ?>"></a>
        </div>
        <?php
    }
    ?>

        </div>
        <!--swiper wrapper end-->
    </div>
    <!--swiper container end-->
</div>
    <!--most bought end -->
<!--____________________________________________-->
<!--________________TOP 10 newest starts here____-->
    <h2 class="top__10">
        Top 10 newest added movies
    </h2>
    <div id="most__Bought">
        <!--slide container start-->
        <div class="swiper-container s2">
            <!--slider wrapper start-->
            <div class="swiper-wrapper">
                <?php
                $stmt = $link->query('SELECT * FROM products
                          ORDER BY 
                          product__Added
                          LIMIT 10
                            ');
                $stmt->execute();

                while($row  = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>
                    <div class="swiper-slide ">
                        <a href="index.php?page=specific__Product&id=<?php echo $row['product__Id']; ?>"><img src="product__Img/<?php echo $row['product__Img']; ?>"></a>
                    </div>
                    <?php
                }
                ?>

            </div>
            <!--swiper wrapper end-->
        </div>
        <!--swiper container end-->
    </div>
    <!--most bought end -->
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 18-08-2016
 * Time: 09:52
 */
?>