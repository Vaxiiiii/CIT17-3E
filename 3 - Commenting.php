<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commenting</title>
</head>
<body>
    <?php
        # This is a comment, and
        # This is the second line of the comment
        // This is a comment too. Each style comments only
        print "An example with single line comments";

        # First Example
        print <<<END
        This uses the "here document" syntax to output
        multiple lines with $variable interpolation. Note
        that the here document terminator must appear on a
        line with just a semicolon no extra whitespace!
        END;
        # Second Example
        print "This spans
        multiple lines. The newlines will be
        output as well";

        /* This is a comment with multiline
        Author : Mohammad Mohtashim
        Purpose: Multiline Comments Demo
        Subject: PHP
        */
        print "An example with multi line comments";
    ?>
</body>
</html>