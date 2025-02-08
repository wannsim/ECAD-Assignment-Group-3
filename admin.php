<?php 
// Detect the current session
session_start();

// Include the Page Layout header
include("header.php"); 
$content1="Guest";
if(isset($_SESSION["ShopperName"])) { 
	$content1 = $_SESSION["ShopperName"];
	if (isset($_SESSION ["NumCartItem"])) {
        $cartitems=$_SESSION["NumCartItem"];
    }
}
?>
<br><br>

<h1 style="text-align: center; font-size: 40px; margin-top:-50px;">
   Admin Dashboard
</h1>

<div class="container mt-5">
        <div class="fw-light" style="font-size:20px;">Shopper ID: </div>
        <div class="input-group">
            <input name="search "class="form-control border rounded-pill" type="text" placeholder="Search..." id="shopperidsearch" onkeyup="search_studentid()">
            
        </div>
        <br>
        <div class="fw-light" style="font-size:20px;">Shopper Name: </div>
        <div class="input-group">
            <input name="search "class="form-control border rounded-pill" type="text" placeholder="Search..." id="namesearch" onkeyup="search_name()">
            
        </div>
        <br>
        <h2>Shopper Accounts</h2>
        
        <table class="table" id="contact-list">
            <thead>
                <th>Shopper ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Active Status</th>
                <th>Actions</th>

            </thead>
            <!-- This will be filled with information later -->
            <tbody>
              
            <?php
            // Include the PHP file that establishes database connection handle: $conn
            include_once("mysql_conn.php"); 
            $qry = "SELECT * FROM shopper";
            $stmt = $conn->prepare($qry); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 

            while ($row = $result->fetch_array()) {
              
              echo "<tr>";
              echo "<td class='shopperid'>".$row['ShopperID']."</td>";
              echo "<td class='shoppername'>".$row['Name']."</td>";
              echo"<td>".$row['Address']."</td>";
              if ($row['ActiveStatus'] == 1){
                $row['ActiveStatus'] = "Active";
              } else {
                $row['ActiveStatus'] = "Inactive";
              }
              echo"      <td>".$row['ActiveStatus']."</td>
                    <td>
                        <button class='btn btn-secondary'>Activate</button>
                        <button class='btn btn-danger' type='submit'>Deactivate</button>
                    </td>
                </tr>";
                /* if ($row["Offered"] == 1){
                    $currentDate = new DateTime();
                    $endDate = new DateTime($row["OfferEndDate"]);
                    $startDate = new DateTime($row["OfferStartDate"]);
                    
                    // Calculate the difference between the two dates
                    $dateDiff = $endDate->diff($currentDate);
                    
                    // Get the difference in days as an integer
                    $daysDifference = (int)$dateDiff->days;
                    
                    // on offer 
                    if ($endDate > $currentDate){
                        echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
                        echo "<div class='card'>";

                        $product = "productDetails.php?pid=$row[ProductID]";
                        $formattedPrice = number_format($row["Price"], 2);

                      
                        $img = "./Images/products/$row[ProductImage]";
                        echo "<a href=$product>";
                        echo "<img src='$img' /></a>";
                        echo "<h2><a href=$product style='text-decoration:none'>$row[ProductTitle]</a></h2>";
                        echo "<div class='body'>";
                        $offerPrice = number_format($row["OfferedPrice"], 2);
                        echo "Price: <span style='font-weight: bold; font-size: 20px; text-decoration: line-through;'>S$$formattedPrice</span>";
                        echo "<span style='font-weight: bold; color:red; font-size: 30px;'>  S$$offerPrice</span>";
                        echo "<p style='font-size:11px;' >From: " . $startDate->format('Y-m-d') . " to " . $endDate->format('Y-m-d') . "</p>";
                        $percent=round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10;
                        echo '<span class="discount">-'.$percent.'%</span>';
                        echo "</div>"; 
                        echo "</div>"; 
                        echo "</div>";
                        $count++;
                    }

                }

                if ($count % 3 == 0) {
                    echo "</div><div class='row'>"; // Close the current row and start a new one
                }*/
            } 

            ?>
                    
            </tbody>
        </table>
<script>
  function search_studentid() {
        let input = document.getElementById('shopperidsearch').value;

        let x = document.getElementsByClassName('shopperid');

        for (i = 0; i < x.length; i++) {
            if (!x[i].innerHTML.includes(input)) {
                x[i].parentElement.style.display = "none";
            }
            else {
                x[i].parentElement.style.display = "table-row";
            }
        }
        }
        function search_name() {
        let input = document.getElementById('namesearch').value;
        input=input.toLowerCase();
        let x = document.getElementsByClassName('shoppername');

        for (i = 0; i < x.length; i++) {
            if (!x[i].innerHTML.toLowerCase().includes(input)) {
                x[i].parentElement.style.display = "none";
            }
            else {
                x[i].parentElement.style.display = "table-row";
            }
        }
        }
</script>

<?php 
// Include the Page Layout footer
include("footer.php"); 
?>






