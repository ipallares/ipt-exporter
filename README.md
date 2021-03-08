# Introduction
This is just a refactor to https://github.com/ipallares/ipt-exporter/tree/iterator_pattern_spl applying the ***Template Pattern***, both for the exporters as well as for their tests.

We have creaed an abstract class with all common code and some abstract methods which will be implemented by the different Exporter versions (one using ***RecursiveArrayIterator*** and the other one using ***RecursiveIteratorIterator***). This methods are called inside the code and only in execution time will be known which specific implementation is to be ran. Some of the principles and good practices applied with this refactor are:
* ***Polymorfism over if's***. Instead of having ***if's*** in the middle of the code to differenciate the specific code for each implementation we use polymorfism allowing the appropriate method to be ran when needed.
* ***Open Closed Principle***. If we come up with a new implementation for the Exporter, our Code won't need any modification. We will just add the new implementation for the abstract exporter and implement there the specifics of this new class.
* ***DRY***. We are reusing common code so we don't need to repeat it in every Exporter service.

The ***Template Pattern*** can be a little bit tricky to follow when debugging since the execution keeps switching from the parent class to the implementations. However, being familiar with the Pattern helps understand its execution and I think the advantages it brings is worth the complexity.
