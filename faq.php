<!--Start FAQ's Dynamic Load data page-->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
$(document).ready(function () {
	var arr1 = getAllUrlParams((window.location).toString());
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200){
            var information = "";
            var object = JSON.parse(this.responseText);
            if (object.length !== 0) {
		for (var i = 0; i < object.length; i++) {
					if( i === 0){
						information = information + "<div class='card'><div class='card-header'><a href='#collapse3-" + i + "' class='collapse'>"+object[i].question+"</a></div><div class='card-body expanded' id='collapse3-" + i + "'><p class='mb-0'>"+object[i].response+"</p></div></div>";
					}else{
						information = information + "<div class='card'><div class='card-header'><a href='#collapse3-" + i + "' class='expand'>"+object[i].question+"</a></div><div class='card-body collapsed' id='collapse3-" + i + "'><p class='mb-0'>"+object[i].response+"</p></div></div>";
					}
				}
                $('#recipe_container').append(information);
            }
        }    
    };
    var url = "api/faq.php?item_id=" + arr1.item_id + "&branch=" + branch_id;
    xhttp.open("GET", url, true);
    xhttp.send();
});
</script>
<!--End FAQ's Dynamic Load data page-->

<section class="faq bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 hidden-sm"> </div>
            <div class="col-lg-6 col-sm-12"> 
                <h2 class="title text-center">FAQ’s</h2>
                    <div class="accordion accordion-icon accordion-simple show-code-action">
                         <div id="recipe_container"></div>   
                    </div>
            </div>
            <div class="col-lg-3 hidden-sm"></div>
        </div>
    </div>
</section>