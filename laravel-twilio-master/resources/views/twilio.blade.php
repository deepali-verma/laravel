<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="{{url('../')}}/resources/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="{{url('../')}}/resources/assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{url('../')}}/resources/assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{{url('../')}}/resources/assets/css/style.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<title>Twilio</title>
</head>
<body>
    <div class="container">

        <div class="msg-panel">
            <h2>Call or message</h2>

            <div class="form-inline">
                <div class="form-group">
                    <label for="email">Phone Number:</label>
                    <input type="text" id="phone_no" class="form-control" placeholder="Phone Number">
                </div>
                <hr>
                <div class="text-left">
                    <button id="call_no" class="btn btn-info btn-md"> <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Call</button>
                    <button id="msg_no" class="btn btn-info btn-md" data-toggle="modal" data-target="#msgModal">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Message</button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div id="msgModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Message</h4>
      </div>
      <div class="modal-body">
          <div class="form-inline">
              <div class="form-group">
                <label for="msgbody">Type your message :</label>
                <textarea id ="msgbody" class="form-control" placeholder="Type your message"></textarea>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id = "send_msg" class="btn btn-default">Send Message</button>
      </div>
    </div>

  </div>
</div>
<div id= "base_url" style="display:none;" data-val="{{url('/')}}"></div>
<script>
    $('#call_no').on('click',function(){
        var phone_no = $('#phone_no').val();
        if(phone_no == ""){
            alert('Please enter a phone number');
            return false;
        }
        $.ajax({
            type : 'POST',
            url : $('#base_url').data('val')+'/api/makeCall',
            data : {
              phone_no: phone_no
            },
            dataType:'json',
            success : function(response){
                status = response.status;
                if(status == 400){
                    if(response.msg.phone_no != undefined){
                        alert(response.msg.phone_no);
                    }
                    else{
                        alert(response.msg);
                    }
                }
                else{
                    alert('Call connected!');
                }
            },
            error : function(errData){
                alert('Some error occured');
            }
        })
    });
    $('#send_msg').on('click',function(){
        var msg = $('#msgbody').val();
        if(msg == ""){
            alert('Please type something in message body');
            return false;
        }
        $.ajax({
            type : 'POST',
            url : $('#base_url').data('val')+'/api/sendSms',
            dataType:'json',
            data : {
              phone_no: $('#phone_no').val(),
              msg :  msg 
            },
            success : function(response){
                status = response.status;
                if(status == 400){
                    if(response.msg.msg != undefined){
                        alert(response.msg.msg);
                    }
                    else if(response.msg.phone_no != undefined){
                        alert(response.msg.phone_no);
                    }
                    else{
                        alert(response.msg);
                    }
                }
                else{
                    alert('Sent message successfully');
                }
            },
            error : function(errData){
                alert('Some error occured');
            }
        })
    });
    $('#msg_no').on('click',function(){
       var phone_no = $('#phone_no').val();
        if(phone_no == ""){
            alert('Please enter a phone number');
            return false;
        }
    });
</script>
</body>
</html>