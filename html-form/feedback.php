<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML FORM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form class="example-form" action="feedback.php" method="post">
        <h1>Feedback</h1>
        <div>Your name:</div>
        <input type="text" name="name">
        <div>Your email address:</div>
        <input type="text" name="email">
        <button id="send" type="submit">Send</button>
    </form>

    <?php
        //storing the values
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];

            // echo $name."<br />".$email."<br />";
        }
        //cleaning function
        function clean($value = "") {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            
            return $value;
        }
        //check length
        function check_length($value = "", $min, $max) {
            $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
            return !$result;
        }
        //clean data
        $name = clean($name);
        $email = clean($email);
        //conditionals
        if(!empty($name) && !empty($email)) {
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
        
            if(check_length($name, 2, 15) && $email_validate) {
                echo "<div class='pop-up'>
                        <div class='pop-up_inside'>
                            <img class='close-button' src='close-button.svg'>
                            <p class='echo-green'>Thanks for the message</p>
                        </div>
                     </div>";
            } else {
                echo "<div class='pop-up'>
                        <div class='pop-up_inside'>
                            <img class='close-button' src='close-button.svg'>
                            <p class='echo'>Incorrect data entered</p>
                        </div>
                     </div>";
            }
        } else {
            echo "<div class='pop-up'>
                    <div class='pop-up_inside'>
                        <img class='close-button' src='close-button.svg'>
                        <p class='echo'>Fill in empty fields</p>
                    </div>
                 </div>";
        }
    ?>

    <script>
        //selectors of pop up
        const popUp = document.getElementsByClassName("pop-up");
        const closeButton = document.getElementsByClassName("close-button");
        //loop through erray and add event listener
        Array.from(closeButton).forEach(e => e.addEventListener("click", function(){
            //loop through pop up elements and delete
            Array.from(popUp).forEach(el => el.remove());
        }));
    </script>

</body>
</html>