## Daily / Weekly Report Generation

### Overview

A local web page that helps to generate a new Excel file with a excel sheet for each respective team. Inputs are sent through Slack, which I use to copy and paste into the input fields to compile the excel sheet. 

This is a tool (somewhat crudely done) I personally put together within a day and half, so it's done quite simply. 

### Example of an entry

Today 
- Solved bug #123
- Added feature #234 to master branch

Tomorrow
- Bug #345
- Bug #456
- Bug #567

### Libraries used 

- Bootstrap
- Jquery UI
- Code snippets to convert html to excel

### Interface

The above appears as a drop down for choosing the owner of the entry. Value is the formal name that will be saved in the excel instead. 

    <div class="form-group">
		<label for="names">Who is the individual?</label>
		<select class="form-control"  id="names">
			<option value="Person 1">1</option>
			<option value="Person 2">2</option>
			<option value="Person 3">3</option>
			<option value="Person 4">4</option>
			<option value="Person 5">5</option>
		</select>
	</div>

Interactive section for user to submit entry per user. Empty row is added for space between each user. Text area is the main input for user to input entry of each individual then adding as row to table.

    <form id="submitForm">
		<div class="form-group">
			<label for="tasks">Tasks: </label>
			<textarea class="form-control" id="tasks" rows="6"></textarea>
		</div>
		<button type="button" id="formSubmit class="btn btn-info">Create Table</button>
		<button type="button" id="addEmptyRow" class="btn btn-warning">Add Empty Row</button>
		<button type="button" id="clear" class="btn btn-danger">Clear Field</button>
	</form>

### Time and date 

This is used for adding the dates in the entry sheet itself for showing the date of today and tomorrow. Also date is used for saving the file in this format file_20181205.xls.

    <?php date_default_timezone_set('Asia/Singapore'); ?>

    function  task(str) {
		var  tempStr;
		var  date = '<?=  date("Y-m-d"); ?>';
		
		if(str.toLowerCase().includes('tomorrow')) {
			date = '<?=  date("Y-m-d", time()+86400); ?>';
		}
		
		tempStr = '<tr>'+
		'<td contenteditable="true">'+date+'</td>'+
		'<td contenteditable="true" class="xl75">IT e-commerce</td>'+
		'<td contenteditable="true" class="xl76"></td>'+
		'<td contenteditable="true" class="xl77"><b>'+str+'\'s Tasks'+'</b>';

		 return  tempStr;
	}
