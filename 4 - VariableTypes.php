<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables</title>
</head>
<body>
    <?php
    # Integer Variables Example
    $int_var = 12345;
    $another_int = -12345 + 12345;
    ######################################################################
    
    # Double Variable Example
    $many = 2.2888800;
    $many_2 = 2.2111200;
    $few = $many + $many_2;
    print($many + $many_2 = $few);
    ######################################################################
    
    # Boolean Variabls Example
    if (TRUE)
    print("This will always print<br>");
    else
    print("This will never print<br>");
    #######################################################################

    # You can declare a  boolean variable just by naming true of false and it will become its boolean variable
    $true_num = 3 + 0.14159;
    $true_str = "Tried and true";
    $true_array[49] = "An array element";
    $false_array = array();
    $false_null = NULL;
    $false_num = 999 - 999;
    $false_str = "";

    # You can declare a boolean null
    $my_var = NULL;
    # can also be written like this
    $my_var = null;
    ########################################################################
    
    #Strings
    $string_1 = "This is a string in double quotes";
    $string_2 = "This is a somewhat longer, singly quoted string";
    $string_39 = "This string has thirty-nine characters";
    $string_0 = ""; // a string with zero characters

    # must use quoation around the string of text when using String
    $variable = "name";
    $literally = 'My $variable will not print!\\n';
    print($literally);
    $literally = "My $variable will print!\\n";
    print($literally);
    ###########################################################

    # Assigning Multiple lines of code using "here document"
        $channel =<<<_XML_
    <channel>
    <title>What's For Dinner<title>
    <link>http://menu.example.com/<link>
    <description>Choose what to eat tonight.</description>
    </channel>
    _XML_;
    echo <<<END
    This uses the "here document" syntax to output
    multiple lines with variable interpolation. Note
    that the here document terminator must appear on a
    line with just a semicolon. no extra whitespace!
    <br />
    END;
    print $channel;
    ##########################################################





    ?>
</body>
</html>