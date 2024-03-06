<?php
/**
 * Created by IntelliJ IDEA.
 * User: Asus
 * Date: 15-Sep-19
 * Time: 6:36 PM
 */

class Booking extends ApiAdmin_Controller
{
    public function __construct()
    {

        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings');
        $this->load->library('user_agent');
        $this->load->model('Settings_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Booking_customer_Model');
        $this->load->library('email');
        $this->load->helper('shop');
        $this->load->helper('security');
        //  $this->load->helper('reservation');
    }


    public function index()
    {
        if($this->checkMethod('GET')){
            $searchValue = $this->input->get('searchValue');
            $bookings=array();

            $m_booking=new Booking_customer_Model();
            if($searchValue=='custom'){
                $to = getFormatDateTime($this->input->get('endDate'),'Y-m-d');
                $from = getFormatDateTime($this->input->get('startDate'),'Y-m-d');
            }else if($searchValue=='yesterday'){
                $to = date('Y-m-d', strtotime(' -1 day'));
                $from=$to;
            }else if($searchValue=='tomorrow'){
                $to = date('Y-m-d', strtotime(' +1 day'));
                $from=$to;
            }else if($searchValue=='today'){
                $to = date('Y-m-d');
                $from=$to;
            }else if($searchValue=='next_7_days'){
                $to = date('Y-m-d', strtotime(' +7 day'));
                $from=date('Y-m-d');
            }else  if($searchValue=='next_30_days'){
                $to = date('Y-m-d', strtotime(' +30 day'));
                $from=date('Y-m-d');
            }else  if($searchValue=='this_month'){
                $to = date('Y-m-d', strtotime('last day of this month'));
                $from=date('Y-m-d', strtotime('first day of this month'));
            }else  if($searchValue=='next_month'){
                $to = date('Y-m-d', strtotime('last day of next month'));
                $from=date('Y-m-d', strtotime('first day of next month'));
            }
            /*first day of next month*/
/*date('d.m.Y',strtotime('last day of this month')) */
            if(!empty($from) && !empty($to)){
                $bookings=$m_booking->get_booking($from,$to);
            }



            $response=array(
              'bookings'=> $bookings,
            );
            $this->setResponseJsonOutput($response,ApiAdmin_Controller::HTTP_OK);
        }

    }


    public function settings()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $day_number = date('w');
            $shop_timing = get_today_shop_timing($day_number);
            $selectedTime='17:30';
            $hourValues='5,6,7,8,9,10,11';

            if(!empty($shop_timing)){
                $startTime=get_property_value('open_time',$shop_timing);
                $endTime=get_property_value('close_time',$shop_timing);
                $selectedTime=get_formatted_date($startTime,'H:i');
                $timeStartFrom=get_formatted_date($startTime,'h');
                $hourValues='';
                for ($i=intval($timeStartFrom);$i<12;$i++){
                    $hourValues.=$i.',';

                }
                if(!empty($hourValues)){
                    $hourValues=  substr($hourValues,0,-1);
                }
            }

            $response=array(
                'selectedTime' => $selectedTime,
                'hourValues' =>$hourValues);

            $this->setResponseJsonOutput($response,ApiAdmin_Controller::HTTP_OK);


        }
    }





    public function set()
    {
        if ($this->checkMethod('POST')) {


            $validationRules = array(
                array(
                    'field' => 'CustomerName',
                    'label' => 'Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),

                ),
                array(
                    'field' => 'mobile',
                    'label' => 'Mobile',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),

                ),

                array(
                    'field' => 'BookingTime',
                    'label' => 'Reservation Date',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),

                ),
                array(
                    'field' => 'NumberOfGuest',
                    'label' => 'Number of Guest',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),

                ),
            );

            $this->form_validation->set_rules($validationRules);

            if ($this->form_validation->run()){
                $bookingId=intval($this->input->post('BookingId'));
                $bookingTime=$this->input->post('BookingTime');
                $bookingData= $this->Booking_customer_Model->data_form_post(array(
                    'CustomerName',
                    'email',
                    'mobile',
                    'CustomerPhone',
                    'address',
                    'postcode',
                    'NumberOfGuest',
                    'TableNumber',
                    'CustomerDetails',
                    'BookingTime',
                    'StartTime',
                    'EndTime',
                    'CustomerId',
                    'BookingPurpose',
                ));

                $start_time= $bookingData['StartTime'];
                $end_time= $bookingData['EndTime'];
                $bookingData['StartTime']=getFormatDateTime($start_time,'h:m:i A');
                $bookingData['EndTime']=getFormatDateTime($end_time,'h:m:i A');
                $bookingData['TableNumber']=0;
                $bookingData['CustomerId']=0;
                $bookingData['booking_status']='pending';
                $bookingData['TempOrderInformationId']=0;
                $reservation_date=getFormatDateTime($bookingTime,'F d Y');
                $day_number = get_formatted_date($bookingTime, 'w');
                $response_data=array(
                    'isSave'=>false,
                    'bookingId'=>$bookingId,
                    'responseData'=>$bookingData,
                    'responseMessage'=>$bookingData,
                );
                $shop_weekend_day_ids = get_shop_weekend_day_ids();
                $shop_timing = get_today_shop_timing($day_number);
                $start_time=$bookingData['StartTime'];
                if (in_array($day_number, $shop_weekend_day_ids) || empty($shop_timing)) {
                    // set output
                    $response_data = array(
                        'isSave' => false,
                        'responseMessage' => 'We are close at ' . $reservation_date . ' Please try another date.');
                    setResponseJsonOutput($response_data,200);


                } else if (!empty($shop_timing)) {
                    $open_time = strtotime($shop_timing->open_time);
                    $close_time = strtotime($shop_timing->close_time);
                    $time = strtotime($start_time);
                    // check between time
                    if (!($open_time<=$time)&& !($close_time>=$time )) {
                        $response_data = array(
                            'isSave' => false,
                            'responseMessage' => 'Please select time between ' . get_formatted_time($shop_timing->open_time, 'h:i:s A') . ' to ' . get_formatted_time($shop_timing->close_time, 'h:i:s A'));


                        setResponseJsonOutput($response_data,200);
                    }

                }


                $name=$bookingData['CustomerName'];
                $email=$bookingData['email'];
                $data_for_customer = array(
                    'name' => $name,
                    'email' => $bookingData['email'],
                    'phone' =>  $bookingData['CustomerPhone'],
                    'mobile' =>  $bookingData['mobile'],
                    'address' =>  $bookingData['address'],
                    'billing_postcode' =>  $bookingData['postcode'],
                );
                $customer = $this->Customer_Model->get_customer_by_phone_mobile_email($data_for_customer['phone'], $data_for_customer['mobile'], $data_for_customer['email']);
                $customer_id = !empty($customer) ? $customer->id : 0;
                $name = (!empty($title)) ? $title . '. ' . $name : $name;


                if($bookingId<=0){
                    $is_reservation_success = $this->Booking_customer_Model->save($bookingData);
                    $reservation_id = $this->Booking_customer_Model->db->insert_id();
                    if ($is_reservation_success) {
                        $booking = $this->Booking_customer_Model->get($reservation_id);
                        $this->data['booking'] = $booking;
                        $message = $this->load->view('email_template/reservation', $this->data, true);
                        $this->Booking_customer_Model->api_send_mail($email, $message);
                        $message = $this->load->view('api/template/reservation', array(), true);
                        $response_data = array(
                            'isSave' => true,
                            'responseMessage' => 'Booking is successful',
                        );
                        setResponseJsonOutput($response_data,200);

                    } else {
                        $response_data = array(
                            'isSave' => false,
                            'responseMessage' => 'Please try again');

                        setResponseJsonOutput($response_data,200);

                    }
                }else{
                    $bookingData['bookingId']=$bookingId;
                    $isSave= $this->Booking_customer_Model->save($bookingData,$bookingId);
                    $response_data = array(
                        'isSave' => $isSave,
                        'responseMessage' => ($isSave)?'Update is successful':'Did not updated'

                    );

                    setResponseJsonOutput($response_data,200);
                }

            } else {
                $response_data = array(
                    'isSave' => false,
                    'responseMessage' => validation_errors(),
                );


                $this->setResponseJsonOutput($response_data);
            }

        }
    }


    public function delete($id=0) {
        if($this->checkMethod('POST')){
                $m_booking=new Booking_customer_Model();
                $is_deleted=$m_booking->delete($id);
                $this->setResponseJsonOutput(array(
                    'isDeleted'=>$is_deleted,
                    'responseMessage'=>($is_deleted)?'Booking is deleted successfully.':'Booking did no deleted.',
                ));

        }


    }

}