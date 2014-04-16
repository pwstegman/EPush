<?php $title='Welcome' ; include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<header class="full" id="home">
	
    <div class="container">
        <h1>Deploy anything via Email</h1>
        <p class="lead">EPush your prototype to the world in 3 easy steps™.</p>
	<p>Please note that not all services will be functioning properly during this testing period, and databases may be cleared at any time.</p>	
		<br>

		
        <div class="button" style="display: inline-block">
            <a class="first"> I need an access code! </a>
            <a class="slidein" data-scroll href="#info">
            	Click
            </a>



        </div>
        
        
        <div class="button2" style="display: inline-block">
            <a class="first"> Already have an access code? </a>
            <a class="slidein">
                <input type="text" id="code" onkeypress="handleKeyPress(event, this.form)" placeholder="5 character access code" />

            </a>




        </div>
        

        <script>
                function handleKeyPress(e, form) {
                	console.log(e.keyCode);
                    var key = e.keyCode || e.which;
                    if (key == 13) {
                        window.location = 'http://epush.net/uploads/' + document.getElementById('code').value;
                    }
                }
        </script>

    </div>
    <div style="bottom: -20px; position: absolute; left: 0px; width: 100%;
	text-align: center;">
        <img src="images/email.svg" alt="" style="width: 20%;" class="floating">
    </div>
</header>
<section id="info">
    <div class="container">
        <div class="row">
            <div class="col" style="max-width: 33%;">
                <h3>Step 1</h3>
                <p>Send an email with 'Set Me Up' as the subject to <b>setup@e2d.bymail.in</b>
                    <br>
                </p>
                <img src="images/emailstep.svg" height=100 width=100 class="floating" />


            </div>
            <div class="col" style="max-width: 33%;">
                <h3>Step 2</h3>
                <p>Upon recieving a verification code, send a new message to upload@e2d.bymail.in with a subject of your verification code and attachments.
                    </p>
                <img src="images/wandstep.svg" height=100 width=100 class="floating" />
            </div>
            <div class="col" style="max-width: 33%;">
                <h3>Step 3</h3>
                <p>You're done! Your website will be up at the URL sent in the verification email!
                    <br>You are live.</p>
                <img src="images/livestep.svg" height=100 width=100 class="floating" />

            </div>
        </div>
    </div>
</section>

<script>
 smoothScroll.init({
                easing: 'easeInOutCubic', // Easing pattern to use
                //    offset: 5, // Integer. How far to offset the scrolling anchor location in pixels
            });
</script>
<?php include 'includes/footer.php'; ?>
