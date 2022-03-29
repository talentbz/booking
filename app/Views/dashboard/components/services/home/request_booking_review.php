<?php
if (empty($bookingObject)) {
    return;
}
$status = booking_status_info($bookingObject->status);
$bookingID = $bookingObject->ID;
$paymentID = $bookingObject->payment_type;
$paymentObject = get_payments($paymentID);
$serviceObject = get_booking_data($bookingID, 'serviceObject');
$bookingData = get_booking_data($bookingID);
?>
<div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <input type="text" class="form-control" id="useremail" disabled value="<?php echo $bookingObject->email; ?>">
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Description</label>
    <textarea class="form-control" id="description" name="detail" aria-describedby="description" placeholder="Enter Description"></textarea>
</div>

<input type="hidden" name="bookingID" value="<?php echo $bookingID;?>">

