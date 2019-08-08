<?php 



$sds = array( 'DELIVERY_STATUS' => array
		        (
		            'type' => 'select',
		            'title' => 'DELIVERY STATUS',
		            'metakey' => 'DELIVERY_STATUS',
		            'options' =>array( 'home', 'pickup' )

		       
		        )

    );


print_r(serialize($sds));


?>