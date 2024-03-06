<?php

function get_side_navigation_bar()
{

    $CI =& get_instance();
    ?>
    <div class="admin-side-navbar bg-faded">
        <nav class="navbar ">
            <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse"
                    data-target="#exCollapsingNavbar" aria-controls="exCollapsingNavbar2" aria-expanded="false"
                    aria-label="Toggle navigation">
                &#9776;
            </button>
            <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar">
                <ul class="nav  nav-stacked">
                    <li class="nav-item ">
                        <i class="fa fa-dashboard"></i>
                        <?php echo anchor($CI->admin . '/dashboard', 'Dashboard', 'class="nav-link"') ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        if ($CI->session->userdata('role') == 1) {
                            echo '<i class="fa fa-user"></i>';
                            echo anchor($CI->admin . '/user', '&nbspUsers', 'class="nav-link"');
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        echo '<i class="fa fa-check-circle-o"></i>';
                        echo anchor($CI->admin . '/customer_post', '&nbsp;Customer', 'class="nav-link"') ?><br>

                    </li>
                    <li class="nav-item">
                        <?php
                        echo '<i class="fa fa-check-circle-o"></i>';
                        echo anchor($CI->admin . '/banner', '&nbsp;Home Banner', 'class="nav-link"') ?><br>

                    </li>
                    <li class="dropdown open">
                        <a class="nav-link" type="button" id="dropdownMenuButton" data-toggle="" aria-haspopup="true"
                           aria-expanded="false">
                            Shop
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            <?php echo anchor($CI->admin . '/shop/edit', ' <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Shop Settings', 'class="dropdown-item"') ?>
                        </div>
                    </li>

                    <li class="dropdown open">
                        <a class="nav-link" type="button" id="dropdownMenuButton" data-toggle="" aria-haspopup="true"
                           aria-expanded="false">
                            Shop
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            <?php echo anchor($CI->admin . '/order_details', ' <i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Order Details', 'class="dropdown-item"') ?>
                        </div>
                    </li>
                    <!--<li class="dropdown open">
                        <a class="nav-link" type="button" id="dropdownMenuButton" data-toggle="" aria-haspopup="true"
                           aria-expanded="false">
                            Report
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            <?php /*echo anchor($CI->admin . '/report', ' <i class="" aria-hidden="true"></i>&nbsp;Order Report', 'class="dropdown-item"') */?>
                        </div>
                    </li>-->



                    <li class="dropdown open">
                        <a class="nav-link" type="button" id="dropdownMenuButton" data-toggle="" aria-haspopup="true"
                           aria-expanded="false">
                            Shop
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            <?php echo anchor($CI->admin . '/order_report', ' <i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Order Report', 'class="dropdown-item"') ?>
                        </div>
                    </li>
                    <li class="dropdown open">
                        <a class="nav-link" type="button" id="dropdownMenuButton" data-toggle="" aria-haspopup="true"
                           aria-expanded="false">
                            Shop
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
                            <?php echo anchor($CI->admin . '/end_of_the_day', ' <i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;End Of The Day', 'class="dropdown-item"') ?>
                        </div>
                    </li>



                </ul>
            </div>
        </nav>
    </div>

    <?php
}


function get_calendar()
{
    $ci = @get_instance();
    $prefs = array(
        'start_day' => 'saturday',
        'month_type' => 'long',
        'day_type' => 'short',
        'week_day' => array('friday'),
    );

    $prefs['template'] = '
        {table_open}<table class="table table-inverse">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th ><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th style="background-color: red" colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th ><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td style="background-color: red">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';

    $ci->load->library('calendar', $prefs);
    ?>
    <div class="calender">
        <?= $ci->calendar->generate(); ?>
    </div>
    <?php
}
