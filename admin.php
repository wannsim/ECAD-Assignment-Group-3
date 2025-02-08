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
<style>
  @media (max-width: 852px) {
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        th, td,button {
            font-size: 14px;
            padding: 8px;
        }
    }
    @media (max-width: 500px) {
        th, td,button {
            font-size: 12px;
        }
    }
</style>
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
                <th>Email</th>
                <th>Active Status</th>
                <th>Actions</th>

            </thead>
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
              echo"<td>".$row['Email']."</td>";
              if ($row['ActiveStatus'] == 1){
                $row['ActiveStatus'] = "Active";
              } else {
                $row['ActiveStatus'] = "Inactive";
              }
              echo "<form action='adminFunctions.php' method='post'>";
              echo "<input type='hidden' name='shopper_id' value='".$row['ShopperID']."' />"; // Pass ShopperID
              echo "<td>".$row['ActiveStatus']."</td>";
              echo "<td>";
              echo "    <button class='btn btn-secondary' type='submit' name='action' value='activate'>Activate</button>";
              echo "    <button class='btn btn-danger' type='submit' name='action' value='deactivate'>Deactivate</button>";
              echo "</td>";
              echo "</form>";
              echo "</tr>";
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






