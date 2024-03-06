<?php
    $m_order_information = new Order_information_Model();
    if ((isset($from_date) && !empty($from_date)) && (isset($to_date) && !empty($to_date))) {
        $all_account_details = $m_order_information->get_order_account_details('all',$from_date,$to_date);
        $pending_account_details = $m_order_information->get_order_account_details('pending',$from_date,$to_date);
        $accept_account_details = $m_order_information->get_order_account_details('accept',$from_date,$to_date);
        $reject_account_details = $m_order_information->get_order_account_details('reject',$from_date,$to_date);
    } else {
        $all_account_details = $m_order_information->get_order_account_details('all',null,null);
        $pending_account_details = $m_order_information->get_order_account_details('pending',null,null);
        $accept_account_details = $m_order_information->get_order_account_details('accept',null,null);
        $reject_account_details = $m_order_information->get_order_account_details('reject',null,null);
    }
?>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Account Summary</h2></div>
    <div class="panel-body">
        <div class="dashboard-widget-content">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="#all-order" role="tab">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#pending" role="tab">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#accepted" role="tab">Accepted</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#rejected" role="tab">Rejected</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fadeIn active" id="all-order" role="tabpanel">
                    <?php $this->load->view('admin/dashboard/account_summary_table',array('account_details'=>$all_account_details)) ?>
                </div>
                <div class="tab-pane fadeIn" id="pending" role="tabpanel">
                    <?php $this->load->view('admin/dashboard/account_summary_table',array('account_details'=>$pending_account_details)) ?>
                </div>
                <div class="tab-pane fadeIn" id="accepted" role="tabpanel">
                    <?php $this->load->view('admin/dashboard/account_summary_table',array('account_details'=>$accept_account_details)) ?>
                </div>
                <div class="tab-pane fadeIn" id="rejected" role="tabpanel">
                    <?php $this->load->view('admin/dashboard/account_summary_table',array('account_details'=>$reject_account_details)) ?>
                </div>
            </div>
        </div>
    </div>
</div>