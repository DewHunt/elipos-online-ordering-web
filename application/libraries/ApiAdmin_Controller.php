<?php

class ApiAdmin_Controller extends CI_Controller
{



    // Note: Only the widely used HTTP status codes are documented

    // Informational

    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518

    // Success

    /**
     * The request has succeeded
     */
    const HTTP_OK = 200;

    /**
     * The server successfully created a new resource
     */
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * The server successfully processed the request, though no content is returned
     */
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229

    // Redirection

    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;

    /**
     * The resource has not been modified since the last request
     */
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238

    // Client Error

    /**
     * The request cannot be fulfilled due to multiple errors
     */
    const HTTP_BAD_REQUEST = 400;

    /**
     * The user is unauthorized to access the requested resource
     */
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;

    /**
     * The requested resource is unavailable at this present time
     */
    const HTTP_FORBIDDEN = 403;

    /**
     * The requested resource could not be found
     *
     * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
     * FORBIDDEN (403) error, for security reasons
     */
    const HTTP_NOT_FOUND = 404;

    /**
     * The request method is not supported by the following resource
     */
    const HTTP_METHOD_NOT_ALLOWED = 405;

    /**
     * The request was not acceptable
     */
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;

    /**
     * The request could not be completed due to a conflict with the current state
     * of the resource
     */
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585

    // Server Error

    /**
     * The server encountered an unexpected error
     *
     * Note: This is a generic error message when no specific message
     * is suitable
     */
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * The server does not recognise the request method
     */
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    public $data = array();
    public $isLoggedIn=false;
    public $member=null;

    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        date_default_timezone_set('Europe/London');
    }

    protected function checkAuthorization() {
        $responseUnauthorized = array(
            'status' => ApiAdmin_Controller::HTTP_UNAUTHORIZED,
            'authorization' => 'Unauthorized',
        );
        $authorization = $this->input->get_request_header('authorization', TRUE);

        if($this->input->server('REQUEST_METHOD') != 'OPTIONS') {
            if (empty($authorization)) {
                $this->setResponseJsonOutput($responseUnauthorized, ApiAdmin_Controller::HTTP_UNAUTHORIZED);
            } else {
                // match with key;
                $authorization = trim($this->input->get_request_header('Authorization'));
                $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
                $auth_key = (!empty($auth_key_settings))?trim($auth_key_settings->value):'';
                $authKeyEncode = base64_encode($auth_key);
                if ($authKeyEncode == $authKeyEncode) {
                // go on
                } else {
                    $this->setResponseJsonOutput($responseUnauthorized, ApiAdmin_Controller::HTTP_UNAUTHORIZED);
                }
            }
        }

    }

    protected function checkMethod($method = 'POST') {
        if($this->input->server('REQUEST_METHOD')=='OPTIONS'){
            return false;
        }
        if ($this->input->server('REQUEST_METHOD') != $method) {
            $response = array(
                'status' => ApiAdmin_Controller::HTTP_METHOD_NOT_ALLOWED,
                'message' => 'Method not allowed'
            );

            $this->setResponseJsonOutput($response, ApiAdmin_Controller::HTTP_METHOD_NOT_ALLOWED);
            return false;
        }
        return true;
    }

    protected function is_token_verified($method = 'POST') {
        if (isset($this->input->request_headers()['Authorization'])) {
            $authorization = $this->input->request_headers()['Authorization'];
            if ($authorization) {
                $authorization = explode('Bearer ',$authorization);
                if (is_array($authorization) && count($authorization) == 2) {
                    $jwt_token = $authorization[1];
                    if ($jwt_token) {
                        $jwt = new JWT();
                        $jwt_secrect_key = "VitalInformationResourcesUnderSeize";
                        $decode_data = $jwt->decode($jwt_token,$jwt_secrect_key);
                                // dd($decode_data);
                        if ($decode_data) {
                            $current_time = strtotime(date("Y-m-d H:i:s"));
                            if (isset($decode_data->start_time) && isset($decode_data->end_time)) {
                                $start_time = $decode_data->start_time;
                                $end_time = $decode_data->end_time;
                                if ($start_time <= $current_time && $current_time <= $end_time) {
                                    return true;
                                }
                            }
                            return false;
                        }
                        return false;
                    }
                    return false;
                }
                return false;
            }
        }
        return false;
    }

    protected function setResponseJsonOutput($responseData = array(), $status = 200) {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit();
    }

}
