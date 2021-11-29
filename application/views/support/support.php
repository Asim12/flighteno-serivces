<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Flighteno</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo SURL;?>assets/images/logo2.png">
        <!-- jvectormap -->
        <link href="<?php echo SURL;?>assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <!-- emoji picker style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />

        <!-- App css -->
        <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SURL;?>assets/css/app.min.css" rel="stylesheet" type="text/css" />      

        <style> 

            .filters_style {
                border-radius: 25px;
                border: 2px solid #e9ecef;
                background-color:  #f8f8f8;
            }
            .styleShow{
                border-radius: 25px;
                border: 2px solid #e9ecef;
                background-color:  #F18BB1;
            }
            /* .container{max-width:1170px; margin:auto;} */
            img{ max-width:100%; }
            .messaging { padding: 0 0 20px 0; width: 100%}
            .inbox_people {
                background: #f8f8f8 none repeat scroll 0 0;
                float: left;
                overflow: hidden;
                width: 40%; 
                border-right:1px solid #c4c4c4;
            }
            .inbox_msg {
                border: 1px solid #c4c4c4;
                clear: both;
                overflow: hidden;
            }
            .top_spac{ margin: 20px 0 0;}
            .recent_heading {float: left; width:40%;}

            .subject {float: left;}

            .srch_bar {
                display: inline-block;
                text-align: right;
                width: 60%;
            }
            .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

            .recent_heading h4 {
                color: #05728f;
                font-size: 21px;
                margin: auto;
            }
            .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
            .srch_bar .input-group-addon button {
                background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                border: medium none;
                padding: 0;
                color: #707070;
                font-size: 18px;
            }
            .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

            .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
            .chat_ib h5 span{ font-size:13px; float:right;}
            .chat_ib p{ font-size:14px; color:#989898; margin:auto}
            .chat_img {
                float: left;
                width: 11%;
            }
            .chat_ib {
                float: left;
                padding: 0 0 0 15px;
                width: 88%;
            }

            .chat_people{ overflow:hidden; clear:both;}
            .chat_list {
                border-bottom: 1px solid #c4c4c4;
                margin: 0;
                padding: 18px 16px 10px;
            }
            .inbox_chat { height: 90%; overflow-y: scroll;}

            .active_chat{ background:#ebebeb;}

            .incoming_msg_img {
                display: inline-block;
                width: 6%;
            }
            .received_msg {
                display: inline-block;
                padding: 0 0 0 10px;
                vertical-align: top;
                width: auto;
            }
            .received_withd_msg p {
                background: #ebebeb none repeat scroll 0 0;
                border-radius: 3px;
                color: #646464;
                font-size: 14px;
                margin: 0;
                padding: 5px 10px 5px 12px;
                width: auto;
            }
            .time_date {
                color: #747474;
                display: block;
                font-size: 12px;
                margin: 8px 0 0;
            }
            .received_withd_msg { width: auto;}

            .sent_msg_msg { width: auto;}
            .mesgs {
                float: left;
                padding: 30px 15px 0 25px;
                width: 60%;
            }

            .sent_msg p {
                background: #05728f none repeat scroll 0 0;
                border-radius: 3px;
                font-size: 14px;
                margin: 0; color:#fff;
                padding: 5px 10px 5px 12px;
                width:auto;
            }
            .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
            .sent_msg {
                float: right;
                width: 50%;
            }
            .input_msg_write input {
                background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                border: medium none;
                color: #4c4c4c;
                font-size: 15px;
                width: 100%;
            }

            .type_msg {
                position: relative;
            }
            .msg_send_btn {
                background: #F18BB1 none repeat scroll 0 0;
                border: medium none;
                border-radius: 50%;
                color: #fff;
                cursor: pointer;
                font-size: 17px;
                height: 33px;
                position: absolute;
                right: 6px;
                top: 15px;
                width: 33px;
            }
            .fileIcon {
                border: medium none;
                color: #625c5c;
                cursor: pointer;
                font-size: 15px;
                height: auto;
                position: absolute;
                left: 8px;
                margin-left : 3%;
                top: 1%;
                width: 52px;
                background-color: #f8f8f8;
            }  
            .imageIcon {
                border: medium none;
                color: #625c5c;
                cursor: pointer;
                font-size: 15px;
                height: auto;
                position: absolute;
                margin-left: 7%;
                top: 1%;
                width: 52px;
                background-color: #f8f8f8;
            } 
            .msg_history {
                height: 740px;
                overflow-y: auto;
            }
            /* pagination */
            .pagination a {
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
            }

            .pagination a.active {
                background-color: #4CAF50;
                color: white;
                border-radius: 5px;
            }

            .pagination a:hover:not(.active) {
                background-color: #ddd;
                border-radius: 5px;
            }
            table {border: none;}
            .titleStyle{
                font-style: normal;
                font-weight: 800;
                font-size: 40px;
                color: #18243C;
                margin-top: 2%;
                margin-left: 0%;
                margin-bottom: 1%;
            }

            .topnav {
                overflow: hidden;
                background-color: #f8f8f8;
            }

            .topnav a {
                float: left;
                display: block;
                color: black;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
                border-bottom: 3px solid transparent;
            }

            .topnav a:hover {
                border-bottom: 3px solid #E12082;
            }

            .topnav a.active {
                border-bottom: 3px solid #E12082;
                color: black;
            }
            .image-upload>input {
                display: none;
            }

            .positionStyle{
                font-size:30px; 
                margin-left: 6%;
                position: absolute; 
                /* background-color: #eeeeee; */
                height: 100%;
                /* width: 7%; */
                text-align: center;
               
            }

            .positionFile{
                font-size:30px; 
                position: absolute; 
                /* background-color: #eeeeee; */
                height: 100%;
                /* width: 7%; */
                text-align: center;
                /* border-radius: 18px;
                border: 2px solid #e9ecef; */
            }
        </style>
    </head>

    <body>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('includes/topbar.php');?>
            <!-- end Topbar -->
            <?php include('includes/sidebar.php');?>

            <div class="content-page">
                <div class="content" style="margin-top:2%;">
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="col-12 mt-3">
                            <h4 class="page-title styleHeader titleStyle">Messages<h4>
                        </div> 
                        <div class="row" >
                            <!-- <h3 class=" text-center">Messaging</h3> -->
                            <div class="messaging ">
                                <div class="inbox_msg filters_style">

                                    <div class="headind_srch">
                                        <?php 
                                            $tabClass =  $this->session->userdata('tab');
                                            if($tabClass == 'traveler'){

                                                $buyerClass="";
                                                $travelerClass="active";
                                            }else{

                                                $buyerClass="active";
                                                $travelerClass="";
                                            }
                                        ?>
                                            
                                        <div class="topnav" style="width:75%">
                                            <a class="<?php echo $buyerClass;?>" style="width:25%"  href="<?php echo base_url();?>index.php/admin/Support/tickets?profile=buyer">Buyers</a>
                                            <a class="<?php echo $travelerClass;?>" style="width:25%" href="<?php echo base_url();?>index.php/admin/Support/tickets?profile=traveler">Travelers</a>
                                        </div>
                                    </div>
                                    <div class="inbox_people" style="height: 840px;overflow-y: auto;">
                                        <div class="inbox_chat">

                                            <?php foreach($tickets as $ticket) { ?>
                                                <?php
                                                    if( empty($ticket['ticketUserData'][0]['profile_image']) ){

                                                        $imageSource = "https://ptetutorials.com/images/user-profile.png";
                                                    }else{

                                                        $imageSource = $ticket['ticketUserData'][0]['profile_image'];
                                                    }


                                                    if(!empty($ticket['created_date'])){
                                                        
                                                        $time_zone = date_default_timezone_get();
                                                        $date = $ticket['created_date']->toDateTime()->format("Y-m-d H:i:s");
                                                        $last_time_ago = time_elapsed_string($date , $time_zone);
                                
                                                    }else{
                                                        $last_time_ago = '---';
                                                    }
                                                ?>
                                                <table width="100%" style="cursor:pointer">
                                                    <tr class="click" width="100%">
                                                        <td>
                                                            <div class="chat_list"> 
                                                                <input type="hidden" name="id" value="<?php echo (string)$ticket['_id']; ?>" />
                                                                <div class="chat_people">
                                                                    <div class="chat_img"> <img src="<?php echo $imageSource; ?>" alt="" class="rounded-circle images avatar-sm bx-shadow-lg image2"> </div>
                                                                    <div class="chat_ib">
                                                                        <h5><?php echo $ticket['ticketUserData'][0]['full_name']; ?> <span class="chat_date"><?php echo $last_time_ago; ?></span></h5>
                                                                        <p><?php echo $ticket['subject'];?></p>
                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    <div class="pagination" ><?php  echo $this->pagination->create_links(); ?></div>
                                </div>
                                <div class="mesgs">
                                    <div class="" id= "detailOrder">

                                    </div>
                                    
                                    <div class="msg_history" id="messagesData">
                
                                    </div>

                                    <div class="type_msg" id ="messageReply">
                                        <div class="input_msg_write image-upload" style="display: flex">

                                            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/admin/Support/fileUpload">
                                                <div class="image-upload">
                                                    <label for="fileUploaded" class="positionFile" > 
                                                        <i class="fas fa-paperclip"></i>
                                                    </label>     
                                                    <input class="fileIcon" id="fileUploaded" type="file" accept="application/doc|application/csv|application/ppt|application/docx|application/txt|application/pdf" onchange="fileUpload(this)" />
                                                </div>
                                            </form>

                                            <form id="reg" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/admin/Support/imageSendUpload">
                                                <div class="image-upload">
                                                    <label for="file-input"class="positionStyle" > 
                                                        <i class="fas fa-image"></i>
                                                    </label> 
                                                    <input class="imageIcon" id="file-input" type="file" onchange="imageUpload(this)"  accept="application/gif|application/jpeg|application/png|application/jpg" />
                                                </div>
                                            </form>
                                                
                                            <textarea type="text" style="margin-left:12%" class="write_msg form-control textarea-control filters_style" placeholder="Type your message..." id="sendMessage"></textarea>
                                            <button class="msg_send_btn" type="button"> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                    </div> <!-- container -->
                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('includes/footer.php');?>
                <!-- end Footer -->
            </div>
        </div>

        <!-- App js -->
        <script src="<?php echo SURL;?>assets/js/app.min.js"></script>

        <script src="<?php echo SURL;?>assets/js/vendor.min.js"></script>
  
        <!-- App js -->
        <script src="<?php echo SURL;?>assets/js/app.min.js"></script>
        <script>
            function imageUpload(theForm) { 
                var data = new FormData();
                var files = $("#file-input").get(0).files;
                if (files.length > 0) {
                    data.append("image", files[0]);
                }
                var Id = $('#ticketId').val();
                data.append("ticketId", Id);
                
                $.ajax({
                    url: '<?php echo base_url();?>index.php/admin/Support/imageSendUpload',
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (response) {
                        $('#file-input').val(''); 
                        var image = '<div class="outgoing_msg">';
                        image += '<div class="sent_msg">';                        
                        image += '<a href="'+response+'" download><img src="'+response+'" width="100" height="104">';
                        image += '</a>';
                        image += '<span class="time_date">'+ new Date() +'</span>';
                        image += '</div>';
                        image += '</div>';
                        $('#messagesData').append(image);
                    },
                    error: function (er) {
                        var image = '<div class="outgoing_msg">';
                        image += '<div class="sent_msg">';
                        image += '<img src="'+er+'" alt="" class="images avatar-sm bx-shadow-mg">';
                        image += '<span class="time_date">'+ new Date() +'</span>';
                        image += '</div>';
                        image += '</div>';
                        $('#messagesData').append(image);
                    }
                });
            }//end

            function fileUpload(form) {
                var data = new FormData();
                var files = $("#fileUploaded").get(0).files;
                if (files.length > 0) {
                    data.append("file", files[0]);
                }
                var Id = $('#ticketId').val();
                data.append("ticketId", Id);

                $.ajax({
                    url: '<?php echo base_url();?>index.php/admin/Support/fileSendUpload',
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (response) {
                        $('#fileUploaded').val(''); 
                        var file = '<div class="outgoing_msg">';
                        file += '<div class="sent_msg">';

                        file += '<a href="'+response+'" download>download</a>';
                        // <iframe src="'+response+'" frameborder="0"  class="avatar-sm bx-shadow-mg"></iframe>
                        file += '</a>';
                        file += '<span class="time_date">'+ new Date() +'</span>';
                        file += '</div>';
                        file += '</div>';

                        $('#messagesData').append(file);
                        $('#messagesData').append(image);
                    },
                    error: function (er) {
                        var image = '<div class="outgoing_msg">';
                        image += '<div class="sent_msg">';
                        image += '<img src="'+er+'" alt="" class="images avatar-sm bx-shadow-mg">';
                        image += '<span class="time_date">'+ new Date() +'</span>';
                        image += '</div>';
                        image += '</div>';
                        $('#messagesData').append(image);
                    }
                });        
            };//end

            $(document).ready(function(){
                $('.click').click(function(){
                    $("tr").removeClass('active_chat');
                    $(this).closest("tr").addClass('active_chat');

                    var currentRow =   $(this).closest("tr"); 
                    var ticketId   =   currentRow.find("input[type='hidden']").val();
                    $.ajax({
                        'url': '<?php echo base_url();?>index.php/admin/Support/getMessages',
                        'type': 'POST',
                        'data': {ticketId : ticketId},
                        'success': function (response) {
                            var data =  JSON.parse(response);
                            
                            var orderDetails = '';
                            var htmlDesign = '';
                            var admin_id = data[0]['admin_id'];
                            var ticket_id = data[0]['_id'].toString();
                            var order_number = data[0]['order_number'];
                            var subject = data[0]['subject'];
                            var firstMessage = data[0]['message'];

                            var created_date = data[0]['created_date'];

                            var videos = data[0]['video'];
                            var images = data[0]['image'];

                            var fullName     =  data[0]['profileData'][0]['full_name'];
                            var emailAddress =  data[0]['profileData'][0]['email_address'];
                            var image;
                          
                            image = (data[0]['profileData'][0]['profile_image']) ? data[0]['profileData'][0]['profile_image'] : 'https://ptetutorials.com/images/user-profile.png';
                            
                            orderDetails += '<div class="inbox_chat">';
                            orderDetails += '<div class="chat_list">';
                            orderDetails += ' <div class="chat_people">';
                            orderDetails += '<div class="chat_img"> <img src="'+image+'" alt="" class="rounded-circle images avatar-sm bx-shadow-lg image2"> </div>';
                            orderDetails += '<div class="chat_ib">';
                            orderDetails += '<h5>'+fullName+'<span class="chat_date" style="color:#E1467D">Order No.<span style="color:#898A8D; margin-left:7px">'+order_number+'</span></span></h5>';
                            orderDetails += '<p>'+emailAddress+'</p>';
                            orderDetails += '</div>';
                            orderDetails += '</div>';
                            orderDetails += '</div>';
                            orderDetails += '<div class="subject" style="width : 100%">';
                            orderDetails += '<h5 style="color:#E1467D"> Subject:<span style="color:#898A8D; margin-left: 4%">'+subject+'</span></h5>'; 
                            orderDetails += '</div>';

                            orderDetails += '<input type="hidden" id="ticketId" value="' +ticket_id+ '" />';
                            $('#detailOrder').html(orderDetails);

                            htmlDesign += '<div class="incoming_msg" style="margin-top;2%">';
                            htmlDesign += '<div class="incoming_msg_img">';
                            htmlDesign += '<img src="'+image+'" class="rounded-circle images avatar-sm bx-shadow-lg image2" alt="">';
                            htmlDesign += '</div>';
                            htmlDesign += '<div class="received_msg">';
                            htmlDesign += '<div class="received_withd_msg">';
                            if(videos){

                                htmlDesign +='<video width="125px" height="125px" controls><source src="'+ videos['0'] +'" ></video>';
                            }
                            if(images){

                                htmlDesign += '<img src="'+images[0]+'" alt="user-image" class="img-rounded" width="125px" height="125px"/>'
                            } 
                            htmlDesign += '<p style="border-radius: 25px; border: 2px solid #e9ecef; background-color:#ebebeb;">'+ firstMessage +'</p>';
                            htmlDesign += '<span class="time_date">'+created_date+'</span>';
                            htmlDesign += '</div>';
                            htmlDesign += '</div>';
                            htmlDesign += '</div>';

                            for(i= 0; i < data[0]['messages'].length; i++){

                                if(admin_id != data[0]['messages'][i]['admin_id']){
                                    htmlDesign += '<div class="outgoing_msg">';
                                    htmlDesign += '<div class="sent_msg">';    

                                    if(data[0]['messages'][i]['image'] &&  data[0]['messages'][i]['image'] !== isNaN && data[0]['messages'][i]['image'] !== null ){

                                        htmlDesign += '<a href="'+data[0]['messages'][i]['image']+'" download><img src="'+data[0]['messages'][i]['image']+'" width="100" height="104">';
                                        htmlDesign += '</a>';
                                    }else if(data[0]['messages'][i]['file'] && data[0]['messages'][i]['file'] !== '' ){

                                        htmlDesign += '<a href="'+ data[0]['messages'][i]['file']+'" download> <i class="fas fa-file-download" style="font-size:55px"></i></a>';
                                        htmlDesign += '</a>';
                                    }else{

                                        htmlDesign += '<p style="border-radius: 25px; border: 2px solid #e9ecef; background-color:#F18BB1;">'+data[0]['messages'][i]['message']+'</p>';
                                    }

                                    htmlDesign += '<span class="time_date">'+ data[0]['messages'][i]['created_date'] +'</span>';
                                    htmlDesign += '</div>';
                                    htmlDesign += '</div>';
                                }else{
                                    var profileImage = (data[0]['messages'][i]['userData'][0]['profile_image']) ? data[0]['messages'][i]['userData'][0]['profile_image'] : 'https://ptetutorials.com/images/user-profile.png';
                                    htmlDesign += '<div class="incoming_msg">';
                                    htmlDesign += '<div class="incoming_msg_img">';
                                    htmlDesign += '<img src="'+profileImage+'" class="rounded-circle images avatar-sm bx-shadow-lg image2" alt="">';
                                    htmlDesign += '</div>';
                                    htmlDesign += '<div class="received_msg">';
                                    htmlDesign += '<div class="received_withd_msg">'; 
                                    htmlDesign += '<p style="border-radius: 25px; border: 2px solid #e9ecef; background-color:#ebebeb;">'+ data[0]['messages'][i]['message'] +'</p>';
                                    htmlDesign += '<span class="time_date">'+ data[0]['messages'][i]['created_date']+'</span>';
                                    htmlDesign += '</div>';
                                    htmlDesign += '</div>';
                                    htmlDesign += '</div>';
                                }
                            }//end loop
                            $('#messagesData').html(htmlDesign);

                            // var ticketReply = '<div class="input_msg_write" style="display: flex">';
                            // ticketReply +='<button class="fileIcon" type="button"><i class="fas fa-paperclip" aria-hidden="true"></i></button>';
                            // ticketReply +='<button class="emojiIcon" type="button"> <i class="far fa-frown openemoji" aria-hidden="true"></i></button>';
                            // ticketReply +='<textarea type="text" class="write_msg form-control textarea-control filters_style" placeholder="type Message" id="sendMessage"></textarea>';
                            // ticketReply +='<button class="msg_send_btn" type="button"> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>';
                            // ticketReply +='</div>'; 
                            // $('#messageReply').html(ticketReply);
                        }
                    });
                })
            });
            $(document).ready(function() {
                $('.msg_send_btn').click(function() {
                    let ticketId    = $('#ticketId').val();
                    let sendMessage = $('#sendMessage').val();
                    var addMessage = '';
                    if(sendMessage){  
                        $.ajax({
                            'url': '<?php echo base_url();?>index.php/admin/Support/sendMessage',
                            'type': 'POST',
                            'data': {ticketId : ticketId, sendMessage : sendMessage},
                            'success': function (response) {
                                $('#sendMessage').val('');
                                $('#pstyleCountager span').remove();

                                addMessage += '<div class="outgoing_msg">';
                                addMessage += '<div class="sent_msg">';
                                addMessage += '<p style="border-radius: 25px; border: 2px solid #e9ecef; background-color:#F18BB1;">'+sendMessage+'</p>';
                                addMessage += '<span class="time_date">'+ new Date() +'</span>';
                                addMessage += '</div>';
                                addMessage += '</div>';

                                // addMessage += '<div class="outgoing_msg">';
                                // addMessage += ' <div class="sent_msg" style="display:flex">';
                                // addMessage += '<div style="width:14%;"> <img src="https://ptetutorials.com/images/user-profile.png" alt=""> </div> ';
                                // addMessage += '<div style="margin-left: 3%">';
                                // addMessage += '<p style="border-radius: 25px; border: 2px solid #e9ecef; background-color:#F18BB1;">'+sendMessage+'</p>';
                                // addMessage += '<span class="time_date">'+new Date()+'</span>';
                                // addMessage += '</div>';
                                // addMessage += '</div>';
                                // addMessage += '</div>';

                                $('#messagesData').append(addMessage);
                            }
                        });
                    }
                });
            });
        </script>
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.usa.js"></script>
        <script src="<?php echo SURL;?>assets/js/pages/dashboard.init.js"></script>
        <!-- App js -->
        <script src="<?php echo SURL;?>assets/js/vendor.min.js"></script>
        <!-- KNOB JS -->
        <script src="<?php echo SURL;?>assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <!-- Chart JS -->
        <script src="<?php echo SURL;?>assets/libs/chart-js/Chart.bundle.min.js"></script>
        <!-- Jvector map -->
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/jqvmap/jquery.vmap.usa.js"></script>
        <!-- Datatable js -->
        <script src="<?php echo SURL;?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo SURL;?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <!-- Dashboard Init JS -->
        <script src="<?php echo SURL;?>assets/js/pages/dashboard.init.js"></script>
        <!-- App js -->
        <script src="<?php echo SURL;?>assets/js/app.min.js"></script>

        <!-- emoji picker script -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
        <script>
            // $('#sendMessage').emojioneArea({
            //     pickerPosition: "top"
            // });

            $(document).ready(function(){

                // $("#sendMessage").removeClass("form-control");
            })
        </script>
    </body>
</html>