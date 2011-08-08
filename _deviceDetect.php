<?php
// ---------------------------------------------
// 	Detect mobile browsers and provide a variable to test against
// ---------------------------------------------
	
// Some variables
	$width = 800; /* Under this is mobile, over is desktop */
	$cookie_expires = 365; /* Ammount of days it takes the cookie to expire */
		
// Default device set . 1 = that's the one
	$test_basic = 1; 
	$test_mobile = 0;
	$test_desktop = 0;
	$test_touch = 0;

/*
	To switch on the front end, simply add one of these to the end of a URL and when the 
	user clicks on it, it will override the automagical detection:
	?device=1 (or true, or blah blah blah. As long as the value is set)
	For example, all the links below will work: 
	
	<h3>Switch To..</h3>
	<ul>
		<li><a href="/?basic=1">Basic</a></li>
		<li><a href="/?mobile=yes">Mobile</a></li>
		<li><a href="/?full=true">Full</a></li>
	</ul>
	
	If for some reason, the url already has a ? in it, just use &:
	<li><a href="/?get=woot&full=1">Desktop</a></li>
	
*/
	
	// we need our functions that we'll be using for the rest of the scripts
	?> 
			<script type="text/javascript">function setCookie(c_name,value,exdays){var exdate=new Date();exdate.setDate(exdate.getDate()+exdays);var c_value=escape(value)+((exdays==null)?"":"; expires="+exdate.toUTCString());document.cookie=c_name+"="+c_value}function getCookie(c_name){var i,x,y,ARRcookies=document.cookie.split(";");for(i=0;i<ARRcookies.length;i++){x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);x=x.replace(/^\s+|\s+$/g,"");if(x==c_name){return unescape(y)}}}function HasClassName(objElement,strClass){if(objElement.className){var arrList=objElement.className.split(' ');var strClassUpper=strClass.toUpperCase();for(var i=0;i<arrList.length;i++){if(arrList[i].toUpperCase()==strClassUpper){return true}}}return false}</script> 
	<?php 
	
// FIRST, have we been through this before? If not, time to process.
	if(!isset($_SESSION['tested']) && !isset($_COOKIE['tested'])) { ?>
		
		<script type="text/javascript">
			
		// OK, NOW down to business. first step, are cookies even usable? 
			setCookie("cookies_enabled","yes",<?php echo $cookie_expires; ?>);

			if(getCookie('cookies_enabled')) {
		
				// So we're not basic. Well then, let's figure out the size	
				var screen_width = window.innerWidth;
				
			// Now, are we dealing with a higher density pixel count? We're targeting 800 REAL pixels. Yes, I'm talking to you Android and iPhone 4	
				var ppi = window.devicePixelRatio;
											
				if(typeof ppi == "undefined") {
					// should be dealing with a 1 ratio browser here
					var width = screen_width;
				} else {
					// Determine the real width				
					var width = screen_width/ppi;			
				}
				
			// Set them cookies
				setCookie("width",screen_width,<?php echo $cookie_expires; ?>);
				setCookie("trueWidth",width,<?php echo $cookie_expires; ?>);
				setCookie("pixelDensity",ppi,<?php echo $cookie_expires; ?>);
				setCookie("smart","yes",<?php echo $cookie_expires; ?>);
				
				// It's a small browser if 
				if(width < <?php echo $width; ?>) {
					setCookie("browser","mobile",<?php echo $cookie_expires; ?>);
				} else {
					setCookie("browser","desktop",<?php echo $cookie_expires; ?>);
				}
			
			// If this isn't set, we have to reload the page so that PHP can read the coookies
				var tested = getCookie('tested'); 
			
				if(!tested) {
					setCookie("tested","yes",<?php echo $cookie_expires; ?>);
					window.location = window.location;
				}
			
			}

		</script>
	
	<?php 		
		// ok, let's tell it we've already tested and move on.
		$_SESSION['tested'] = 'yes';	
	} // end if tested check

	// So, we've tested. Translate that to PHP
		if(isset($_COOKIE['smart'])) {
			$test_basic = 0;
		}
		
		// Mobile or desktop? If the cookie's set, let's tell PHP
		if(isset($_COOKIE['browser'])) {
			switch ($_COOKIE['browser']) {
			    case 'desktop':
					$test_desktop = 1;
			        break;
			    case 'mobile':
					$test_mobile = 1;
			        break;
			 }       
		}

	// Touch? 
		if(isset($_COOKIE['touch'])||isset($_SESSION['touch'])) {
			$_SESSION['touch'] = true;
			$test_touch = 1;
		}

	
// So, we've tested. But, does the user want us to override? 
	// All the possiblities ... 
		$set_basic = strip_tags($_GET['basic']);
		$set_mobile = strip_tags($_GET['mobile']);
		$set_desktop = strip_tags($_GET['full']);

		// if any one of those are set, set the override
		if($set_basic) {
			$_SESSION['override'] = 'basic';				
		} elseif($set_mobile) {
			$_SESSION['override'] = 'mobile';				
		} elseif($set_desktop) {
			$_SESSION['override'] = 'full';				
		}
	
	// If there's an override, reset everything and go with the override	
		if(isset($_SESSION['override'])) {
		
			// let's just reset this stuff to be safe
			$test_basic = 0;
			$test_mobile = 0;
			$test_desktop = 0;
						
			switch ($_SESSION['override']) {
			    case 'basic':
					$test_basic = 1;
			        break;
			    case 'mobile':
					$test_mobile = 1;
			        break;
			    case 'full':
					$test_desktop = 1;
			        break;
			}
			
			// update cookie		
		?>
			<script type="text/javascript">				
				
				var override = "<?php echo $_SESSION['override']; ?>";
				if(override.length > 0) {
					setCookie("browser",override,<?php echo $cookie_expires; ?>);
				}
			</script>
		<?php }// end if override ?>

		<script type="text/javascript">				
			// are we touch? 
			var check = document.getElementsByTagName('html');
			var has = HasClassName(check[0],'touch');

			if(has) {
				setCookie("touch","yes",<?php echo $cookie_expires; ?>);
			} 
		</script>

<?php
	// NOW we finally get to set the constants. 	
		define("BASIC",$test_basic);
		define("MOBILE",$test_mobile);
		define("TOUCH",$test_touch);
		define("DESKTOP",$test_desktop);
	
	// here's some debugging code down here. Comment/uncomment as needed. 
/*
		if(BASIC) {
				echo "I'm BASIC<br/>";
			} 
			
		if(MOBILE) {
			echo "I'm MOBILE<br/>";
		} 

		if(TOUCH) {
			echo "I'm TOUCH<br/>";
		} 
		
		if(DESKTOP) {
			echo "I'm DESKTOP<br/>";
		}
		echo "Supposed Width:".$_COOKIE['width'].'<br/>';
		echo "Pixel Density:".$_COOKIE['pixelDensity'].'<br/>';
		echo "True Width:".$_COOKIE['trueWidth'].'<br/>';
		
*/
			
?>