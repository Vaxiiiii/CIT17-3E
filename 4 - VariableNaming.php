<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VairableNaming</title>
</head>
<body>
    <?php
        #local Variable examples
        $x = 4;
        function assignx () {
        $x = 0;
        print "\$x inside function is $x. 
        ";
        }
        assignx();
        print "\$x outside of function is $x. 
        ";
        ###########################################################

        # Function Parameters example
        // multiply a value by 10 and return it to the caller
        function multiply ($value) {
            $value = $value * 10;
            return $value;
        }
        $retval = multiply (10);
        Print "Return value is $retval\n";
        ###########################################################

        # global variables
        $somevar = 15;
        function addit() {
        GLOBAL $somevar;
        $somevar++;
        print "Somevar is $somevar";
        }
        addit();
        ############################################################
        
        #Static Variables
        function keep_track() {
            STATIC $count = 0;
            $count++;
            print $count;
            print "
        ";
        }
        keep_track();
        keep_track();
        keep_track();
        

    ?>
</body>
</html>