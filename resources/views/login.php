<?php

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <blockquote>
            <form action="/login" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                <?php if (isset($errormsg)){
                echo $errormsg;
                }?>
                Email:   <input type ="email" name = "email"><br>
                Password:<input type ="password" name="password"><br>
                         <input type="submit" value="LOG IN"/> <br>
            </form>
            
        </blockquote>
        <a href= '<?php echo url('/password/email'); ?>'> <button> reset password </button></a>
    </body>
</html>