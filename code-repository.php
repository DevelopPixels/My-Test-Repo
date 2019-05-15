<?php
include_once("libs/check_login_status.php");
// If the page requestor is not logged in, usher them away
if($user_ok != true || $log_username == ""){
	header("location: /");
    exit();
}

if(isset($_GET["sort"])){
	$sort = preg_replace('#[^a-z]#i', '', $_GET['sort']);
} 

$pagename = "code_repository";

include "app_includes/app_user_config.php";

$sql = "SELECT * FROM code_repositories WHERE repo_owner='$log_id' ORDER BY repo_last_updated ASC";
$query = mysqli_query($db_conx, $sql);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$repo_id = $row["repo_id"];
	$repo_name = $row["repo_name"];
    $repo_description = $row["repo_description"];
    $repo_last_updated = $row["repo_last_updated"];
	$repo_privacy = $row["repo_privacy"];
	
	if ($repo_privacy == "private") { $show_private_padlock = '<td class="font-w600" data-toggle="tooltip" title="Private Repository" style="width:25px"><i class="fa fa-lock"></i></td>'; } else { $show_private_padlock = '<td class="font-w600"  data-toggle="tooltip" title="Public Repository" style="width:25px"><i class="fa fa-globe"></i></td>'; }
	
	$my_code_repo_list .= '<tr>
    '.$show_private_padlock.'
    <td><p class="mb-0 font-w600"><a href="/repository/'.$repo_id.'">'.$repo_name.'</a></p><p class="text-muted mb-0">'.$repo_description.'</p></td>
    <td class="font-w600 text-muted" style="width: 120px;">'.$repo_last_updated.'</td>
</tr>';
}

?>
<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Code Repository - WebbiCRM</title>

        <?php include "app_includes/meta_data.php"; ?>

        <link rel="stylesheet" href="/assets/js/plugins/slick/slick.css">
        <link rel="stylesheet" href="/assets/js/plugins/slick/slick-theme.css">

        <link rel="stylesheet" href="/assets/js/plugins/select2/css/select2.css">
        <link rel="stylesheet" href="/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="/assets/css/codebase.css">

    </head>
    <body>

        <!-- Page Container -->
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll main-content-boxed sidebar-inverse">
            
            <?php include "app_includes/app_user_sidebar.php"; ?>

            <?php include "app_includes/app_sidebar_nav.php"; ?>

            <?php include "app_includes/app_header_nav.php"; ?>

            <main id="main-container">

                <div class="content">
                    <h2 class="content-heading">
                        <a href="/repository/new" class="btn btn-sm btn-rounded btn-success float-right">Create New Repo</a>
                        My Code Repository
                    </h2>
                    <div class="row">
                        <div class="col-xl-12">
                            
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <div class="block-title">
                                        My Repositories
                                    </div>
                                </div>
                                <div class="block-content">
                                    <table class="table table-hover table-vcenter table-borderless">
                                        <tbody>
                                            
                                            <?php echo $my_code_repo_list ?>
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Message List -->
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <div class="block-title">
                                        Shared Repositories
                                    </div>
                                </div>
                                <div class="block-content">
                                    <table class="table table-hover table-vcenter table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="font-w600"><a href="#">PHP Code Snippets</a></td>
                                                <td class="font-w600 font-size-sm text-muted" style="width: 120px;">22 Minutes Ago</td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600"><a href="#">HTML Code Snippets</a></td>
                                                <td class="font-w600 font-size-sm text-muted" style="width: 120px;">22 Minutes Ago</td>
                                            </tr>
                                            <tr>
                                                <td class="font-w600"><a href="#">PHP IF Statements Snippets</a></td>
                                                <td class="font-w600 font-size-sm text-muted" style="width: 120px;">22 Minutes Ago</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- END Messages -->
                                </div>
                            </div>
                            <!-- END Message List -->
                        </div>
                    </div>
                </div>

            </main>

            <?php include "app_includes/footer.php"; ?>

        </div>

        <div id="new-project" role="dialog" class="modal fade" aria-labelledby="modal-normal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Create New Project</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="project-name" class="col-form-label">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" class="form-control" id="project-name" required>
                            </div>
                            <div class="form-group">
                                <label for="project-mini-brief" class="col-form-label">Project Mini Brief</label>
                                <textarea class="form-control" id="project-mini-brief" name="project_mini_brief" rows="3" placeholder="Describe your project in a few words"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="project-client">Project Client <span class="text-danger">*</span></label>
                                <select class="js-select2 form-control" id="project-client" style="width: 100%;" data-placeholder="Select Client" name="project_client" required>
                                    <option></option>
                                    <option value="<?php echo $log_id ?>">Personal Project</option>
                                    <?php echo $client_list ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="project-deadline" class="col-form-label">Project Deadline <span class="text-danger">*</span></label>
                                <input type="text" class="js-datepicker form-control" id="project-deadline" name="project_deadline" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="<?php echo $show_project_date_format_form ?>" placeholder="<?php echo $show_project_date_format_form ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-success" name="create_project"><i class="fa fa-check"></i> Create Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/codebase.core.min.js"></script>
        <script src="/assets/js/codebase.app.min.js"></script>
        <script src="/assets/js/plugins/select2/js/select2.full.min.js"></script>
        <script src="/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

        <script>jQuery(function(){ Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });</script>

    </body>
</html>