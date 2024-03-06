<?php
	$postcode_model = new Postcode_Model();
    $user_role_id = $this->session->userdata('user_role');
	// dd($postcodes_list);
?>

<style type="text/css">
	.limit-option { width: 75px; height: 30px; line-height: 30px; padding: 5px 10px; font-size: 12px; border: 1px solid #ccc; }
    .distance-option { width: 200px; height: 30px; line-height: 30px; padding: 5px 10px; font-size: 12px; border: 1px solid #ccc; }
	.postcode-inp { width: 200px; height: 30px; line-height: 30px; padding: 5px 10px; font-size: 12px; border: 1px solid #ccc; }
    .table-responsive { height: 70vh; }
    .form-group .btn { margin-bottom: 2px }
    .x_title span { color: #ffffff; }
    .modal-dialog { min-height: calc(100vh - 60px); display: flex; flex-direction: column; justify-content: center; overflow: auto; }
    @media(max-width: 768px) {
        .modal-dialog { min-height: calc(100vh - 20px); }
    }
    #loading { position: fixed; display: block; width: 100%; height: 100%; top: 0; left: 0; text-align: center; opacity: 0.7; background-color: #fff; z-index: 99; }
    #loading-image { position: absolute; top: 0px; left: 400px; z-index: 99999; }
</style>

<div id="loading">
    <img id="loading-image" src="<?= base_url('assets/images/cube-02.gif'); ?>" alt="Loading..." />
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"><h2><?= $title ?></h2></div>
                <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">                            
                    <span class="btn btn-info btn-lg right-side-view" id="postcode_btn" postcode_id="" form-type="add">
                        <i class="fa fa-plus"></i> Add Postcode
                    </span>
                    <?php if ($user_role_id == 1): ?>                                
                        <div style="display: none;" id="upload-to-db-div">
                            <span class="btn btn-danger btn-lg right-side-view upload-to-db" page-link="<?= base_url("admin/postcode/update") ?>"><i class="fa fa-upload"></i> Upload Postcodes File To DB</span>
                        </div>
                        <span class="btn btn-success btn-lg right-side-view" id="btn-upload-excel">
                            <i class="fa fa-plus"></i> Upload Postcodes File
                        </span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <?php
                        $dropdown_entries_array = array('1000'=>'1000','500'=>'500','250'=>'250','100'=>'100');
                        $session_limit = $this->session->userdata('session_limit');
                    ?>
                    Show&nbsp;
                    <select class="limit-option" id="show_entries_by_limit">
                        <?php foreach ($dropdown_entries_array as $key => $value): ?>
                            <?php
                                $select = '';
                                if ($session_limit == $key) {
                                    $select = 'selected';
                                }
                            ?>
                            <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    &nbsp;Entries
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="form-group">
                    <?php
                        $distance_array = array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7');
                    ?>
                    <select class="distance-option" id="distance_option">
                        <option value="">Select Distance</option>
                        <?php foreach ($distance_array as $key => $value): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach ?>
                    </select>
                    &nbsp;                                    
                    <button class="btn btn-primary btn-sm" id="btn_show_distance">Show</button>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                <div class="form-group">
                    <input type="text" class="postcode-inp" name="search_postcode" id="search_postcode">&nbsp;&nbsp;
                    <button class="btn btn-primary btn-sm" id="btn_search_postcode">Search</button>
                </div>
            </div>
        </div>

        <div class="postcode-table">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center" width="70px">SN</th>
                            <th class="text-center">Postcode</th>
                            <th class="text-center" width="130px">Latitude</th>
                            <th class="text-center" width="130px">Longitude</th>
                            <th class="text-center" width="130px">Distance (Miles)</th>
                            <th class="text-center" width="100px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $count = 1 ?>
                        <?php if (!empty($postcodes_list)): ?>
                            <?php foreach ($postcodes_list as $postcode): ?>
                                <tr>
                                    <td class="text-center"><?= $count++ ?></td>
                                    <td><?= $postcode->postcode ?></td>
                                    <td class="text-right"><?= $postcode->latitude ?></td>
                                    <td class="text-right"><?= $postcode->longitude ?></td>
                                    <td class="text-right"><?= $postcode->distance ?></td>
                                    <td class="text-center">
                                        <span class="btn btn-sm btn-primary" id="postcode_btn" postcode_id="<?= $postcode->id ?>" form-type="edit"><i class="fa fa-eye"></i></span>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="container-fluid" style="margin-top: 40px;">
                        <input type="hidden" name="limit" id="limit" value="<?= $limit ?>">
                        <input type="hidden" name="start" id="start" value="<?= $start ?>">
                        Showing 1 to <?= $limit ?> of <?= $total_postcodes ?> Entries
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                    <div class="container-fluid">
                        <p><?php echo $links; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="postcodeModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="head_title">Modal Header</h4>
                    </div>

                    <div class="modal-body">
                        <div id="content_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>