<?php
include ('./header.php');
require_once('./dao/customerDao.php');
?>

<?php
/*
 *  @author:Mukta Debnath
 */
 
 // help line: https://stackoverflow.com/questions/22252904/how-to-check-if-a-row-exists-in-mysql/22253579#22253579
 
 
   try{
     $customerDao = new customerDao;
     $haserror = false;
     $errormessage = Array();
    
      if(isset($_POST['customerName'])||                         
         isset($_POST['phoneNumber'])||
         isset($_POST['emailAddress'])||
         isset($_POST['referral'])){
        
        if($_POST['customerName']==""){
            $haserror = true;
            $errormessage['customerName'] = "Please enter a name";
        }
        
        if (empty($_POST["phoneNumber"])){
            $haserror = true;
            $errormessage['phoneNumber'] = "Please enter a phone number";
        }
		
        // helpline for phne number: https://www.quora.com/How-would-you-describe-this-code-0-9-3-0-9-3-0-9-4
		
        if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $_POST ['phoneNumber']) ){
            $haserror = true;
            $errormessage['phoneNumber'] = "Please enter a valid phone number";
        }                
       
        if (empty ( $_POST ['emailAddress'] ) || (! filter_var ( $_POST ['emailAddress'], FILTER_VALIDATE_EMAIL ))){
            $haserror = true;
            $errormessage['emailAddress'] = "Please enter an email address";
        }
       
        
        if($customerDao->duplicateEmail($_POST['emailAddress'])){
            $haserror = true;
            $errormessage['emailAddress'] = "Duplicate Email Address.";
        }
		
        if (empty($_POST["referral"])) {
            $haserror = true;
            $errormessage['referral'] = "Referral is required. Please Re-enter.";
        }
              
        if(!$haserror){
            $email = $_POST['emailAddress'];
            $customer = new customer($_POST['customerName'],$_POST['phoneNumber'],$email,$_POST['referral']);
            $addSuccess = $customerDao->addCustomer($customer);
            echo '<h2 style="color: yellow; text-align: center">'. $addSuccess .'</h2>';
            
        }
		
    }
   
?>

              <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" placeholder="Firstname Lastname" size='40'>
                                <?php 
                                if(isset($errormessage['customerName'])){
                                    echo '<span style=\'color:red\'>'.$errormessage['customerName'].'</span>';
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40' placeholder="666-222-1111" value='<?php
                                if(isset($_POST['phoneNumber'])){
                                 echo $_POST['phoneNumber'];
                                }
                                ?>'>
                                <?php 
                                if(isset($errormessage['phoneNumber'])){
                                    echo '<span style=\'color:red\'>'.$errormessage['phoneNumber'].'</span>'; 
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" placeholder="xxx111@yahoo.com" size='40'>
								<?php 
                                if(isset($errormessage['emailAddress'])){
                                    echo '<span style=\'color:red\'>'.$errormessage['emailAddress'].'</span>';
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
                                    Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
                                    TV<input type='radio' name='referral' id='referralTV' value='TV'>
                                    Other<input type='radio' name='referral' id='referralOther' value='other'>
                                    <?php 
                                if(isset($errormessage['referral'])){
                        echo '<span style=\'color:red\'>' . $errormessage['referral'] . '</span>';
                      }
            ?></td>
                            </tr>                            
                            
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form">
                                                             
                            </tr>
                        </table>
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->
<?php
      
    
    }catch(Exception $e){
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }
   
         ?>
           <?php include './footer.php' ?>