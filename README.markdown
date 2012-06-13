VZ PDF
======

Usage
-----

    {exp:vz_pdf filename="filename.pdf"}
        Content here....
    {/exp:vz_pdf}

Please read the [http://code.google.com/p/dompdf/wiki/CSSCompatibility](dompdf documentation) on CSS compatibility. Most CSS is supported, however there are caveats and certain things don't work exactly the way you would expect.

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
        <link rel="stylesheet" href="/assets/styles/pdfs.css">
    </head>
    <body>
        <h1>{title}</h1>
        {page_content}
    </body>
    </html>
    {/exp:vz_pdf}
    {/exp:channel:entries}