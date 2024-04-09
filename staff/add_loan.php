
<h2 align="center">Add Loan Details</h2>
<form method="post">
	
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><?php echo @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Group</div>
		<div class="col-sm-5">
		<select name="group" class="form-control" required>
			<option value="">---Select Group---</option>
			<?php 
$q1=mysqli_query($conn,"select * from groups");
while($r1=mysqli_fetch_assoc($q1))
{
echo "<option value='".$r1['group_id']."'>".$r1['group_name']."</option>";
}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Loan Source</div>
		<div class="col-sm-5">
		<select name="source" class="form-control" required>
			<option value="">---Select Loan Source---</option>
			<option>Government</option>
			<option>Council</option>
			<option>Life Insurance Companies</option>
			<option>Public and Private Banks</option>
			<option>Online Lenders</option>
		</select>
		</div>
	</div>
	
	<script>
		function loanamount()
		{
		var original=document.getElementById("original").value;	
		var interest=document.getElementById("interest").value;	
		var year=document.getElementById("payment_term").value;	
		
		var interest1=(Number(original)*Number(interest)*Number(year))/100;
		var total=Number(original)+Number(interest1);
		
		var emi=total/(year*12);
		document.getElementById("total_paid").value=total;
		document.getElementById("emi_per_month").value=emi;
		
		}
	</script>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Amount</div>
		<div class="col-sm-5">
		<input type="number" id="original" name="amount" class="form-control" required/></div>
	</div>
	
	
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Loan Interest (%)</div>
		<div class="col-sm-5">
		<input type="text" name="intereset" id="interest" value="10" readonly="true" class="form-control" required/></div>
	</div>
	

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Term of Payment (In Year)</div>
		<div class="col-sm-5">
		<select onchange="loanamount()" name="payment_term" id="payment_term" class="form-control" required>
			<option value="">---Select Term of Payment---</option>
			<?php
				for($i=1;$i<=10;$i++)
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			 ?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Total Paid (With Interest)</div>
		<div class="col-sm-5">
		<input type="text" id="total_paid" name="total_paid" class="form-control" readonly/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Pay Every Month (EMI Per Month)</div>
		<div class="col-sm-5">
		<input type="text" id="emi_per_month" name="emi_per_month" class="form-control" readonly/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment Schedule</div>
		<div class="col-sm-5">
		<input type="date" name="payment" min="2016-01-01" class="form-control"  required/>
	
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment Due Date</div>
		<div class="col-sm-5">
		<input type="date" name="due" min="2016-01-01" class="form-control" required/>
	
		</div>
	</div>
	
	
	<div class="row" style="margin-top:10px">
	<div class="col-sm-4"></div>
		<div class="col-sm-4">
		
		
<input type="submit" value="Process New Loan" name="save" class="btn btn-success"/>
		<input type="reset" class="btn btn-danger"/>
		</div>
		<div class="col-sm-4"></div>
	</div>
</form>	


<?php
include '../admin/connection.php';
$err = '';

// Check if the form is submitted
if(isset($_POST['save'])) {
    // Extract POST data
    extract($_POST);

    // Check if all fields are filled
    if($group=="" || $source=="" || $amount=="" || $payment=="" || $due=="") {
        $err = "<font color='red'>Fill all the fields first</font>";
    } else {
        // Sanitize input data (to prevent SQL injection)
        $group = mysqli_real_escape_string($conn, $group);
        $source = mysqli_real_escape_string($conn, $source);
        $amount = mysqli_real_escape_string($conn, $amount);
        $payment_term = mysqli_real_escape_string($conn, $payment_term);
        $payment = mysqli_real_escape_string($conn, $payment);
        $due = mysqli_real_escape_string($conn, $due);

        // Check if loan is already allotted to the selected group
        $sql_check = "SELECT * FROM loan WHERE group_id='$group'";
        $result_check = mysqli_query($conn, $sql_check);
        $rows = mysqli_num_rows($result_check);

        if($rows == 0) {
            // Insert loan details into the database
            $sql_insert = "INSERT INTO loan (group_id, loan_come_from, loan_amount, loan_interest, payment_term, total_payment_with_intereset, emi_per_month, payment_schedule, due_date) 
			VALUES ('$group', '$source', '$amount', '$intereset', '$payment_term', '$total_paid', '$emi_per_month', '$payment', '$due')";
            if(mysqli_query($conn, $sql_insert)) {
                $err = "<div class='alert alert-success'>Congratulations! Loan has been allotted to this Group</div>";
            } else {
                $err = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $err = "<div class='alert alert-danger'>Loan already allotted to this Group</div>";
        }
    }
}
?>
