<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpConstants</title>
</head>
<body>
    <?php  
        #Constant Variable example
        define("MINSIZE", 50);
        echo MINSIZE;
        echo constant("MINSIZE"); // same thing as the previous line

        // Valid constant names
        define("ONE", "first thing");
        define("TWO2", "second thing");
        define("THREE_3", "third thing")
    ?>
</body>
</html>