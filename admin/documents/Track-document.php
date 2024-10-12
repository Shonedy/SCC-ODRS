<?php include('main_header/header.php'); ?>
<?php include('left_sidebar/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><i class="fa fa-fw fa-eye"></i> Track Document</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Track Document</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Function to render the status badges
        function renderStatus($status) {
            switch ($status) {
                case 'Pending':
                    return '<span class="badge bg-warning text-white">Pending</span>';
                case 'Waiting for Payment':
                    return '<span class="badge bg-info text-white">Waiting for Payment</span>';
                case 'Releasing':
                    return '<span class="badge bg-success text-white">Verified</span>';
                case 'Received':
                    return '<span class="badge bg-warning text-white">Pending Request</span>';
                case 'Declined':
                    return '<span class="badge bg-danger text-white">Declined</span>';
                default:
                    return '<span class="badge bg-secondary text-white">Unknown</span>';
            }
        }

        $student_id = $_SESSION['student_id'];
        $conn = new class_model();

        // Fetch only the first document request
        $row = $conn->fetchAll_documentrequest($student_id)[0]; // Adjust if method returns a single row

        $document_name = $row['document_name'];
        ?>

        <!-- Card for the document request -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card influencer-profile-data">
                    <div class="card-body">
                        <!-- Document title -->
                        <h5 class="card-title">Document: <?= $document_name ?></h5>

                        <!-- Department statuses for the document -->
                        <?php 
                        $departments = ['library', 'custodian', 'dean', 'accounting', 'registrar'];
                        foreach ($departments as $dept): 
                            $status = $row[$dept . '_status'];
                        ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left text-uppercase"><?= $dept ?>:</label>
                            <div class="col-sm-1">
                                <?= renderStatus($status) ?>
                            </div>
                            <div class="col-sm-6 ml-5">
                                <input data-parsley-type="alphanum" type="text" 
                                       value="Your request for <?= $document_name ?> is <?= strtolower($status); ?>, please comply." 
                                       name="subject" required="" class="form-control" readonly>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->

</body>
</html>
