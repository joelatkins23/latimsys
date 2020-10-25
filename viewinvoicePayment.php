<?php 
include 'conn.php';
session_start();
$id= $_GET['id'];
    $consulta2 = mysqli_query($connect, "select a.*, b.station as branch_name, c.name as type_name, d.name as account_name from invoicepayments a 
                                    left join branches b on a.branch=b.id 
                                    left join bill_type c on a.type=c.id 
                                    left join accounts d on a.account=d.id 
                                    WHERE a.id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $branch=$row['branch_name'];
        $date=$row['date'];
        $account= $row['account_name'];
        $type= $row['type_name'];
        $amount= $row['amount'];
        $currency= $row['currency'];
        $id= $row['id'];
        $date= date_format(date_create($row['exchange']),'m/d/Y');
        $number= $row['number'];
        $reference= $row['reference'];
        $comments= $row['comments'];
}
?>

<!-- Modal content-->

<div class="modal-content">   
    <div class="modal-body" style="margin:10px">
       <div class="row">
           <div class="col-md-12">
               <img src="./img/company_logo.jpg" alt="">
               <p style="margin-bottom:0px;font-size:10px"><strong> No. 2 Acacias Street, Banghu Village</strong></p>
               <p style="font-size:10px"><strong>Guangzhou Guangdong 510470</strong></p>
           </div>
           <div class="col-md-12" style="border-bottom:2px solid #000">
               <h4 style="font-weight:800">Cashier's Receipt </h4>
           </div>
           <div class="col-md-12" style="margin:20px 10px">
               <div class="col-md-6">
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Branch</label>
                        <label for="" class="control-label col-md-6"><?php echo $branch;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Account</label>
                        <label for="" class="control-label col-md-6"><?php echo $account;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Type</label>
                        <label for="" class="control-label col-md-6"><?php echo $type;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Check Amount</label>
                        <label for="" class="control-label col-md-6"><?php echo $currency;  ?> <?php echo $amount;  ?></label>
                    </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Number</label>
                        <label for="" class="control-label col-md-6"><?php echo $id;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Date</label>
                        <label for="" class="control-label col-md-6"><?php echo $date;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Number</label>
                        <label for="" class="control-label col-md-6"><?php echo $number;  ?></label>
                    </div>
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6" style="font-weight:300">Reference</label>
                        <label for="" class="control-label col-md-6"><?php echo $reference;  ?></label>
                    </div>
               </div>
               <div class="col-md-12">
                    <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-3" style="font-weight:300">Comments</label>
                        <label for="" class="control-label col-md-9"><?php echo $comments;  ?></label>
                    </div>
               </div>
           </div>
           <div class="col-md-12" style="border-top:2px solid #000">
                <div class="col-md-12" style="margin-top:15px; margin-bottom:15px;">
                    <table style="width:100%;border: 1px solid;" class='display dataTable'>
                        <thead>
                            <tr>
                                <th>Invoice Number</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $consulta2 = mysqli_query($connect, "SELECT * FROM invoicepayments_contents WHERE invoice_payment_id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
                            if(mysqli_num_rows($consulta2)>0){
                            
                                while ($row = mysqli_fetch_array($consulta2)){
                                    ?> 
                                    <tr>
                                        <td class="text-left"><?php  echo $row['invoice_id']?></td>
                                        <td class="text-right"><?php  echo $row['currency']?> <?php  echo $row['paid']?></td>
                                    </tr>
                             <?php } ?>     
                            <?php }else{ ?>
                                <?php 
                                    $consulta2 = mysqli_query($connect, "SELECT * FROM invoicepayments WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
                            
                                while ($row = mysqli_fetch_array($consulta2)){
                                    ?> 
                                    <tr>
                                        <td class="text-left">Credit Note</td>
                                        <td class="text-right"><?php  echo $row['currency']?> <?php  echo $row['amount']?></td>
                                    </tr>
                             <?php } ?> 
                             <?php } ?> 
                        </tbody>
                    </table>
                </div>
               
           </div>
       </div>
    </div>
</div>
<script>
$(".select2").select2();
</script>
