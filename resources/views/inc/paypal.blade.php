<div id="paypal-button-container"></div>
				
						
<script src="https://www.paypal.com/sdk/js?client-id=Ae5vvBSwNudpsdVPRKlK5_lTp1Ge-8lRkFMOhG-WW7aeWzZxsCKLaEm01rSKhoDZTSCqdviS3lG8pfh4&currency=GBP" data-sdk-integration-source="button-factory"></script>
<script>
	// Add your client ID and secret
    var PAYPAL_CLIENT = 'PAYPAL_LIVE_CLIENT';
    var PAYPAL_SECRET = 'PAYPAL_LIVE_SECRET';

  // Point your server to the PayPal API
    var PAYPAL_ORDER_API = 'https://api.paypal.com/v2/checkout/orders/';
	
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'buynow',
		  tagline: false,
      },
	
            // Set up the transaction
            createOrder: function(data, actions) {
				var itemsData = ({name: "{{$lesn->title}}", unit_amount: {currency_code: "GBP",value: "{{$lesn->price}}"},quantity: "1"});
                return actions.order.create({
                    purchase_units: [{
                        amount: {
							currency_code: "GBP",
							value: "{{$lesn->price}}",
							breakdown: {
								item_total: {
								currency_code: "GBP",
							    value: "{{$lesn->price}}",
							}}
							},
							items:  [(itemsData)]
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
					//Add AJAX Call here to update the database
					
					$.ajax({
						type: "GET",
						url: "/transaction_update?uid=" + {{auth()->user()->id}} + "&lid=" + {{$lesn_id}} + "&tx=" + details.id + "&amt=" + {{$lesn->price}},
						cache: false,
						success: function(data){
							
	  						refreshPage();
							
                    	}	
                	});
					
					function refreshPage() {
						location.reload(true);
					}	
	
                    //alert('Transaction completed by ' + details.payer.name.given_name + '! - ' + details.payer + ' - ' + details.amount + ' - ' + details.id );
					//return Redirect::to("/lessons/{{$lesn_id}}")->with('success', 'Your transaction was successfully completed. Enjoy the course!');
                });
	

            }


        }).render('#paypal-button-container');
</script>