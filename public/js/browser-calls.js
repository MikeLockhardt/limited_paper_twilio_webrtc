/**
 * Twilio Client configuration for the browser-calls-django
 * example application.
 */

// Store some selectors for elements we'll reuse
var callStatus = $("#call-status");
var answerButton = $(".answer-button");
var callSupportButton = $(".call-support-button");
var hangUpButton = $(".hangup-button");
var callCustomerButtons = $(".call-customer-button");
var emailInput = $(".receiveAddress");
var ticketInput = $(".parent_ticket_id");
var userTicketIdInput = $(".user_ticket_id");

// Get the modal
var modal = document.getElementById("incoming_modal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


/* Helper function to update the call status bar */
function updateCallStatus(status) {
    callStatus.text(status);
}

/* Get a Twilio Client token with an AJAX request */
$(document).ready(function() {
    $.post("/token", {forPage: window.location.pathname}, function(data) {
        // Set up the Twilio Client Device with the token
        Twilio.Device.setup(data.token);
    });

    var scrollElement = document.getElementsByClassName("mid-side");
    scrollElement[0].scrollTop = scrollElement[0].scrollHeight;
});

/* Callback to let us know Twilio Client is ready */
Twilio.Device.ready(function (device) {
    updateCallStatus("Ready");
});

/* Report any errors to the call status display */
Twilio.Device.error(function (error) {
    updateCallStatus("ERROR: " + error.message);
});

/* Callback for when Twilio Client initiates a new connection */
Twilio.Device.connect(function (connection) {
    // Enable the hang up button and disable the call buttons
   
    hangUpButton.prop("disabled", false);
    callCustomerButtons.prop("disabled", true);
    callSupportButton.prop("disabled", true);
    answerButton.prop("disabled", true);

    // If phoneNumber is part of the connection, this is a call from a
    // support agent to a customer's phone
    if ("phoneNumber" in connection.message) {      
        updateCallStatus("In call with " + connection.message.phoneNumber);
    } else {
        // This is a call from a website user to a support agent
        // $.post("/addCallTicket", {side:'client', request_type:'request'}, function(data){
        //     alert(data);
        // });
        updateCallStatus("In call with support");
    }
});

/* Callback for when a call ends */
Twilio.Device.disconnect(function(connection) {
    // Disable the hangup button and enable the call buttons
    hangUpButton.prop("disabled", true);
    callCustomerButtons.prop("disabled", false);
    callSupportButton.prop("disabled", false);
    updateCallStatus("Ready");
    //get post 
    var postParam = {
        "user_ticket_id": connection.message.user_id,
        "side": connection.message.side,
        "request_type": connection.message.request_type
    }
    
    console.log(connection);

    if(connection.message.side=="agency"){
        postRequest("/replyCallTicket", postParam);
    }else if(connection.message.side=="client"){
        postRequest("/clientCallTicket", postParam);
    }
            
    
    
});

/* Callback for when Twilio Client receives a new incoming call */
Twilio.Device.incoming(function(connection) {
    //Show the dialog for incoming call
   
    var modal = document.getElementById("incoming_modal");
    modal.style.display = "block";
    
    updateCallStatus("Incoming support call");
    //hangUpButton.prop("disabled", false);
    // Set a callback to be executed when the connection is accepted
    connection.accept(function() {
        updateCallStatus("In call with customer");
    });

    // Set a callback on the answer button and enable it
    answerButton.click(function() {
        connection.accept();
    });
    answerButton.prop("disabled", false);
});

/* Call a customer from a support ticket */
function callCustomer(phoneNumber, user_id) {
    updateCallStatus("Calling " + phoneNumber + "...");

    var params = {"phoneNumber": phoneNumber, "user_id": user_id, "side":"agency", "request_type":"reply"};
    Twilio.Device.connect(params);
}

/* Call the support_agent from the home page */
function callSupport(user_id) {
    var agency = document.getElementById('select_agency').value;
    updateCallStatus("Calling support...");
    // Our backend will assume that no params means a call to support_agent
    var params = {"user_id": user_id, "side":"client", "request_type":"request", "agency": agency };
    Twilio.Device.connect(params);
    
}

/* End a call */
function hangUp() {

    var modal = document.getElementById("incoming_modal");
    modal.style.display = "none";
    Twilio.Device.disconnectAll();
}

/* Fill out email address */
function configSMS(emailAddress, ticketID, user_id){
    emailInput.val(emailAddress);
    ticketInput.val(ticketID);
    userTicketIdInput.val(user_id);

}

//post function 
function postRequest(path, params, method='post') {
    console.log('===========');
    console.log(params);
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    const form = document.createElement('form');
    form.method = method;
    form.action = path;
  
    for (const key in params) {
      if (params.hasOwnProperty(key)) {
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = key;
        hiddenField.value = params[key];
  
        form.appendChild(hiddenField);
      }
    }
  
    document.body.appendChild(form);
    form.submit();
}


// close call dialog modal box
function closeCallbox(){
    
}