       <?php include('main_header/header.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
         <?php include('left_sidebar/sidebar.php');?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                             <h2 class="pageheader-title"><i class="fa fa-fw fa-file"></i> Document Request </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href_no="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Document Request</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
               
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Request Information</h5>
            <div class="card-body">
                <div id="message"></div>
                <div class="table-responsive">
                <a href="add-request.php" class="btn btn-sm" style="background-color:#1269AF !important; color:white">
                    <i class="fa fa-fw fa-plus"></i> Add Request
                </a><br><br>
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th scope="col">Control No.</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Document Name</th>
                                <th scope="col">Date Request</th>
                                <th scope="col">Date Releasing</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $student_id = $_SESSION['student_id'];
                                $conn = new class_model();
                                $docrequest = $conn->fetchAll_documentrequest($student_id);
                            ?>
                            <?php foreach ($docrequest as $row) { ?>
                                <tr>
                                    <td><?= $row['control_no']; ?></td>
                                    <td><?= $row['student_id']; ?></td>
                                    <td><?= $row['first_name'] .' '. $row['last_name']; ?></td>
                                    <td><?= $row['document_name']; ?></td>
                                    <td><?= date("M d, Y", strtotime($row['date_request'])); ?></td>
                                    <td>
                                        <?php 
                                            if ($row['date_releasing'] === "") {
                                                echo "";
                                            } else {
                                                echo date("M d, Y", strtotime($row['date_releasing']));
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($row['registrar_status'] === "Released") {
                                                echo '<span class="badge bg-success text-white">Released</span>';
                                            } elseif ($row['registrar_status'] === "Waiting for Payment") {
                                                echo '<span class="badge bg-info text-white">Waiting for Payment</span>';
                                            } elseif ($row['registrar_status'] === "Releasing") {
                                                echo '<span class="badge bg-success text-white">Processing</span>';
                                            } elseif ($row['registrar_status'] === "Received") {
                                                echo '<span class="badge bg-warning text-white">Pending Request</span>';
                                            } elseif ($row['registrar_status'] === "Declined") {
                                                echo '<span class="badge bg-danger text-white">Declined</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="align-right">
                                        <div class="box">   
                                        <div class="three">
                                            <!-- Converted to a button -->
                                            <a href="Track-document.php?request=<?= $row['request_id']; ?>&student-number=<?= $row['student_id']; ?>" class="btn btn-sm btn-primary text-xs" data-toggle="tooltip" data-original-title="Clearance">
                                            View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
    <!-- ============================================================= -->
    <!-- end main wrapper -->
      <!-- ============================================================== -->
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to proceed with the payment for this request?</p>
        <form action="process_payment.php" method="POST" id="paymentForm" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>">
            <input type="hidden" class="form-control" id="student" name="date_ofpayment" readonly>
          </div>

          <div class="form-group">
            <label for="trace_nonumber">Trace. NO.</label>
            <input type="text" class="form-control" id="trace_no" name="trace_no" placeholder="Enter Trace number">
          </div>

          <div class="form-group">
            <label for="refference">Ref. No.</label>
            <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter Reference number">
          </div>

          <div class="form-group">
            <label for="control number">Control No.</label>
            <input type="text" class="form-control" id="control_no" name="control_no" readonly>
          </div>
          
          <div class="form-group">
            <label for="documents">Documents</label>
            <input type="text" class="form-control" id="document_name" name="document_name" readonly>
          </div>

          <div class="form-group">
            <input type="hidden" class="form-control" id="date_ofpayment" name="date_ofpayment" readonly>
          </div>

          <div class="form-group">
            <label for="total_amount">Amount to Pay</label>
            <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
          </div>
          <!-- Image Upload Field -->
          <div class="form-group">
            <label for="paymentProof">Upload Proof of Payment</label>
            <input type="file" class="form-control" id="proof_ofpayment" name="proof_ofpayment" accept=".jpeg, .jpg, .png, .gif" required>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

        <button type="submit" class="btn btn-primary" form="paymentForm">Confirm Payment</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="../asset/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="../asset/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../asset/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/libs/js/main-js.js"></script>

<script>
    $(document).ready(function () {
        // Generate initials for profile image
        const firstName = $('#firstName').text();
        const lastName = $('#lastName').text();
        const initials = firstName.charAt(0) + lastName.charAt(0);
        $('#profileImage').text(initials);

        // Delete request
        $('.delete').on('click', function () {
            const request_id = $(this).data('id');
            if (confirm("Are you sure you want to remove this data?")) {
                $.post("../init/controllers/delete_request.php", { request_id }, function (response) {
                    $("#message").html(response);
                }).fail(function () {
                    console.error("Failed to delete request.");
                });
            }
        });

        // Load unseen notifications
        function loadUnseenNotifications(view = '') {
            $.post("../init/controllers/fetch.php", { view }, function (data) {
                $('.dropdown-menu_1').html(data.notification);
                if (data.unseen_notification > 0) {
                    $('.count').html(data.unseen_notification);
                }
            }, 'json');
        }

        loadUnseenNotifications();
        $('.dropdown-toggle').on('click', function () {
            $('.count').html('');
            loadUnseenNotifications('yes');
        });

        setInterval(loadUnseenNotifications, 4000);
    });
</script>

</body>
</html>
