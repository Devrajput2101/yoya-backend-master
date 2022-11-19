<?php 

function booking_status($status_selected = null){
    $status = [
            ['status'=>'booking_accepted','display_status'=>'Order Accepted','remark'=>'Order accepted by driver !'],
            ['status'=>'booking_started','display_status'=>'Order on The Way','remark'=>'Order on the way !'],
            ['status'=>'booking_reached','display_status'=>'Order Reached','remark'=>'The driver has reached at your location with the order'],
            ['status'=>'booking_cancel_by_customer','display_status'=>'Order Cancel','remark'=>'Order has been cancel by Customer !'],
            ['status'=>'booking_cancel_by_driver','display_status'=>'Order Cancel','remark'=>'Order has been cancel by Driver !'],
            ['status'=>'booking_completed','display_status'=>'Order Completed','remark'=>'Order Completed !'],
            ['status'=>'booking_cancel_by_admin','display_status'=>'Order Cancel','remark'=>'Order has been cancel by Bullet express courier !'],
        ];
        /*onl selected data get any where */
        foreach($status as $key => $data){
            if($status_selected == $data['status']){
               $status = $data;
               break;
            }
        }
        
    return $status;
}

function payment_status($status_selected = null){
    $status = [
            ['status'=>'payment_pending','display_status'=>'Pending payment','remark'=>'Pending payment !'],
            ['status'=>'payment_failed','display_status'=>'Payment failure','remark'=>'Payment failure !'],
            ['status'=>'payment_complete','display_status'=>'Payment complete','remark'=>'Payment complete !'],
            ['status'=>'payment_refund','display_status'=>'Payment Refund !','remark'=>'Payment Refund !'],
        ];
        /*onl selected data get any where */
        foreach($status as $key => $data){
            if($status_selected == $data['status']){
               $status = $data;
               break;
            }
        }
        
    return $status;
}


function ticket_status($status_selected = null){
    $status = [
            ['status'=>'open','display_status'=>'Open Ticket !','remark'=>'Open Ticket !'],
            ['status'=>'pending','display_status'=>'Pending Ticket !','remark'=>'Pending Ticket !'],
            ['status'=>'close','display_status'=>'Close Ticket !','remark'=>'Close Ticket !'],
            ['status'=>'resolved','display_status'=>'Resolved Ticket !','remark'=>'Resolved Ticket !'],
           
        ];
        /*onl selected data get any where */
        foreach($status as $key => $data){
            if($status_selected == $data['status']){
               $status = $data;
               break;
            }
        }
        
    return $status;
}


function ticket_priority($status_selected = null){
    $status = [
            ['status'=>'critical','display_status'=>'Critical !','remark'=>'Critical !'],
            ['status'=>'high','display_status'=>'High !','remark'=>'High !'],
            ['status'=>'normal','display_status'=>'Normal !','remark'=>'Normal !'],
            ['status'=>'low','display_status'=>'Low !','remark'=>'Low !'],
        ];
        /*onl selected data get any where */
        foreach($status as $key => $data){
            if($status_selected == $data['status']){
               $status = $data;
               break;
            }
        }
        
    return $status;
}