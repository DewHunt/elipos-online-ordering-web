<?php
class File_upload extends Main_Controller

{
    public function __construct()
    {
        parent:: __construct();
        $this->load->helper('directory');
    }



    private function get_upload_directory(){
        $year = date("Y");
        $month = date("m");
        $current_directory='assets/uploads/'.$year.'/'.$month;
        if (!file_exists($current_directory)) {
            $current_directory= mkdir('assets/uploads/'.$year.'/'.$month, 0777, true);
        }
        return $current_directory;
    }

    public function image_upload(){
        if ($this->input->is_ajax_request()) {
            if ($this->m_users->is_logged_in()) {
                $this->get_upload_directory();
                $name=$this->input->post('input_name');
                $new_name = $_FILES["file"]['name'];
                $upload_path=$this->get_upload_directory();
                $config['file_name'] = $new_name;
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|png|pdf';
                $this->load->library('upload', $config);
                $is_upload = $this->upload->do_upload('file');
                if($is_upload){
                    $data = array('upload_data' => $this->upload->data());
                    $upload_file_name=$data['upload_data']['file_name'];
                    $upload_file_path=($upload_path.'/'.$upload_file_name);
                    ?>
                    <div class="image-url">
                        <input type="hidden"  name="<?=$name?>" value="<?=$upload_file_path?>">
                        <p class="text-xs-center" style="margin-top: 2rem">Upload Successful</p>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="image-url">
                        <p class="error margin-top-2">Upload Error,Try Again <?=$this->upload->display_errors()?></p>
                    </div>
                    <script>
                        $('.progress').css({'display':'none'});
                    </script>
                    <?php
                }
            }else{
                redirect();
            }

        }
    }

}
