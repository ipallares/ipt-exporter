
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
* The exported document will consist of following sections.
![enter image description here](https://github.com/ipallares/ipt-exporter/blob/master/docs/images/cv-generic-layout.png?raw=true)
* Section **CV Body** is composed by 2 blocks **Work Experiences** and **Academic Experiences**.
* There are two possible document layouts: ***Work First*** and ***Academic First***. The application needs to support them both and keep it flexible for new **CV Body** blocks and layouts.
* There are two possible document lengths: ***Compressed*** and ***Extended***. The chosen option determines how much info is included in every section.  The application needs to support them both and keep it flexible for new ones.
* The software will be used by different Recruiting Companies. They will have two blocks at their disposable to include content's of their choice. The application must easily allow adding new Recruiting Companies and their specific contents.

## Generated Files
For our tests we are using [this input data](https://github.com/ipallares/ipt-exporter/blob/master/tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json).  Here is an example of how a ***compressed***, ***academic-first*** export in ***Docx*** format would look like:

    <docx-content>
	    <recruiterheader>My Awesome Recruitment Company</recruiterheader>
    </docx-content>
    <docx-content>
	    <compressed-personaldetails>
		    <name>Max</name>
		    <surname>Mustermann</surname>
	    </compressed-personaldetails>
    </docx-content>
    <docx-content>
	    <recruiterbanner></recruiterbanner>
    </docx-content>
    <docx-content>
	    <compressed-academicexperiences>
		    <compressed-academicexperience>
			    <daterange>01-09-2008 - 30-06-2014</daterange>
			    <schoolname>The IT University</schoolname>
			    <title>Computer Engineer</title>
		    </compressed-academicexperience>
		    <compressed-academicexperience>
			    <daterange>01-09-2006 - 30-06-2008</daterange>
			    <schoolname>The IT Institute</schoolname>
			    <title>Technical Software Developer</title>
		    </compressed-academicexperience>
	    </compressed-academicexperiences>
    </docx-content>
    <docx-content>
		<compressed-workexperiences>
   		    <compressed-workexperience>
				    <daterange>15-11-2016 - 31-05-2018</daterange>
				    <companyname>My Awesome Company</companyname>			    
				    <position>Senior developer</position>		    
			    </compressed-workexperience>    
		    <compressed-workexperience>
			    <daterange>01-08-2014 - 01-10-2018</daterange>
			    <companyname>Another Cool Company</companyname>
			    <position>Senior - intermediate developer</position>
		    </compressed-workexperience>	    
	    </compressed-workexperiences>
    </docx-content>

The expected results for all possible combinations can be found [here](https://github.com/ipallares/ipt-exporter/tree/master/tests/exporter/application/services/exporter/expected-documents)
