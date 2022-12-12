<?php
    session_start();
    //var_dump($_SESSION['exam']);
    $data = $_SESSION['exam'];
    $title = $data['exam_title'];
    $description = $data['description'];
    $exam_id = $data['exam_id'];
    $user_id = $_SESSION['user_id'];
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


<!DOCTYPE html>
<html>
<style>
        body{
        padding: 20px;
        background: #EEEEEE;
        }
        </style>
    <head>
        <title>
            Take Exam Page
        </title>
    </head>
    <body onload="javascript:changePage(1)">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <h1>GOODLUCK!!!!!</h1>
        <div id="listingTable"></div>
        <div style="float:right;">
        <a class="btn btn-secondary" href="javascript:prevPage()" id="btn_prev"><<</a>
        <a class="btn btn-secondary" href="javascript:nextPage()" id="btn_next">>></a>
        Question: <span id="page">1/3</span><br></div>
        <script>
            var current_page = 1;
            var records_per_page = 1;

            var objJson = document.getElementsByClassName("questions");


            function prevPage()
            {
                if (current_page > 1) {
                    current_page--;
                    changePage(current_page);
                }
            }

            function nextPage()
            {
                if (current_page < numPages()) {
                    current_page++;
                    changePage(current_page);
                }
            }
                
            function changePage(page)
            {
                var btn_next = document.getElementById("btn_next");
                var btn_submit = document.getElementById("submit");
                var btn_prev = document.getElementById("btn_prev");
                var listing_table = document.getElementById("listingTable");
                var page_span = document.getElementById("page");
            
                // Validate page
                if (page < 1) page = 1;
                if (page > numPages()) page = numPages();


                for (var i = 0; i < objJson.length; i++) {
                    if (i == page-1) {
                        objJson[i].style.visibility = "visible";
                    } else {
                        objJson[i].style.visibility = "hidden";
                    }
                }

                page_span.innerHTML = page + "/" + numPages();

                if (page == 1) {
                    btn_prev.style.visibility = "hidden";
                } else {
                    btn_prev.style.visibility = "visible";
                }

                if (page == numPages()) {
                    btn_next.style.visibility = "hidden";
                    btn_submit.style.visibility = "visible";

                } else {
                    btn_next.style.visibility = "visible";
                    btn_submit.style.visibility = "hidden";

                }
            }

            function numPages()
            {
                return Math.ceil(objJson.length / records_per_page);
            }

            window.onload = function() {
                changePage(1);
            };
        </script>




        <?php echo "Exam Name: ".$title."<br>Test Description: ".$description."<br>" ?>
        <form class="form" method="post" action="https://afsaccess4.njit.edu/~jl2237/backend/student_answers.php">
        
            <?php foreach($data['questions'] as $exam){?>
            <div class="card questions" style="position:absolute; width:50%; height:50%; top: 25%; left: 25%;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $exam['question']?></h5>
                    <h6 class="card-subtitle mb-2" style="float:right; color:blue;">Constraint: <?php echo $exam['qconstraint']?></h6>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $exam['points']?> Points</h6>
                    <textarea onkeydown="if(event.keyCode===9){
                        var v=this.value, s=this.selectionStart, e=this.selectionEnd;
                        this.value=v.substring(0, s)+'\t'+v.substring(e);
                        this.selectionStart=this.selectionEnd=s+1;
                        return false;}" 
                        class="textarea form-control mb-2" style="height:60%;" name="answer[]"></textarea>
                </div>
            
        </div>
    <?php 
        echo "<br>";
    }
        ?>
        <input class="btn btn-primary" id="submit" style="position:absolute; top: 76%; left: 69%;" type="submit" value="Submit"/>
        <input type="hidden" name="exam_id" value="<?php echo $exam_id?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id?>">


    </form>
    </body>

</html>
