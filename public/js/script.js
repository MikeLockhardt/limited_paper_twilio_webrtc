$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var scrolled = false;
    function updateScroll(){
        if(!scrolled){
            var element = document.getElementById("chat_list");
            element.scrollTop = element.scrollHeight;
    
        }
    }
    $("#chat_list").on('scroll', function(){
        scrolled=true;
    });    
    setInterval(updateScroll,500);
    $("#chatText").keyup(function(event) {
        if (event.keyCode === 13) {
            $(".blueButton").click();
            
        }

    });
	$('.blueButton').click(function(){
        
        scrolled=false;
        var text = $('#chatText').val();
        $('#chatText').val('');
       
        if(text.length == 0){
            return false;
        }
        text=text.replace(/</g,'&lt;').replace(/>/g,'&gt;');
        var phone_number=$('#phone_number').text();
        var active_number=phone_number.split(/[.:_]/)[1];
        active_number = active_number.trim();
        // alert(active_number);
        $.ajax({
            type:'POST',
            url:'/submitChat',
            data:{chatText : text, number: active_number},
            success:function(response){
               var new_chat='<div class="group-rom"><div class="first-part ">'+response.data['author']+'</div>'+'<div class="third-part ">'+response.data['created_at']+'</div>'+'<div class="second-part">'+response.data['text']+'</div></div>';
               $("#chat_list").append(new_chat);
            }
         });
        
    });
    // $('#phone_save').click(function(){
    //     var number = $('#number').val();
    //     var name = $('#phone_name').val();
    //     var temp= name+':'+number;
    //     $('#phone_number').html(temp);
    //     $('#number').val('');
    //     $('#phone_name').val('');
        
    //     // var temp='<ul class="chat-list chat-user"><li id="new_customer"><a href="#"><i class="fa fa-circle text-success"></i>            <span style="">'+temp+' </span></a></li></ul>';
    //     // $('#home').append(temp);
    //     // $('#new_customer').addClass('active');
    //     $.ajax({
    //         type:'POST',
    //         url:'/saveNumber',
    //         data:{number : number,name:name},
    //         success:function(response){
    //             window.location.href = "/";
    //         }
    //      });
    // });
    $('#phone_save').click(function(){
        
        var phone_number=$('#phone_number').text();
        var active_name=phone_number.split(/[.:_]/)[0];
        active_name = active_name.trim();
        var active_number = phone_number.split(/[.:_]/)[1];
        active_number = active_number.trim();
        var name=$('#customer_name').val();
        var email=$('#customer_email').val();
        var restaurant=$('#customer_restaurant').val();
        var location=$('#customer_location').val();
        
        $.ajax({
            type:'POST',
            url:'/saveInfo',
            data:{number : active_number,name:name,email:email,restaurant:restaurant,location:location},
            success:function(response){
                window.location.href = "/";
            }
         });
    });
   
    function display(){
        console.log('display');
        var phone_number=$('#phone_number').text();
        var active_number=phone_number.split(/[.:_]/)[1];
        active_number = active_number.trim();
        console.log(active_number);
        $.ajax({
            type:'POST',
            url:'/getChat',
            data:{number : active_number},
            success:function(responses){
               
              
                $("#chat_list").html('');
                for (i = 0; i < responses.data.length; i++) {
                    
                    var new_chat='<div class="group-rom"><div class="first-part  ">'+responses.data[i]['author']+'</div>'+'<div class="third-part">'+responses.data[i]['created_at']+'</div>'+'<div class="second-part">'+responses.data[i]['text']+'</div></div>';
                    
                   
                    $("#chat_list").prepend(new_chat);
                    // var temp= responses.name+' : '+responses.to;
                    // $('#phone_number').html(temp);
                    // $('#new_customer span').html(temp);
                    // $('#new_customer').addClass('active');

                }

          
            }
        });
    }
    setInterval(display,1000);
   
    function refresh(){
       
        $.ajax({
            type:'GET',
            url:'/getCount',
            success:function(response){
                
                
                if(response.data=='1'){
                    window.location.href = "/";
                    
                }
            }
        });
    }
    
    setInterval(refresh, 1000);
    $('.endButton').click(function(){
        var phone_number=$('#phone_number').text();
        var active_number=phone_number.split(/[.:_]/)[1];
        active_number = active_number.trim();
        
        // var temp='<ul class="chat-list chat-user"><li id="new_customer"><a href="#"><i class="fa fa-circle text-success"></i>            <span style="">'+temp+' </span></a></li></ul>';
        // $('#home').append(temp);
        // $('#new_customer').addClass('active');
        $.ajax({
            type:'POST',
            url:'/endChat',
            data:{number : active_number},
            success:function(){
                window.location.href = "/";
            }
         });
         
    });
   
    //active menu
    var header = document.getElementById("home");
    var btns = header.getElementsByClassName("new_customer");
    btns[0].className+=" active";
    var name=$(btns[0]).data('custom-name');
    var phone=btns[0].id;
    var temp = name+':'+phone;
    $('#phone_number').html(temp);
    
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = header.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            // alert(document.getElementsByClassName("new_customer")[i].id);
            var name=$(this).data('custom-name');
            var phone=this.id;
            var temp = name+':'+phone;
            $('#phone_number').html(temp);
        });
    }
    //active menu
    var header1 = document.getElementById("menu1");
    var btns1 = header1.getElementsByClassName("new_customer");
    btns1[0].className+=" active";
    // var name=$(btns1[0]).data('custom-name');
    // var phone=btns1[0].id;
    // var temp = name+' : '+phone;
    $('#phone_number').html(temp);
    for (var i = 0; i < btns1.length; i++) {
        btns1[i].addEventListener("click", function() {
            var current = header1.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            var name=$(this).data('custom-name');
            var phone=this.id;
            var temp = name+':'+phone;
            $('#phone_number').html(temp);
           
        });
    }
    $("#inactive_tab").click(function(){
        
        $(".endButton").css("display", "none"); 
        document.getElementById("chatText").disabled = true;
    });
    $("#active_tab").click(function(){
        $(".endButton").css("display", "block"); 
        document.getElementById("chatText").disabled = false;
    });
   
    var phone_number=$('#phone_number').text();
    var active_name=phone_number.split(/[.:_]/)[0];
    active_name = active_name.trim();
    var active_number = phone_number.split(/[.:_]/)[1];
    active_number = active_number.trim();
  
    if(active_name=="undefined"){
        
        // $('#info_panel_add').html('');
        // var temp='<div class="form-group"  style="padding:10px"><label for="customer_name">Name</label><input type="text" class="form-control" id="customer_name" ></div><div class="form-group"  style="padding:10px"><label for="customer_email">Email</label><input type="text" class="form-control" id="customer_email" ></div><div class="form-group"  style="padding:10px">        <label for="customer_restaurant">Restaurant Name</label><input type="text" class="form-control"     id="customer_restaurant" ></div><div class="form-group"  style="padding:10px"><label for="customer_location">Location</label><input type="text" class="form-control" id="customer_location" ></div><div class="form-group"  style="padding:10px"><button type="button" class="btn btn-danger " id="customer_add" style="width:100%">Add</button></div>';
        // $('#info_panel_add').append(temp);
    }else{
        
        $.ajax({
            type:'POST',
            url:'/getInfo',
            data:{number : active_number},
            success:function(response){
                // var new_chat='<div class="group-rom"><div class="first-part  ">'+response.data[i]['author']+'</div>'+'<div class="third-part">'+response.data[i]['created_at']+'</div>'+'<div class="second-part">'+response.data[i]['text']+'</div></div>';
                $('#info_panel_add').html('');
                var temp='<div class="form-group"  style="padding:10px"><label for="customer_name">Name</label>  :  <label for="customer_name"  id="customer_name_edit">'+response.data['name']+'</label></div><div class="form-group"     style="padding:10px"><label for="customer_email">Email</label>  :  <label for="customer_email" id="customer_email_edit">'+response.data['email']+'</label></div><div class="form-group"  style="padding:10px"><label for="customer_restaurant">Restaurant Name</label>  :  <label for="customer_restaurant" id="customer_restaurant_edit">'+response.data['restaurant']+'</label></div><div class="form-group"  style="padding:10px"><label for="customer_location">Location</label>  :   <label for="customer_location" id="customer_location_edit">'+response.data['location']+'</label></div>';
                $('#info_panel_add').append(temp);
            }
        });
        
    }  
    
    $('#phone_number').bind('DOMNodeInserted DOMNodeRemoved', function() {
        
        var phone_number=$('#phone_number').text();
        var active_name=phone_number.split(/[.:_]/)[0];
        active_name = active_name.trim();
        var active_number = phone_number.split(/[.:_]/)[1];
        active_number = active_number.trim();
        if(active_name=="undefined"){
         
            // $('#info_panel_add').html('');
            // var temp='<div class="form-group"  style="padding:10px"><label for="customer_name">Name</label><input type="text" class="form-control" id="customer_name" ></div><div class="form-group"  style="padding:10px"><label for="customer_email">Email</label><input type="text" class="form-control" id="customer_email" ></div><div class="form-group"  style="padding:10px">        <label for="customer_restaurant">Restaurant Name</label><input type="text" class="form-control"     id="customer_restaurant" ></div><div class="form-group"  style="padding:10px"><label for="customer_location">Location</label><input type="text" class="form-control" id="customer_location" ></div><div class="form-group"  style="padding:10px"><button type="button" class="btn btn-danger " id="customer_add" style="width:100%">Add</button></div>';
            // $('#info_panel_add').append(temp);
        }else{
           
            $.ajax({
                type:'POST',
                url:'/getInfo',
                data:{number : active_number},
                success:function(response){
                    // var new_chat='<div class="group-rom"><div class="first-part  ">'+response.data[i]['author']+'</div>'+'<div class="third-part">'+response.data[i]['created_at']+'</div>'+'<div class="second-part">'+response.data[i]['text']+'</div></div>';
                    $('#info_panel_add').html('');
                    var temp='<div class="form-group"  style="padding:10px"><label for="customer_name">Name</label>  :  <label for="customer_name"  id="customer_name_edit">'+response.data['name']+'</label></div><div class="form-group"     style="padding:10px"><label for="customer_email">Email</label>  :  <label for="customer_email" id="customer_email_edit">'+response.data['email']+'</label></div><div class="form-group"  style="padding:10px"><label for="customer_restaurant">Restaurant Name</label>  :  <label for="customer_restaurant" id="customer_restaurant_edit">'+response.data['restaurant']+'</label></div><div class="form-group"  style="padding:10px"><label for="customer_location">Location</label>  :   <label for="customer_location" id="customer_location_edit">'+response.data['location']+'</label></div>';
                    $('#info_panel_add').append(temp);
                }
            });
            
        }  
    });
   
    $('.editButton').click(function(){
        
        $('input#customer_name').val($('#customer_name_edit').text());
        $('input#customer_email').val($('#customer_email_edit').text());
        $('input#customer_restaurant').val($('#customer_restaurant_edit').text());
        $('input#customer_location').val($('#customer_location_edit').text());
    });
    $('.numberButton').click(function(){
        
        $('input#customer_name').val('');
        $('input#customer_email').val('');
        $('input#customer_restaurant').val('');
        $('input#customer_location').val('');
    });
   
    // $('#customer_add').click(function(){
      
        // var phone_number=$('#phone_number').text();
        // var active_number = phone_number.split(/[.:_]/)[1];
        // active_number = active_number.trim();
        // var name=$('#customer_name').val();
        // var email=$('#customer_email').val();
        // var restaurant=$('#customer_restaurant').val();
        // var location=$('#customer_location').val();
      
      
        // $.ajax({
        //     type:'POST',
        //     url:'/saveInfo',
        //     data:{number : active_number,name:name,email:email,restaurant:restaurant,location:location},
        //     success:function(response){
        //         window.location.href = "/";
        //     }
        //  });
    // });
});
