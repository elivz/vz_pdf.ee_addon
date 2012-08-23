VZ PDF
======

A wrapper for the [dompdf](http://code.google.com/p/dompdf/) library. I wrote this plugin for my own use and you should consider it alpha software. It worked great for me, but I can't promise the same for you. Please report any problems using the "Issues" tab above.

Usage
-----

    {exp:vz_pdf filename="filename.pdf"}
        Content here....
    {/exp:vz_pdf}

Please read the [http://code.google.com/p/dompdf/wiki/CSSCompatibility](dompdf documentation) on CSS compatibility. Most CSS is supported, however there are caveats and certain things don't work exactly the way you would expect. In particular, support for floats is very experimental and is disabled by default. Uncomment the `DOMPDF_ENABLE_CSS_FLOAT` flag in `dompdf/dompdf_config.custom.inc.php` to turn it on.

I have had much better results using absolute URLs--including the domain name--for images and stylesheets.

Parameters
----------

### filename (required)

The name of the PDF file that will be sent to the browser. Should probably end in ".pdf".

### caching="off"

Disable caching of the resulting file to the server. PDF generation is fairly processor-intensive, so it is _highly_ recommended that you don't use this option unless you are actively debugging.

### display="off"

If the `display` attribute is set to `off`, the PDF file will be generated and cached, but not sent to the browser. You might use this to pre-generate files before they are needed.

### in_browser="yes"

If this is set, the PDF file will be displayed inline in the browser, rather than downloaded to the visitor's computer.

### disable="yes"

Disables PDF generation completely and displays the content as a normal ExpressionEngine template. This is very useful for testing your template.

### size="letter"

Set the paper size: `letter`, `legal`, `A4`, etc.

### orientation="portrait"

Set to `landscape` to change the orientation.

Example
-------

    {exp:channel:entries
        channel="pages"
        limit="1"
        require_entry="yes"
        disable="category_fields|member_data|pagination"
    }
    {exp:vz_pdf
        filename="{url_title}.pdf"
        in_browser="yes"
    }
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{title}</title>
        <link rel="stylesheet" href="http://domain.com/assets/styles/pdfs.css">
    </head>
    <body>
        <h1>{title}</h1>
        {page_content}
    </body>
    </html>
    {/exp:vz_pdf}
    {/exp:channel:entries}