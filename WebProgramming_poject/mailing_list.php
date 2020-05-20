<?php
include ('./header.php');
require_once('./dao/customerDao.php');
require_once('./websiteUser.php');
session_start();
session_regenerate_id(false);
if(isset($_SESSION['AdminID'])){
   if(!$_SESSION['websiteUser']->isAuthenticated()){
      header('Location:login.php'); 
    }
} else {
    header('Location:login.php');
}
 
$customerDao = new customerDao;
$customers=$customerDao->getCustomers();
//echo '<pre>'. $customers[0].'/<pre>';
echo '<div>'.'SessionID: ' . session_id() .'</div>';
echo '<div>'.'Session AdminID: ' . $_SESSION['AdminID'].'</div>';
if($_SESSION['websiteUser']->getDate()!=null){
echo '<div>'.'Last login date: ' . $_SESSION['websiteUser']->getDate().'</div>';
}else{
echo '<div>'.'The first time to log in' .'</div>';  
}
echo("<button onclick=\"location.href='logout.php'\">Logout!</button>");
/*
if ($customers){
    
    echo '<table class="table table-hover table-bordered" style="table-layout:fixed">';
                //echo '<tr><th>Customer Name</th> <th>Phone Number</th> <th>Email Address</th> <th>Referrer</th></tr>';
                echo "<tr><th style=\"width:100px;\">Customer</th><th style=\"width:150px;\">Phone</th><th style=\"width:250px;\">Email Address</th><th style=\"width:100px;\">Referral</th></tr>";
                $ID = $customerDao->getID();               
                $i=0;
                foreach($customers as $customer){
                    echo '<tr>';
                   // echo '<td>' . $ID[$i] . '</td>';
                  //  echo '<td><a href=\'edit_employee.php?employeeId='. $ID . '\'>' . $ID . '</a></td>';
                    echo '<td>' . '<center>' . $customer->getName() . '</center>' . '</td>';
                    echo '<td>' . '<center>' . $customer->getPhone() . '</center>' . '</td>';
                    echo '<td word-break: break-all>' . '<center>' . $customer->getEmail() . '</center>' . '</td>';
                    echo '<td>' . '<center>' . $customer->getReferrer() . '</center>' . '</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</table>';
                echo '<a href="logout.php" style="color:red;">Logout!</a>';
}else{
    echo '<h3>'.'No mailing exist now'.'</h3>';
    echo '<a href="logout.php" style="color:red;">Logout!</a>';
}
*/
            //$adminUser = $_SESSION["adminSession"];
			
			mysqli_report(MYSQLI_REPORT_STRICT);
			$connect = mysqli_connect("localhost", "wp_eatery", "password", "wp_eatery") or die('Error: ' . mysqli_error($link));
			$query = "SELECT * FROM mailinglist" ;
			$log = $connect->query($query) or die('Error: ' . mysqli_error($conect));
            echo '<table style=\"text-align:center;\" border="2">';
            
			echo "<tr><th style=\"width:100px;\">Customer Name</th><th style=\"width:150px;\">Phone Number</th><th style=\"width:250px;\"><center>Email Address</center></th><th style=\"width:100px;\"><center>Referrer</center></th></tr>";
			while ($row = mysqli_fetch_array($log)) 
			{
            //echo "<tr><td style=\"text-align:center;\">".$row['customerName']."</td><td style=\"text-align:center;\">".$row['phoneNumber']."</td><td style=\"word-break:break-all;\">".$row['emailAddress']."</td><td style=\"text-align:center;\">".$row['referrer']."</td></tr>";	
            echo '<tr>';
            echo '<td style="text-align:center">' . $row['customerName'] . '</td>';
            echo '<td style="text-align:center">' . $row['phoneNumber'] . '</td>';
            echo '<td style="word-break:break-all; text-align:center;">' . $row['emailAddress'] .'</td>';
            echo '<td style="text-align:center">' . $row['referrer'] .'</td>';
            echo '</tr>';
			}
			echo "</table>";
			mysqli_close($connect);
            //echo '<h3>'.'No mailing exist now'.'</h3>';
            //echo '<a href="logout.php" style="color:red;">Logout!</a>';
            
            //
?>


<?php include './footer.php' ?>