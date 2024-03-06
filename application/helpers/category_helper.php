<?php

function get_parent_categories(){
    $CI=&get_instance();
    $CI->load->model('Category_Model');
    $CI->Category_Model->db->order_by('sort_order','ASC');
    return $CI->Category_Model->get_where('parent_id',0);
}



function get_category_template($id=0){
    $CI=&get_instance();
    $CI->load->model('Category_Model');
    $CI->Category_Model->db->order_by('sort_order','ASC');
    $parents=$CI->Category_Model->get_where('parent_id',$id);
    if(!empty($parents)){
        foreach($parents as $parent){
            $current_id=$parent->id;
            $CI->Category_Model->db->order_by('sort_order','ASC');
            $child=$CI->Category_Model->get_where('parent_id',$current_id);
            if(!empty($child)){
                ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="category_id[]"  value="<?=$parent->id?>">
                       <?=$parent->name?>
                    </label>
                </div>
                <?php
                $CI->Category_Model->db->order_by('sort_order','ASC');
                $child=$CI->Category_Model->get_where('parent_id',$current_id);
                get_category_template($current_id);
            }else{
                ?>

                <div class="form-check" style="margin-left: 1rem">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="category_id[]" value="<?=$parent->id?>">
                        <?= $parent->name?>
                    </label>
                </div>

            <?php
            }

        }

    }


}

function get_category_template_for_update($id=0,$category_ids=array()){
    $CI=&get_instance();
    $CI->load->model('Category_Model');
    $CI->Category_Model->db->order_by('sort_order','ASC');
    $parents=$CI->Category_Model->get_where('parent_id',$id);
    $category_ids_new=$category_ids;
    if(!empty($parents)){
        foreach($parents as $parent){
            $current_id=$parent->id;
            $CI->Category_Model->db->order_by('sort_order','ASC');
            $child=$CI->Category_Model->get_where('parent_id',$current_id);
            if(!empty($child)){
                ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" <?php if(in_array($parent->id,$category_ids_new)){echo 'checked';}?>  name="category_id[]"  value="<?=$parent->id?>">
                        <?=$parent->name?>
                    </label>
                </div>
                <?php
                $CI->Category_Model->db->order_by('sort_order','ASC');
                $child=$CI->Category_Model->get_where('parent_id',$current_id);
                get_category_template_for_update($current_id,$category_ids_new);

            }else{

                ?>

                <div class="form-check" style="margin-left: 1rem">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"  <?php  if(in_array($parent->id,$category_ids_new)){ echo'checked';} ?> name="category_id[]" value="<?=$parent->id?>">
                        <?= $parent->name?>
                    </label>
                </div>

                <?php
            }

        }

    }


}

function get_category_name($id){
    $CI=&get_instance();
    $CI->load->model('Category_Model');
    return $CI->Category_Model->get($id,true)->name;
}