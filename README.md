

# Introduction
Academical project meant to help learning some Software Development good practices:
* SOLID principles
* Clean Code
* Clean architecture
* Design patterns

Some code strategies, specially when it comes to patterns, are definitely not the best fit for the need, but the idea is to help understand the principles (also to learn that sometimes it's better to skip them :) ).

# Project Requirements
* Given some initial input data representing a personal CV, export it to a document.
* The initial data source needs to fit to [this json schema](https://github.com/ipallares/ipt-exporter/blob/master/src/exporter/application/services/converter/inputJsonSchemaV1/schema/cv-schema-v1.json) but the code should be ready to accept other formats.
* Initially the generated document will be Docx or PDF but again we want flexibility to be able to generate new document types in the future.
* The exported document will consist of ***Sections*** (*Personal Details, Cover Letter, Body*...), ***Blocks*** (inside body we can have *Work Experiences, Academic Experiences, Other Skills*...) and ***Sub-blocks*** (each single *Work/Academic Experience* for example). The smallest unit to be displayed is the ***Field*** (*Email, Name, Company Name*...).
* Here is an example of what it could be (based on the original https://github.com/ipallares/ipt-exporter/blob/master/README.md). In this case we wanna be totally flexible and allow any *Sections* with any set of *Blocks, Sub-Blocks* and *Fields*, sorted in any order.
![enter image description here](https://github.com/ipallares/ipt-exporter/blob/master/docs/images/cv-generic-layout.png?raw=true)
* In this case we don't need to explicitly cover different ***Content Lengths*** (***Compressed, Extended***...) or ***Layouts*** (*Work Experience* first, *Academic Experiences* first...) as all these details will be covered by the contents we receive in the JSON.

## Generated Files
For our tests we are using two input files [cv1-v1.json](https://github.com/ipallares/ipt-exporter/blob/using_composite_pattern/tests/exporter/application/services/exporter/input-data/cv1-v1.json) and [cv-v1.json](https://github.com/ipallares/ipt-exporter/blob/using_composite_pattern/tests/exporter/application/services/exporter/input-data/cv1-v1.json).
The expected results can be found [here](https://github.com/ipallares/ipt-exporter/tree/using_composite_pattern/tests/exporter/application/services/exporter/expected-documents).
## Applied Patterns
In this implementation we have used the ***Composite Pattern*** (https://refactoring.guru/design-patterns/composite) with some support of the ***Strategy Pattern***. 
For the ***Composite Pattern*** we had to convert the received JSON into a **tree-like structure** where every ***Component*** has the information and code necessary for it to be exported. The ***Component Interface*** of the structure is implemented by ***FieldExporters*** (*Leafs*) and ***SectionExporters*** (*Composites*).
This approach provides total flexibility to the document's layout which would be arranged from Frontend (we can think of some form where ***Sections, Blocks, Fields***... can be dragged and dropped to arrange the contents).
The Strategy Pattern was used to provide an interface for the ***Document Type Generator*** with ***PdfExporter*** and ***DocxExporter*** implementations that can be chosen at runtime.
### Advantages
* When compared to an approach fully based on the ***Strategy Pattern*** we see that the amount of code is way smaller in this case. We can get rid of all ***Value Objects*** (which we were using for every ***Section, Block*** and ***Field*** in other implementations ) as well as removing specific services (which risked some ***Class Explosion***) and all their ***Tests***.
### Disadvantages
* Give a part of the work load to frontend (build the JSON and Validations).
* The code complexity is notably bigger. The Composite Pattern uses recursive execution which increases the difficulty to debug the code. We need a recursive algorithm to build the Composite structure from the JSON and the Composite code is also executed in a recursive fashion. Altogether makes it more difficult to follow than other approaches.
