MarkupBuilder
-------------------------------------
This class is used for building a single-level DOM object using method chaining and dynamic methods.

Dependencies
-------------
 - PHP >= 5.4

Considerations
--------------
 - Implement "Contained" tag creation?
 - Remove $elementName, $attributeName, and $attributes properties and instead just pass that data through
    method arguments?

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