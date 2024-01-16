<div class="table-responsive">
    <h3>Total Sales Today's  $<?=number_format($total_sales)?></h3>
    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Chasier</td>
                                <td>Quantity</td>
                                <td>Amount</td>
                                <td>Total</td>
                                <td>product</td>
                                <td>image</td>
                                <td>Date</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($sales) && $sales):?>
                            <?php foreach($sales as $key => $row):?>
                                <tr>
                                    <td><?=$key + 1?></td>
                                    <td><?=esc($row->name)?></td>
                                    <td><?=esc($row->quantity)?></td>
                                    <td><?=esc($row->amount)?></td>
                                    <td><?=esc($row->total)?></td>
                                    <td><?=esc($row->product)?></td>
                                    <td><img src="<?=ROOT?>/<?=$row->image?>" alt="" height="70" width="70"></td>
                                    <td><?=get_date($row->sales_date_created)?></td>
                                    <td class="d-flex">
                                        <a href="<?=ROOT?>/admin/sales/delete/<?=$row->sales_id?>">
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            <?php else:?>
                                <p class="d-flex justify-content-center align items-center alert alert-light">No Sales Found!!</p>
                            <?php endif;?>
                        </tbody>
    </table>
    <?=$pager->display()?>
</div>