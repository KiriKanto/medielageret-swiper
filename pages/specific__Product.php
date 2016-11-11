<?php
if(isset($_GET['id']))
{
    $product__Id = $_GET['id'];
}
else
{
    header("location:index.php?page=products");
}
//if $post submit

if(isset($_POST['submit']))
{
    if(isset($_POST['filter']))
    {
        $option__Value = $_POST['filter'];

        if(empty($_POST['filter']))
        {
            // ny sql der er dynamisk og passer til kun 1 parameter

            //IF select field is empty run this SQL
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
                    ");
        }
    }
    if(isset($_POST['search']))
    {
        $search__Value = $_POST['search'];

        if (empty($_POST['search']))
        {
            // ny sql der er dynamisk og passer til kun 1 parameter
            //IF seaarch field is empty run this SQL
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
                    ");
        }
    }
    if(isset($_POST['search']) && ($_POST['filter']))
    {
        //sql til vis begge felter er udfyldt

        $search__Value = $_POST['search'];
        $option__Value = $_POST['filter'];

        if (!empty($_POST['search']) && !empty($_POST['filter']))
        {
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
                        LIKE ?
                        ");
        }
    }
                //FIX FIX FIX FIX
//FIX DET HER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //stmt execute
    if(empty($_POST['search']) && empty($_POST['filter']))
    {
        header("location:index.php?page=products");
    }
    if(!empty($_POST['search']) && !empty($_POST['filter']))
    {
        $stmt->execute(array("%{$search__Value}%", "%{$option__Value}%" ));
        //it should redirect to products with some sort of id
    }
    if (empty($_POST['search']))
    {
        $stmt->execute(array(NULL, "%{$option__Value}%"));
        //it should redirect to products with some sort of id
    }

    if (empty($_POST['filter']))
    {
        //it should redirect to products with some sort of id
        $stmt->execute(array("%{$search__Value}%", NULL ));
    }


    if (empty($_POST['filter']))
    {
        $stmt->execute(array("%{$search__Value}%", NULL ));
        //it should redirect to products with some sort of id
    }
    if(!empty($_POST['search']) && !empty($_POST['filter']))
    {
        $stmt->execute(array("%{$search__Value}%", "%{$option__Value}%" ));
        //it should redirect to products with some sort of id
    }
}//if $post submit end
?>
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
            }//PDO option values end
            ?>
        </select>
        <input type="submit" name="submit" value="Go!">
    </form>
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
<hr><br>
<?php
//query til at hente info om vilket product der er valgt


$stmt        = $link ->query("SELECT * FROM products
                                  INNER JOIN
                                  prod__variant
                                  ON 
                                  prod__variant.fk__Prod__Id 
                                  =
                                  products.product__Id
                                  INNER JOIN
                                  variants
                                  ON 
                                  variant__Id 
                                  =
                                  prod__variant.fk__Variant__Id
                                  WHERE
                                  product__Id 
                                  =
                                  $product__Id");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//query slut
?>
    <div id="content__Box">
        <!--content box start-->
        <?php

        ?>
        <div class="main__Image">
            <!--img box start-->
            <img src="product__Img/<?php echo $row['product__Img']; ?>">
            <!--img box end-->
        </div>
        <div class="main__Image">
            <!--img box start-->
            <img src="product__Img/<?php echo $row['product__Img']; ?>">
            <!--img box end-->
        </div>
        <div class="main__Image">
            <!--img box start-->
            <img src="product__Img/<?php echo $row['product__Img']; ?>">
            <!--img box end-->
        </div>
        <div class="variant">
            <?php

            $sec__Stmt = $link ->query("SELECT * FROM prod__variant
                                    LEFT JOIN
                                    variants
                                    ON 
                                    prod__variant.fk__Variant__Id
                                    =
                                    variants.variant__Id
                                    LEFT JOIN 
                                    products
                                    ON 
                                    products.product__Id
                                    =
                                    prod__variant.fk__Prod__Id
                                    WHERE
                                    prod__variant.fk__Prod__Id
                                    =
                                    $product__Id
                                    ORDER BY fk__Variant__Id
                                    ");

            $sec__Stmt ->execute();

            $var__Stmt = $link ->query("SELECT 
                                        variant__Name,
                                        variant__Id
                                        FROM 
                                        variants
                                        ORDER BY variant__Id");

            $var__Stmt->execute();

            while($var__Row = $var__Stmt->fetch(PDO::FETCH_ASSOC))
            {
                $final__Row[] = $var__Row;
            }
            $i = 0;

            while ($sec__Row = $sec__Stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <div class="specific__Variant">
                    <form method="post">
                        <label class="product__Label">
                            <?php
                            echo $final__Row[$i]['variant__Name'];
                            $i++;
                            ?>
                        </label>
                        <?php
                        if($sec__Row['fk__Prod__Id'] == $product__Id
                        &&
                        $sec__Row['fk__Variant__Id'] == NULL)
                        {
                            ?>
                            <input type="submit" disabled
                                   value="Not available">
                            <?php
                        }
                        else
                        {
                        ?>
                        <input type="hidden"
                               name="product_quantity"
                               value="1">
                        <input type="hidden"
                               name="prod__Variant__Id"
                               value="<?php
                        echo $sec__Row['prod__Variant__Id']; ?>">
                        <input class="move__Down" type="submit" name="add__To__Cart"
                               value="Add to cart">

                        <label><?php
                            echo $sec__Row['prod__Variant__Price']
                                . " Dkk.";
                            }
                            ?>
                        </label>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>

        <article class="product">
            <!--article start-->
            <h1>
                <?php echo $row['product__Name'];
                ?>
            </h1>
            <p>
                <?php
                echo $row['product__Desc'];
                ?>
            </p>
            <!--article end-->
        </article>
        <!-- content box end-->
    </div>

<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 24-08-2016
 * Time: 12:12
 */
?>