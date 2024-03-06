
<table id="postcode-distance-table" class="table sorting table-striped table-bordered dt-responsive ">
    <thead class="thead-default">

        <th class="font-width ">SN</th>
        <th class="font-width">FROM </th>
        <th class="font-width">TO</th>
        <th class="font-width">Miles</th>
        <th class="font-width ">Kilometers</th>
        <th class="font-width">Meters</th>
        <th class="font-width width-action">Action</th>

    </thead>
    <tbody>
    <?php
    if (!empty($postcode_distances)) {
        $count = 1;
        foreach ($postcode_distances as $p_distance):
            ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $p_distance->from ?></td>
                <td><?= $p_distance->to?></td>
                <td><?= $p_distance->miles ?></td>
                <td><?= $p_distance->kilometers ?></td>
                <td><?= $p_distance->meters ?></td>
                <td>
                    <a href="<?= base_url("admin/postcode_distance/edit/$p_distance->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a data-id="<?=$p_distance->id?>" class="btn btn-delete btn-danger btn-sm"><i class=" fa fa-times" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php
        endforeach;
    }
    ?>
    </tbody>
</table>
<script type="text/javascript">
    $('.postcode-distance-table tr .btn-delete').click(function () {

        var id=$(this).attr('data-id');
        var dish=$(this);

        if(confirm("Are you sure to delete?")){
            $.ajax({
                type: "POST",
                url:'<?=base_url('admin/postcode_distance/delete')?>' ,
                data: {'id':id},
                success: function (data) {

                    var isDeleted=data['is_deleted'];
                    if(isDeleted){
                        dish.closest('tr').remove();
                    }
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }




    });

  var table=  $('#postcode-distance-table').DataTable({
  });
 /*   var order =  table.order( [ 8, 'asc' ] )
        .draw();
*/



</script>