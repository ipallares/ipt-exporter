# Using SPL Iterators
PHP offers through its standard library (SPL) different implementations of the ***Iterator Pattern*** to help us traverse different data structures. In this branch following Classes have been used to implement our Exporter:
* ***RecursiveArrayIterator*** 
* ***RecursiveIteratorIterator***

I think that a better name for ***RecursibleArrayIterator*** would be ***RecursibleArrayIterator*** as it gives the possibility to loop a collection in a recursive way (by checking if the item has children) but its default behaviour is just iterating over the first depth level of the array.
***RecursiveIteratorIterator*** on the other hand will go automatically through all depth levels of the collection just with a single loop on our nested collection.

Keeping that in mind ***RecursiveIteratorIterator*** is a better choice for our purpose, even though the amount of code and complexity is not that bigger with the ***RecursiveArrayIterator***.

