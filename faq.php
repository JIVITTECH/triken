<!--Start FAQ's Dynamic Load data page-->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
$(document).ready(function () {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200){
            var information = "";
            var object = JSON.parse(this.responseText);
            if (object.length !== 0) {
		for (var i = 0; i < object.length; i++) {
                    information = information + "<div class='card'><div class='card-header'>"+object[i].id+". <a href='#collapse3-1' class='collapse'>"+object[i].question+"</a></div><div class='card-body expanded' id='collapse3-1'><p class='mb-0'>"+object[i].response+"</p></div></div>";
                }
                $('#recipe_container').append(information);
            }
        }    
    };
    var url = "api/faq.php?branch=1";
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