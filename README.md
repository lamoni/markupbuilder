MarkupBuilder
-------------------------------------
This class is used for building a single-level DOM object using method chaining and dynamic methods.

Dependencies
-------------
 - PHP >= 5.4

Considerations
--------------
 - Implemented "Contained" tag creation?

Examples
--------

The following code:
------------------------------------------------------------------
```php
    $div = new \Lamoni\MarkupBuilder\MarkupBuilder();

    echo $div->divOpen('myIDHere')
                 ->class('myClassHere')
                 ->madeUpAttribute('theValue')
                 ->attribute_with_hyphen('theHyphenValue');

    echo "CONTENT!";

    echo $div->divClose();

```

will generate the following HTML:

```html
<div id="myIDHere" class="myClassHere" madeUpAttribute="theValue" attribute-with-hyphen="theHyphenValue">
    Content
</div>
```