<?php

if( $_SERVER["REQUEST_METHOD"] == "POST" ){

    function cleanData($field){
        $field = trim($field); // Remove white space from Start & End
        $field = stripslashes($field); // Code string to convert UnCode String
        $field = htmlspecialchars($field); // Special Characters convert to Html Stander
        return $field;
    }

    $userName = cleanData($_POST['name']);
    $userRoll = cleanData($_POST['roll']);
    $userNumber = cleanData($_POST['number']);
    $userEmail = cleanData($_POST['email']);
    $userDate = cleanData($_POST['date']);


    $sse = "";
    $chv = 0;
    // Name Validation
    if(isset($userName) && $userName != "" && strlen($userName) >= 3 && preg_match("/^[a-zA-Z ]*$/" ,$userName)){
        $sendUserName = $userName;
        $chv += 1;
    }else{
        $ss = "dme";
        $sse .= "Name ";
    }
    
    // Roll Validation
    if(isset($userRoll) && $userRoll != ""){
        $sendUserRoll = $userRoll;
        $chv += 1;
    }else{
        $ss = "dme";
        $sse .= "Roll ";
    }

    // Number Validation
    if(isset($userNumber) && $userNumber != "" && strlen($userNumber) === 11){
        $sendUserNumber = $userNumber;
        $chv += 1;
    }else{
        $ss = "dme";
        $sse .= "Number ";
    }

    // Email Validation
    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        $sendUserEmail = $userEmail;
        $chv += 1;
    }else{
        $ss = "dme";
        $sse .= "Email ";
    }
    
    
    // Date Validation
    if(isset($userDate) && $userDate != ""){
        $sendUserDate = $userDate;
        $chv += 1;
    }else{
        $ss = "dme";
        $sse .= "Date ";
    }

    // Error Handling
    if(isset($sse)){
        if(str_word_count($sse) == 1){
            $sse .= "is invalid";
        }elseif(str_word_count($sse) == 5){
            $sse = "Input Data All the field";
        }elseif(str_word_count($sse) >= 2 && str_word_count($sse) <= 4){
            $sse .= "are invalid";
        }
    }
    

    // Send Data & Success Message
    if(isset($chv) && $chv === 5){
        // echo $chv;
        require "config.php";
        $qr = mysqli_query($mySqli_con, "INSERT INTO `students` (`students_name`, `students_roll`, `students_number`, `students_email`, `students_date`) 
        VALUES ('$userName', '$userRoll', '$userNumber', '$userEmail', '$userDate');") ;
        if($qr){
            $ss = "dms";
            $sss = "Data Send Success Fully";
        }else{
            echo "Not Work";
        }
        mysqli_close($mySqli_con);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Contact Form Validation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="main_sec">
        <div class="form_div">
            <h1>register now<span></span></h1>
            <div class="dynamic_status">
                <span class="<?php if(isset($ss)){ echo $ss; } ?>"><?php if(isset($sse)){ echo $sse ; }if(isset($sss)){ echo $sss ; } ?></span>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="fm_c">
                    <input class="input_same" name="name" type="text" placeholder="Full Name *" 
                    <?php 
                    // if(isset($sendUserName) && $sse == "")
                    // { $dHtml = 'value="'; $dHtml .= $sendUserName . '1st"'; echo $dHtml; }
                    if(isset($sendUserName) && str_word_count($sse) >= 1) 
                    // echo($ssm);
                    {$dHtml = 'value="'; $dHtml .= $sendUserName . '"'; echo $dHtml;}
                    ?>>
                    <input class="input_same" name="roll" type="number" placeholder="Roll *" 
                    <?php if(isset($sendUserRoll) && str_word_count($sse) >= 1)
                    { $dHtml = 'value="'; $dHtml .= $sendUserRoll . '"'; echo $dHtml; } 
                    ?>>
                    <input class="input_same" name="number" type="number" placeholder="Phone Number *" 
                    <?php 
                    if(isset($sendUserNumber) && str_word_count($sse) >= 1)
                    { $dHtml = 'value="'; $dHtml .= $sendUserNumber . '"'; echo $dHtml; } ?>>
                    <input class="input_same" name="email" type="email" placeholder="Email *" 
                    <?php if(isset($sendUserEmail) && str_word_count($sse) >= 1)
                    { $dHtml = 'value="'; $dHtml .= $sendUserEmail . '"'; echo $dHtml; } 
                    ?>>
                    <input class="input_same" name="date" type="date" placeholder="Date" 
                    <?php if(isset($sendUserDate) && str_word_count($sse) >= 1)
                    { $dHtml = 'value="'; $dHtml .= $sendUserDate . '"'; echo $dHtml; } 
                    ?>>
                    <div class="send_btn">
                        <input type="submit" name="submit" value="send info">
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>