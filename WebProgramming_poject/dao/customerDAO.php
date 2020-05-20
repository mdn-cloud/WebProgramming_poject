<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');

/**
 * @author: Mukta
 */
class customerDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
   
   }
    
    public function getCustomers(){
        $result = $this->mysqli->query('SELECT * FROM mailinglist');
        $customers = array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                 $customer = new customer($row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
		
        $result->free();
        return false;
    }
    
   
    public function getCustomerId(){
				$result = $this->mysqli->query( 'select * from mailinglist');
        $customerId = array();
		
        if($result->num_rows == 1){
            while( $row = $result->fetch_assoc()){
           $id=$row['_id'];
           $customerId[]=$id;
        }           
        $result->free();
        return $customerId;
        }
        $result->free();
        return false;
    }
	
	
	 public function getCustomer(){
        $query = 'SELECT * FROM mailinglist WHERE _id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $customer = new customer($temp['customerName'], $temp['phoneNumber'], $temp['emailAddress'], $temp['referrer']);
            $result->free();
            return $employee;
        }
        $result->free();
        return false;
    }


    public function addCustomer($customer){
        if(!$this->mysqli->connect_errno){
         $query = 'INSERT INTO mailingList(customerName, phoneNumber, emailAddress, referrer) VALUES (?,?,?,?)';

            $stmt = $this->mysqli->prepare($query);
			 $name=$customer->getCustomerName();
      $phone=$customer->getPhoneNumber();
      $email=$customer->getEmailAddress();
      $ref=$customer->getReferrer();
      $stmt->bind_param('ssss',$name,$phone,$email,$ref);
	  
            $stmt->execute();
            if($stmt->error){
                return $stmt->error;
            } else {
                return $customer->getCustomerName() . ' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
	
    public function duplicateEmail($emailAddress){
		if(!$this->mysqli->connect_errno){
		   $result = $this->mysqli->query('SELECT emailAddress FROM mailinglist');
		   $email=array();
		   if($result->num_rows >= 1){
		     while($row = $result->fetch_assoc()){
				 $email[] = $row['emailAddress'];
			 }
               $result->free();
		    }
		   foreach($email as $value){
			   $hash = $value;
			   if(password_verify($emailAddress, $hash)){
				   return true;
			   }
		   }
		   return false;
		}
		
	}
	
    public function deleteCustomer($id){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailinglist WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
	    public function deleteCustomerByEmail($email){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailinglist WHERE emailAddress = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
  
}

?>
