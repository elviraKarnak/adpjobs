<?php 
    ob_start(); 

?>
<div class="wrap">
    <h1>Fetch Jobs</h1>
    <form class="fetch_jobs">
    <button type="submit" class="button button-primary button-large">Fetch Jobs</button>
    </form>
    <div class="fetch_status"></div>
</div>


<script>
    jQuery(document).ready(function($) {
        $('.fetch_jobs').on('submit', function(e) {
            e.preventDefault();
            var siteurl = '<?php echo home_url();?>';

            $.ajax({
					url: siteurl+'/wp-admin/admin-ajax.php',
					data: {'action':'fetch_jobs'},
					type:'post',
					success: function(result){
						 //console.log("s");
						//location.reload();
                        //console.log(result);
                        $(".fetch_status").html("<p>Job Fetched.</p>")
					},
					error:function(result){
						console.warn(result);
		
					}
				})
        })
    });
</script>


<?php
  echo "<div class='fetch_form_api'>".ob_get_clean()."</div>";