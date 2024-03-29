<?php 
error_reporting(0);
include  'include/config.php';
$empid=$_GET['id'];
if(isset($_POST['Submit'])){

$Department = $_POST['Department'];
$namedd = $_POST['name'];
$salary = $_POST['salary'];
$AllowanceSalary = $_POST['AllowanceSalary'];

$sql="update tbladdsalary set Department=:Department,empid=:name,salary=:salary,allowancesalary=:AllowanceSalary  where id=:empid";
$query = $dbh -> prepare($sql);
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':Department',$Department,PDO::PARAM_STR);
$query->bindParam(':name',$namedd,PDO::PARAM_STR);
$query->bindParam(':salary',$salary,PDO::PARAM_STR);
$query->bindParam(':AllowanceSalary',$AllowanceSalary,PDO::PARAM_STR);
$query->execute();
//$msg="<script>toastr.success('Mobile info updated Successfully', {timeOut: 5000})</script>";
echo "<script>alert('Salary has been updated.');</script>";
echo "<script> window.location.href =edit-salary.php;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
   <title>Employee Benefits WebApp</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
   <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>
    <main class="app-content">
      
      <div class="row">
        
        <div class="col-md-12">
          <div class="tile">
                   <h2 align="center"> Edit Benefits Details</h2>
              <hr />
             <!---Success Message--->  
          <?php if($msg){ ?>
          <div class="alert alert-success" role="alert">
          <strong>Well done!</strong> <?php echo htmlentities($msg);?>
          </div>
          <?php } ?>

          <!---Error Message--->
          <?php if($errormsg){ ?>
          <div class="alert alert-danger" role="alert">
          <strong>Oh snap!</strong> <?php echo htmlentities($errormsg);?></div>
          <?php } ?>
            <h3 class="tile-title">Update Benefits</h3>
            <div class="tile-body">
               <?php
               $empid=$_GET['id'];
                $sql="SELECT t1.id,t1.empid,salary,allowancesalary,total,fname,t1.Department as depID,DepartmentName,
                lunchTickets,vacationTickets,signInBonus,performanceBonus,
                usedLunchTickets,usedVacationTickets,usedSignInBonus,usedPerformanceBonus FROM tbladdsalary as t1
join tblemployee as t2 on t1.empid=t2.EmpId
join tbldepartment as t3 on t1.Department=t3.id where t1.EmpId=:pid";

                $query= $dbh->prepare($sql);
                $query->bindParam(':pid',$empid, PDO::PARAM_STR);
                $query-> execute();
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query -> rowCount() > 0)
                {
                foreach($results as $result)
                {
                ?>
              <form class="row" method="post">

                <div class="form-group col-md-6">
                  <label class="control-label">Department</label>
                 <select name="Department" id="Department" class="form-control" onChange="getdistrict(this.value);">
                  <option value="<?php echo $result->depID;?>"><?php echo $result->DepartmentName;?></option>
                  <option value="NA">--select--</option>
                  <?php 
                  $stmt = $dbh->prepare("SELECT * FROM tbldepartment ORDER BY DepartmentName");
                  $stmt->execute();
                  $departList = $stmt->fetchAll();
                  foreach($departList as $departname){
                  echo "<option value='".$departname['id']."'>".$departname['DepartmentName']."</option>";
                  }
                  ?>
                  </select>
                <span style="color:red;"><?php echo $deperrormsg;?></span>
                </div>
                
                   <div class="form-group col-md-6">
                  <label class="control-label">Name</label>
                  <select name="name" id="name" class="form-control">
                    <option value="<?php echo $result->empid;?>-<?php echo $result->fname; ?>"><?php echo $result->empid;?>-<?php echo $result->fname; ?></option>
                    <option value="">--Select--</option>
                  </select>
                   
                </div>

                 

                <div class="form-group col-md-6">
                  <label class="control-label">Salary</label>
                  <input type="number" name="salary" id="salary" placeholder="Enter your salery" class="form-control" value="<?php echo $result->salary;?>">
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Allowance Salary</label>
                 <input type="number"  name="AllowanceSalary" id="AllowanceSalary" placeholder="Enter your Allowance Salary" class="form-control" value="<?php echo $result->allowancesalary;?>">
                    
                </div>

                 <div class="form-group col-md-6">
                  <label class="control-label">Total</label>
                 <input type="text"  name="totalsalary" id="totalsalary" placeholder="Enter your Total salary" class="form-control" readonly value="<?php echo $result->total;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Lunch Tickets</label>
                 <input type="text"  name="lunchTickets" id="lunchTickets" placeholder="Enter your Lunch Tickets amount" class="form-control" readonly value="<?php echo $result->lunchTickets;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Vacation Tickets</label>
                 <input type="text"  name="vacationTickets" id="vacationTickets" placeholder="Enter your Vacation Tickets amount" class="form-control" readonly value="<?php echo $result->vacationTickets;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Sign In Bonus</label>
                 <input type="text"  name="signInBonus" id="signInBonus" placeholder="Enter your Sign In Bonus amount" class="form-control" readonly value="<?php echo $result->signInBonus;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Performance Bonus</label>
                 <input type="text"  name="performanceBonus" id="performanceBonus" placeholder="Enter your Performance Bonus amount" class="form-control" readonly value="<?php echo $result->performanceBonus;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Used Lunch Tickets</label>
                 <input type="text"  name="usedLunchTickets" id="usedLunchTickets" placeholder="Enter your Used Lunch Tickets amount" class="form-control" readonly value="<?php echo $result->usedLunchTickets;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Used Vacation Tickets</label>
                 <input type="text"  name="usedVacationTickets" id="usedVacationTickets" placeholder="Enter your Used Vacation Tickets amount" class="form-control" readonly value="<?php echo $result->usedVacationTickets;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Used Sign In Bonus</label>
                 <input type="text"  name="usedSignInBonus" id="usedSignInBonus" placeholder="Enter your Used Sign In Bonus amount" class="form-control" readonly value="<?php echo $result->usedSignInBonus;?>">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Used Performance Bonus</label>
                 <input type="text"  name="usedPerformanceBonus" id="usedPerformanceBonus" placeholder="Enter your Used Performance Bonus amount" class="form-control" readonly value="<?php echo $result->usedPerformanceBonus;?>">
                    
                </div>
             

                <div class="form-group col-md-4 align-self-end">
                  <input type="Submit" name="Submit" id="Submit" class="btn btn-primary" value="Update">
                </div>
              </form>
               <?php  $cnt=$cnt+1; } } ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/plugins/pace.min.js"></script>
  </body>
</html>

<!-- Script -->
 <script>
function getdistrict(val) {
$.ajax({
type: "POST",
url: "ajaxfile.php",
data:'Department='+val,
success: function(data){
$("#name").html(data);
}
});
}
</script>
<script>
$(function(){
            $('#salary, #AllowanceSalary').keyup(function(){
               var value1 = parseFloat($('#salary').val()) || 0;
               var value2 = parseFloat($('#AllowanceSalary').val()) || 0;
               $('#totalsalary').val(value1 + value2);
            });
         });

</script>