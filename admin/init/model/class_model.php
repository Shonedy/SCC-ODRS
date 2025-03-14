
<?php

	require 'config/connection.php';

	class class_model{

		public $host = db_host;
		public $user = db_user;
		public $pass = db_pass;
		public $dbname = db_name;
		public $conn;
		public $error;
 
		public function __construct(){
			$this->connect();
		}
 
		private function connect(){
			$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
			if(!$this->conn){
				$this->error = "Fatal Error: Can't connect to database".$this->conn->connect_error;
				return false;
			}
		}

		public function login($username, $password, $status, $role){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_usermanagement` WHERE `username` = ? AND `password` = ? AND `status` = ? AND `role` = ?") or die($this->conn->error);
			$stmt->bind_param("ssss", $username, $password, $status, $role);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$valid = $result->num_rows;
				$fetch = $result->fetch_array();
				return array(
					'user_id'=> htmlentities($fetch['user_id']),
					'count'=>$valid
				);
			}
		}
 
		public function user_account($user_id) {
			// Prepare SQL statement to fetch user account details by user ID
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_usermanagement` WHERE `user_id` = ?") or die($this->conn->error);
			$stmt->bind_param("i", $user_id);
			
			if ($stmt->execute()) {
				$result = $stmt->get_result();
				if ($fetch = $result->fetch_array()) {
					// Return user details
					return array(
						'complete_name' => htmlentities($fetch['complete_name'])
					);
				} else {
					// No user found with this ID
					return null;
				}
			} else {
				// SQL execution failed
				return false;
			}
		}

	    public function fetchAll_course(){ 
            $sql = "SELECT * FROM tbl_course";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		public function add_course($course_name, $course_decription){
	       $stmt = $this->conn->prepare("INSERT INTO `tbl_course` (course_name, course_decription) VALUES(?, ?)") or die($this->conn->error);
			$stmt->bind_param("ss", $course_name, $course_decription);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}


		public function edit_course($course_name, $course_decription, $course_id){
			$sql = "UPDATE `tbl_course` SET  `course_name` = ?, `course_decription` = ?  WHERE course_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssi", $course_name, $course_decription, $course_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function edit_document($document_name, $description, $daysto_process, $price, $document_id) {
			$sql = "UPDATE `tbl_document` SET `document_name` = ?, `description` = ?, `daysto_process` = ?, `price` = ? WHERE document_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssssi", $document_name, $description, $daysto_process, $price, $document_id);
			if($stmt->execute()) {
				$stmt->close();
				$this->conn->close();
				return true;
			} else {
				return false; // Return false if execution fails
			}
		}

		public function delete_course($course_id){
			$sql = "DELETE FROM tbl_course WHERE course_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("i", $course_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}


		public function add_student($IDnumber, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $status){
			$stmt = $this->conn->prepare("INSERT INTO `tbl_students` (`student_id`, `first_name`, `middle_name`, `last_name`, `complete_address`, `email_address`, `mobile_number`, `username`, `password`, `account_status`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			$stmt->bind_param("ssssssssss", $IDnumber, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $status);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}
 
	    public function fetchAll_student(){ 
            $sql = "SELECT * FROM  tbl_students";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function fetchAll_verification(){ 
            $sql = "SELECT * FROM  tbl_verification";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  
		  public function fetchAll_hsstudent(){ 
            $sql = "SELECT * FROM  tbl_high_school";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		

		  public function edit_student($first_name, $middle_name, $last_name, $course, $year_level, $date_ofbirth, $gender, $complete_address, $email_address, $mobile_number, $username, $password, $account_status, $student_id) {
			$sql = "UPDATE `tbl_students` 
					SET `first_name` = ?, `middle_name` = ?, `last_name` = ?, `course` = ?, `year_level` = ?, 
						`date_ofbirth` = ?, `gender` = ?, `complete_address` = ?, `email_address` = ?, 
						`mobile_number` = ?, `username` = ?, `password` = ?, `account_status` = ? 
					WHERE `student_id` = ?";
		
			$stmt = $this->conn->prepare($sql);
		
			// Bind parameters correctly without trailing comma
			$stmt->bind_param(
				"sssssssssssssi", 
				$first_name, $middle_name, $last_name, $course, $year_level, 
				$date_ofbirth, $gender, $complete_address, $email_address, 
				$mobile_number, $username, $password, $account_status, $student_id
			);
		
			if ($stmt->execute()) {
				$stmt->close();
				$this->conn->close();
				return true;
			} else {
				// Optional: Handle errors (e.g., logging or returning false)
				$stmt->close();
				$this->conn->close();
				return false;
			}
		}
		

		public function add_account($student_id, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $status) {
			$sql = "INSERT INTO `tbl_students` (`student_id`, `first_name`, `middle_name`, `last_name`, 
						`complete_address`, `email_address`, `mobile_number`, `username`, `password`, `account_status`) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
			$stmt = $this->conn->prepare($sql);
		
			// Bind parameters correctly
			$stmt->bind_param(
				"ssssssssss", 
				$student_id, $first_name, $middle_name, $last_name, 
				$complete_address, $email_address, $mobile_number, $username, 
				$password, $status
			);
		
			if ($stmt->execute()) {
				$stmt->close();
				$this->conn->close();
				return true;
			} else {
				// Optional: Handle errors
				$stmt->close();
				$this->conn->close();
				return false;
			}
		}
		
		

		public function delete_student($student_id){
				$sql = "DELETE FROM tbl_students WHERE student_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $student_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}


			public function add_document($document_name, $description, $daysto_process, $price){
				$stmt = $this->conn->prepare("INSERT INTO `tbl_document` (`document_name`, `description`, `daysto_process`, `price`) VALUES(?, ?, ?, ?)") or die($this->conn->error);
				 $stmt->bind_param("ssss", $document_name, $description, $daysto_process, $price);
				 if($stmt->execute()){
					 $stmt->close();
					 $this->conn->close();
					 return true;
				 }
			 }


	    public function fetchAll_document(){ 
            $sql = "SELECT * FROM  tbl_document ORDER BY date_created DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }



		public function delete_document($document_id){


			$sql="SELECT document_name FROM tbl_document WHERE document_id = ?";
				$stmt2=$this->conn->prepare($sql);
				$stmt2->bind_param("i", $document_id);
				$stmt2->execute();
				$result2=$stmt2->get_result();
				$row=$result2->fetch_assoc();
				$imagepath=$_SERVER['DOCUMENT_ROOT']."/ORDS/student/".$row['document_name'];
				unlink($imagepath);

				$sql = "DELETE FROM tbl_document WHERE document_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $document_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

	    public function fetchAll_documentrequest(){ 
            $sql = "SELECT * FROM  tbl_documentrequest";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function print_documentrequest(){
			$db = mysqli_connect("localhost", "root", "", "ords_new_db");

				$result = mysqli_query($db, "SELECT * FROM tbl_documentrequest", MYSQLI_USE_RESULT);

			

				$output = fopen('php://output', 'w');

					fputcsv($output, array('request_id','control_no','student_id','document_name','date_request','date_releasing','processing_officer','status'));

				while ($row = mysqli_fetch_assoc($result))
					{
					fputcsv($output, $row);
					}

				fclose($output);
				mysqli_free_result($result);
				mysqli_close($db);


		  }

		  public function fetchAll_newrequest(){ 
            $sql = "SELECT * FROM  tbl_documentrequest WHERE registrar_status = 'Received' ";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function fetchAll_verified(){ 
            $sql = "SELECT * FROM  tbl_documentrequest WHERE registrar_status = 'Verified' ";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function fetchAll_released(){ 
            $sql = "SELECT * FROM  tbl_documentrequest WHERE registrar_status = 'Released' ";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function fetchAll_pendingpayment(){ 
            $sql = "SELECT * FROM  tbl_documentrequest WHERE registrar_status = 'Waiting for Payment' ";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }
		  public function fetchAll_declined(){ 
            $sql = "SELECT * FROM  tbl_documentrequest WHERE registrar_status = 'Declined' ";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }


		public function edit_request($control_no, $student_id, $document_name, $date_request, $date_releasing, $processing_officer, $registrar_status, $request_id){
			$sql = "UPDATE `tbl_documentrequest` SET  `control_no` = ?, `student_id` = ?, `document_name` = ?,  `date_request` = ?, `date_releasing` = ?, `processing_officer` = ?, `registrar_status` = ?  WHERE request_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssssssi", $control_no, $student_id, $document_name, $date_request, $date_releasing, $processing_officer, $registrar_status, $request_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function delete_request($request_id){
				$sql = "DELETE FROM tbl_documentrequest WHERE request_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $request_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

    public function fetchAll_payment(){ 
            $sql = "SELECT *,CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name FROM  tbl_payment INNER JOIN tbl_students ON tbl_students.student_id =  tbl_payment.student_id ORDER BY tbl_payment.student_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }
		  public function fetch_document_by_id($student_id, $request_id) {
			$sql = "SELECT * FROM tbl_documentrequest WHERE student_id = ? AND request_id = ?";
			$stmt = $this->conn->prepare($sql);
			
			if (!$stmt) {
				die("SQL Error: " . $this->conn->error);
			}
		
			$stmt->bind_param("ii", $student_id, $request_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			return $result->fetch_assoc();  // Fetch a single row
		}

		  public function edit_payment($control_no, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id){
			$sql = "UPDATE `tbl_payment` SET  `control_no` = ?, `total_amount` = ?, `amount_paid` = ?, `date_ofpayment` = ?, `proof_ofpayment` = ?, `status` = ?  WHERE payment_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssssssi", $control_no, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function delete_payment($payment_id){
				$sql = "DELETE FROM tbl_payment WHERE payment_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $payment_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

	    public function add_user($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status){
	       $stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			$stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function add_admin_treasurer($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status){
			$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			 $stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
			 if($stmt->execute()){
				 $stmt->close();
				 $this->conn->close();
				 return true;
			 }
		 }

		 public function add_admin_library($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status){
			$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			 $stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
			 if($stmt->execute()){
				 $stmt->close();
				 $this->conn->close();
				 return true;
			 }
		 }

		 public function add_admin_custudian($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status){
			$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			 $stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
			 if($stmt->execute()){
				 $stmt->close();
				 $this->conn->close();
				 return true;
			 }
		 }

		 public function add_admin_dean($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status){
			$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			 $stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
			 if($stmt->execute()){
				 $stmt->close();
				 $this->conn->close();
				 return true;
			 }
		 }

	    public function fetchAll_user(){ 
            $sql = "SELECT * FROM  tbl_usermanagement";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		

	    public function edit_user($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status, $user_id){
			$sql = "UPDATE `tbl_usermanagement` SET  `complete_name` = ?, `desgination` = ?, `email_address` = ?, `phone_number` = ?, `username` = ?, `password` = ?, `status` = ?  WHERE user_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssssssi", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status, $user_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		

	   public function delete_user($user_id){
				$sql = "DELETE FROM tbl_usermanagement WHERE user_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $user_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

	    public function count_numberofstudents(){ 
            $sql = "SELECT COUNT(student_id) as count_students FROM tbl_students";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  

		  public function count_allstudents(){ 
            $sql = "SELECT (SELECT COUNT(student_id)  FROM tbl_students) as count_students";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

	    public function count_numberoftotalrequest(){ 
            $sql = "SELECT COUNT(request_id) as count_request FROM tbl_documentrequest";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		 public function count_numberoftotalpending(){ 
            $sql = "SELECT COUNT(request_id) as count_pending FROM tbl_documentrequest WHERE accounting_status = 'Waiting for Payment'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  

		   public function count_numberoftotalpaid(){ 
            $sql = "SELECT COUNT(request_id) as count_paid FROM tbl_documentrequest WHERE accounting_status = 'Paid'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		 public function count_numberoftotalreceived(){ 
            $sql = "SELECT COUNT(request_id) as count_received FROM tbl_documentrequest WHERE registrar_status = 'Received'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function count_numberofverified(){ 
            $sql = "SELECT COUNT(request_id) as count_verified FROM tbl_documentrequest WHERE registrar_status = 'Verified'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function count_complete(){ 
            $sql = "SELECT COUNT(request_id) as count_complete FROM tbl_documentrequest WHERE registrar_status = 'Released'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }
		  public function count_declined(){ 
            $sql = "SELECT COUNT(request_id) as count_declined FROM tbl_documentrequest WHERE registrar_status = 'Declined'";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  


		 public function count_groupbymonth(){ 
            $sql = "SELECT COUNT(total_amount) as p_amountcount, SUM(total_amount) as p_amountsum, DATE_FORMAT(date_ofpayment, '%M') as month_s FROM tbl_payment GROUP BY DATE_FORMAT(date_ofpayment, '%M') ORDER BY DATE_FORMAT(date_ofpayment, '%M') ASC";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }


	 public function count_groupbycourse(){ 
            $sql = "SELECT count(course) as count_coursename,course FROM tbl_students GROUP BY course";
				$stmt = $this->conn->prepare($sql); 
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

	}	
?>